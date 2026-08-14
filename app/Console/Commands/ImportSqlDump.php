<?php

namespace App\Console\Commands;

use App\PermissionGroupEnum;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ImportSqlDump extends Command
{
    protected $signature = 'db:import-lms1
        {path : Path to the .sql dump file}
        {--connection= : DB connection name to import into (default: database.default)}
        {--dry-run : Parse and validate only; do not execute}
    ';

    protected $description = 'Import a phpMyAdmin .sql dump. Supports temp import and optional legacy→new mapping.';

    public function handle(): int
    {
        $path = $this->argument('path');
        if (! is_file($path)) {
            $this->error("File not found: {$path}");

            return 1;
        }

        $connName = $this->option('connection') ?: config('database.default');
        $conn = DB::connection($connName);

        $importToTemp = true;
        $fromLegacy = true;
        $dryRun = (bool) $this->option('dry-run');

        $databaseName = $this->getDatabaseName($connName);
        if (! $databaseName) {
            $this->error("Could not resolve database name for connection: {$connName}");

            return 1;
        }

        $this->info("Using connection: {$connName}");
        $this->line("Target database: {$databaseName}");

        // Prepare temp database if requested
        $tempDb = null;
        if ($importToTemp) {
            $tempDb = 'import_tmp_'.Str::lower(Str::random(8));
            $this->createDatabase($connName, $tempDb, $dryRun);
            $this->info("Created temp database: {$tempDb}");
        }

        // Import phase
        $targetDbForImport = $importToTemp ? $tempDb : $databaseName;

        $this->info("Beginning import into: {$targetDbForImport}");
        try {
            if (! $dryRun) {
                $this->setForeignKeyChecks($connName, false);
            }

            $this->importSqlFile($connName, $targetDbForImport, $path, $dryRun);

            if (! $dryRun) {
                $this->setForeignKeyChecks($connName, true);
            }
        } catch (Throwable $e) {
            $this->error("Import failed: {$e->getMessage()}");
            $this->dropDatabase($connName, $tempDb, $dryRun);

            return 1;
        }

        $this->info('Import finished.');

        // If from-legacy, transform/copy into current database
        if ($fromLegacy) {
            $this->info("Running legacy → new mapping (from {$tempDb} → {$databaseName})...");

            try {
                $this->runLegacyToNewMapping($connName, $tempDb, $databaseName, $dryRun);
                $this->info('Mapping complete.');
            } catch (Throwable $e) {
                $this->error("Mapping failed: {$e->getMessage()}");
                $this->dropDatabase($connName, $tempDb, $dryRun);

                return 1;
            }
        }

        $this->dropDatabase($connName, $tempDb, $dryRun);
        $this->info("Dropped temp database: {$tempDb}");

        // Ensure the target is at app’s current migration level
        if (! $dryRun && ! $fromLegacy && ! $importToTemp) {
            $this->info('Running migrations to ensure schema is current...');
            $this->call('migrate', ['--force' => true, '--database' => $connName]);
        }

        $this->info('All done ✨');

        return 0;
    }

    private function getDatabaseName(string $connection): ?string
    {
        $config = config("database.connections.{$connection}");

        return $config['database'] ?? null;
    }

    private function createDatabase(string $connection, string $dbName, bool $dryRun): void
    {
        $serverConn = $this->serverConnection($connection);
        $sql = "CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if ($dryRun) {
            $this->line("[dry-run] $sql");

            return;
        }
        DB::connection($serverConn)->statement($sql);
    }

    private function dropDatabase(string $connection, ?string $dbName, bool $dryRun = false): void
    {
        if (! $dbName) {
            return;
        }
        if ($dryRun) {
            $this->line("[dry-run] DROP DATABASE IF EXISTS `{$dbName}`");

            return;
        }
        $serverConn = $this->serverConnection($connection);
        DB::connection($serverConn)->statement("DROP DATABASE IF EXISTS `{$dbName}`");
    }

    private function serverConnection(string $connection): string
    {
        $cfg = config("database.connections.{$connection}");
        $alias = "{$connection}_server";

        // Clone the base connection but ensure a 'database' key exists to satisfy ConnectionFactory.
        // Using NULL or 'information_schema' are both fine for MySQL.
        $serverCfg = $cfg;
        $serverCfg['database'] = $serverCfg['database'] ?? null; // or 'information_schema'

        config(["database.connections.{$alias}" => $serverCfg]);

        return $alias;
    }

    private function setForeignKeyChecks(string $connection, bool $enable): void
    {
        DB::connection($connection)->statement('SET FOREIGN_KEY_CHECKS = '.($enable ? '1' : '0'));
    }

    private function importSqlFile(string $connection, string $database, string $path, bool $dryRun): void
    {
        $pdo = DB::connection($connection)->getPdo();
        if (! $dryRun) {
            $pdo->exec("USE `{$database}`");
        } else {
            $this->line("[dry-run] USE `{$database}`");
        }

        // Stream the file, batching by semicolons. phpMyAdmin dumps don’t use custom DELIMITER—safe to split on ';'
        $handle = fopen($path, 'r');
        if (! $handle) {
            throw new \RuntimeException("Unable to open file: {$path}");
        }

        $buffer = '';
        $lineNo = 0;

        while (($line = fgets($handle)) !== false) {
            $lineNo++;
            // Skip comments
            if (preg_match('/^\s*--/', $line) || preg_match('/^\s*\/\*/', $line)) {
                continue;
            }
            $buffer .= $line;

            // Execute on semicolon boundary (naive but fine for phpMyAdmin dumps)
            if (substr(rtrim($line), -1) === ';') {
                $stmt = trim($buffer);
                $buffer = '';
                if ($stmt === '') {
                    continue;
                }

                if ($dryRun) {
                    // Keep output small: only echo CREATE/ALTER
                    if (preg_match('/^(CREATE|ALTER|INSERT INTO `migrations`)/i', $stmt)) {
                        $this->line('[dry-run] '.substr($stmt, 0, 120).'...');
                    }

                    continue;
                }

                try {
                    DB::connection($connection)->unprepared($stmt);
                } catch (Throwable $e) {
                    fclose($handle);
                    throw new \RuntimeException("SQL error near line {$lineNo}: ".$e->getMessage());
                }
            }
        }

        fclose($handle);
    }

    /**
     * Example mapping from a legacy temp DB into the current (new) DB.
     * Extend these inserts/selects to cover more tables or transformations.
     */
    private function runLegacyToNewMapping(string $connection, string $legacyDb, string $newDb, bool $dryRun): void
    {
        $conn = DB::connection($connection);

        $formatSql = static function (string $sql): string {
            $normalized = preg_replace('/\s+/', ' ', trim($sql));

            return substr($normalized, 0, 180).(strlen($normalized) > 180 ? '…' : '');
        };

        $runStatement = function (string $sql, string $label = '') use ($conn, $dryRun, $formatSql) {
            $preview = $label !== '' ? $label : $formatSql($sql);
            if ($dryRun) {
                $this->line('[dry-run] '.$preview);

                return;
            }

            $conn->statement($sql);
        };

        $seedTimestamp = '2025-01-20 06:40:45';

        $permissionSeed = [
            ['id' => 1, 'name' => 'manage-role', 'guard_name' => 'asisten'],
            ['id' => 2, 'name' => 'manage-praktikum', 'guard_name' => 'asisten'],
            ['id' => 3, 'name' => 'laporan-praktikum', 'guard_name' => 'asisten'],
            ['id' => 4, 'name' => 'manage-plot', 'guard_name' => 'asisten'],
            ['id' => 5, 'name' => 'manage-pelanggaran', 'guard_name' => 'asisten'],
            ['id' => 6, 'name' => 'manage-modul', 'guard_name' => 'asisten'],
            ['id' => 7, 'name' => 'manage-soal', 'guard_name' => 'asisten'],
            ['id' => 8, 'name' => 'unlock-jawaban', 'guard_name' => 'asisten'],
            ['id' => 9, 'name' => 'tugas-pendahuluan', 'guard_name' => 'asisten'],
            ['id' => 10, 'name' => 'see-pelanggaran', 'guard_name' => 'asisten'],
            ['id' => 11, 'name' => 'lms-configuration', 'guard_name' => 'asisten'],
            ['id' => 12, 'name' => 'manage-profile', 'guard_name' => 'asisten'],
            ['id' => 13, 'name' => 'see-praktikum', 'guard_name' => 'asisten'],
            ['id' => 14, 'name' => 'see-history', 'guard_name' => 'asisten'],
            ['id' => 15, 'name' => 'see-soal', 'guard_name' => 'asisten'],
            ['id' => 16, 'name' => 'nilai-praktikan', 'guard_name' => 'asisten'],
            ['id' => 17, 'name' => 'see-plot', 'guard_name' => 'asisten'],
            ['id' => 18, 'name' => 'ranking-praktikan', 'guard_name' => 'asisten'],
            ['id' => 19, 'name' => 'see-polling', 'guard_name' => 'asisten'],
            ['id' => 20, 'name' => 'set-praktikan', 'guard_name' => 'asisten'],
            ['id' => 21, 'name' => 'reset-praktikan', 'guard_name' => 'asisten'],
            ['id' => 22, 'name' => 'check-tugas-pendahuluan', 'guard_name' => 'asisten'],
            ['id' => 23, 'name' => 'change-password', 'guard_name' => 'asisten'],
            ['id' => 24, 'name' => 'praktikan-regist', 'guard_name' => 'asisten'],
            ['id' => 25, 'name' => 'tp-configuration', 'guard_name' => 'asisten'],
            ['id' => 26, 'name' => 'logout', 'guard_name' => 'asisten'],
            ['id' => 27, 'name' => 'lihat-profile', 'guard_name' => 'praktikan'],
            ['id' => 28, 'name' => 'lihat-nilai', 'guard_name' => 'praktikan'],
            ['id' => 29, 'name' => 'lihat-modul', 'guard_name' => 'praktikan'],
            ['id' => 30, 'name' => 'lihat-asisten', 'guard_name' => 'praktikan'],
            ['id' => 31, 'name' => 'praktikum-lms', 'guard_name' => 'praktikan'],
            ['id' => 32, 'name' => 'lihat-leaderboard', 'guard_name' => 'praktikan'],
            ['id' => 33, 'name' => 'isi-polling', 'guard_name' => 'praktikan'],
            ['id' => 34, 'name' => 'ganti-password', 'guard_name' => 'praktikan'],
            ['id' => 35, 'name' => 'logout-praktikan', 'guard_name' => 'praktikan'],
        ];

        foreach ($permissionSeed as &$row) {
            $row['created_at'] = $seedTimestamp;
            $row['updated_at'] = $seedTimestamp;
        }
        unset($row);

        $roleSeed = [
            ['id' => 1, 'name' => 'SOFTWARE', 'guard_name' => 'asisten'],
            ['id' => 2, 'name' => 'KORDAS', 'guard_name' => 'asisten'],
            ['id' => 3, 'name' => 'WAKORDAS', 'guard_name' => 'asisten'],
            ['id' => 4, 'name' => 'KOORPRAK', 'guard_name' => 'asisten'],
            ['id' => 5, 'name' => 'ADMIN', 'guard_name' => 'asisten'],
            ['id' => 6, 'name' => 'HARDWARE', 'guard_name' => 'asisten'],
            ['id' => 7, 'name' => 'DDC', 'guard_name' => 'asisten'],
            ['id' => 8, 'name' => 'ATC', 'guard_name' => 'asisten'],
            ['id' => 9, 'name' => 'RDC', 'guard_name' => 'asisten'],
            ['id' => 10, 'name' => 'CMD', 'guard_name' => 'asisten'],
            ['id' => 11, 'name' => 'HRD', 'guard_name' => 'asisten'],
            ['id' => 12, 'name' => 'MLC', 'guard_name' => 'asisten'],
            ['id' => 13, 'name' => 'PRAKTIKAN', 'guard_name' => 'praktikan'],
        ];

        foreach ($roleSeed as &$row) {
            $row['created_at'] = $seedTimestamp;
            $row['updated_at'] = $seedTimestamp;
        }
        unset($row);

        $packageDefinitions = [
            'super' => PermissionGroupEnum::SUPER_ASLAB,
            'aslab' => array_merge(PermissionGroupEnum::ASLAB, ['manage-pelanggaran']),
            'atc' => PermissionGroupEnum::ATC,
            'rdc' => PermissionGroupEnum::RDC,
            'asisten' => PermissionGroupEnum::ASISTEN,
            'praktikan' => PermissionGroupEnum::PRAKTIKAN,
        ];

        $packageDefinitions['asisten'][] = 'see-pelanggaran';

        $rolePackageMap = [
            'SOFTWARE' => ['super', 'aslab', 'atc', 'rdc', 'asisten'],
            'KORDAS' => ['super', 'aslab', 'atc', 'rdc', 'asisten'],
            'WAKORDAS' => ['super', 'aslab', 'atc', 'rdc', 'asisten'],
            'KOORPRAK' => ['aslab', 'atc', 'rdc', 'asisten'],
            'ADMIN' => ['aslab', 'atc', 'rdc', 'asisten'],
            'HARDWARE' => ['aslab', 'atc', 'rdc', 'asisten'],
            'DDC' => ['rdc', 'atc', 'asisten'],
            'ATC' => ['atc', 'asisten'],
            'RDC' => ['rdc', 'asisten'],
            'CMD' => ['asisten'],
            'HRD' => ['asisten'],
            'MLC' => ['asisten'],
            'PRAKTIKAN' => ['praktikan'],
        ];

        $permissionIdByName = [];
        foreach ($permissionSeed as $row) {
            $permissionIdByName[$row['name']] = $row['id'];
        }

        $packageIds = [];
        foreach ($packageDefinitions as $package => $names) {
            $ids = [];
            foreach ($names as $name) {
                if (! isset($permissionIdByName[$name])) {
                    $this->warn("Permission '{$name}' is referenced in package '{$package}' but was not seeded.");

                    continue;
                }
                $ids[] = $permissionIdByName[$name];
            }
            $packageIds[$package] = array_values(array_unique($ids));
        }

        $roleNameToId = [];
        foreach ($roleSeed as $row) {
            $roleNameToId[$row['name']] = $row['id'];
        }

        $this->info('Resetting permission baseline');
        if ($dryRun) {
            $this->line('[dry-run] SET FOREIGN_KEY_CHECKS = 0');
        } else {
            $conn->statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        foreach (['model_has_permissions', 'model_has_roles', 'role_has_permissions', 'roles', 'permissions'] as $table) {
            $runStatement("TRUNCATE TABLE `{$newDb}`.`{$table}`", "TRUNCATE {$table}");
        }

        if ($dryRun) {
            $this->line('[dry-run] SET FOREIGN_KEY_CHECKS = 1');
        } else {
            $conn->statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        $this->info('Seeding permissions');
        if ($dryRun) {
            $this->line('[dry-run] insert '.count($permissionSeed).' permissions');
        } else {
            $conn->table($newDb.'.permissions')->insert($permissionSeed);
            $conn->statement("ALTER TABLE `{$newDb}`.`permissions` MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT");
        }

        $this->info('Seeding roles');
        if ($dryRun) {
            $this->line('[dry-run] insert '.count($roleSeed).' roles');
        } else {
            $conn->table($newDb.'.roles')->insert($roleSeed);
        }

        $rolePermissionRows = [];
        foreach ($rolePackageMap as $roleName => $packages) {
            if (! isset($roleNameToId[$roleName])) {
                continue;
            }
            $roleId = $roleNameToId[$roleName];
            $permissionIds = [];

            foreach ($packages as $package) {
                $permissionIds = array_merge($permissionIds, $packageIds[$package] ?? []);
            }

            $permissionIds = array_values(array_unique($permissionIds));
            sort($permissionIds);

            foreach ($permissionIds as $permissionId) {
                $rolePermissionRows[] = [
                    'permission_id' => $permissionId,
                    'role_id' => $roleId,
                ];
            }
        }

        $this->info('Assigning role permissions');
        if ($dryRun) {
            $this->line('[dry-run] insert '.count($rolePermissionRows).' role_has_permissions rows');
        } else {
            foreach (array_chunk($rolePermissionRows, 500) as $chunk) {
                $conn->table($newDb.'.role_has_permissions')->insert($chunk);
            }
        }

        $this->info('Mapping: asistens (with role remap)');

        $legacyRoleRows = $conn->select("SELECT id, role FROM `{$legacyDb}`.`roles`");
        $legacyRoleIdToName = [];
        foreach ($legacyRoleRows as $legacyRole) {
            $legacyRoleIdToName[$legacyRole->id] = $legacyRole->role;
        }

        $legacyRoleNameToNew = [
            'KOORDAS' => 'KORDAS',
            'KORDAS' => 'KORDAS',
            'SOFTWARE' => 'SOFTWARE',
            'HARDWARE' => 'HARDWARE',
            'KOORPRAK' => 'KOORPRAK',
            'WAKORDAS' => 'WAKORDAS',
            'ADMIN' => 'ADMIN',
            'ADMIN 1' => 'ADMIN',
            'ADMIN 2' => 'ADMIN',
            'PJ SC ATC' => 'ATC',
            'SC ATC' => 'ATC',
            'A.T.C' => 'ATC',
            'PJ SC HRD' => 'HRD',
            'SC HRD' => 'HRD',
            'H.R.D' => 'HRD',
            'PJ SC MLC' => 'MLC',
            'SC MLC' => 'MLC',
            'M.L.C' => 'MLC',
            'PJ SC RDC' => 'RDC',
            'SC RDC' => 'RDC',
            'R.D.C' => 'RDC',
            'PJ SC CMD' => 'CMD',
            'SC CMD' => 'CMD',
            'C.M.D' => 'CMD',
            'D.D.C' => 'DDC',
            'Detain' => 'DDC',
        ];

        if ($dryRun) {
            $this->line('[dry-run] TRUNCATE asistens');
        } else {
            $conn->statement('SET FOREIGN_KEY_CHECKS = 0');
            $conn->statement("TRUNCATE TABLE `{$newDb}`.`asistens`");
            $conn->statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        $legacyAsistens = $conn->select("SELECT * FROM `{$legacyDb}`.`asistens`");
        $asistenBatch = [];
        $skippedAsistens = 0;

        foreach ($legacyAsistens as $legacyAsisten) {
            $legacyRoleName = $legacyRoleIdToName[$legacyAsisten->role_id] ?? null;
            if (! $legacyRoleName) {
                $skippedAsistens++;

                continue;
            }

            $targetRoleName = $legacyRoleNameToNew[$legacyRoleName] ?? null;
            if (! $targetRoleName || ! isset($roleNameToId[$targetRoleName])) {
                $this->warn("Skipping asisten ID {$legacyAsisten->id} due to unmapped legacy role '{$legacyRoleName}'.");
                $skippedAsistens++;

                continue;
            }

            $password = $legacyAsisten->password;
            if (is_string($password) && Str::startsWith($password, '$2a$')) {
                $password = '$2y$'.substr($password, 4);
            }

            $asistenBatch[] = [
                'id' => $legacyAsisten->id,
                'nama' => $legacyAsisten->nama,
                'kode' => $legacyAsisten->kode,
                'password' => $password,
                'api_token' => $legacyAsisten->api_token,
                'role_id' => $roleNameToId[$targetRoleName],
                'deskripsi' => $legacyAsisten->deskripsi,
                'nomor_telepon' => $legacyAsisten->nomor_telepon,
                'id_line' => $legacyAsisten->id_line,
                'instagram' => $legacyAsisten->instagram,
                'remember_token' => $legacyAsisten->remember_token,
                'created_at' => $legacyAsisten->created_at,
                'updated_at' => $legacyAsisten->updated_at,
            ];
        }

        if ($dryRun) {
            $this->line('[dry-run] insert '.count($asistenBatch).' asistens (skipped '.$skippedAsistens.')');
        } else {
            foreach (array_chunk($asistenBatch, 500) as $chunk) {
                $conn->table($newDb.'.asistens')->insert($chunk);
            }
        }

        $this->info('Syncing model_has_roles for asistens');
        $runStatement(
            "INSERT INTO `{$newDb}`.`model_has_roles` (`role_id`, `model_type`, `model_id`)
             SELECT `role_id`, 'App\\\\Models\\\\Asisten', `id` FROM `{$newDb}`.`asistens`",
            'Populate model_has_roles'
        );

        $runStatement(
            'UPDATE `'.$newDb.'`.`asistens`
             SET `password` = CONCAT(\'$2y$\', SUBSTRING(`password`, 5))
             WHERE `password` LIKE \'$2a$%\'',
            'Normalize asisten password hashes'
        );

        // === CONTINUE WITH REMAINING TABLES ===
        $exec = function (string $sql) use ($conn, $dryRun, $formatSql) {
            if ($dryRun) {
                $this->line('[dry-run] '.$formatSql($sql));

                return;
            }
            $conn->statement($sql);
        };

        $this->info('Mapping: kelas');
        $exec("INSERT IGNORE INTO `{$newDb}`.`kelas` (`id`,`kelas`,`hari`,`shift`,`isEnglish`,`created_at`,`updated_at`,`totalGroup`)
               SELECT id, kelas, hari, shift, 0 as isEnglish, created_at, updated_at, totalGroup
               FROM `{$legacyDb}`.`kelas`");

        $this->info('Mapping: praktikans');
        $exec("INSERT IGNORE INTO `{$newDb}`.`praktikans`
              (`id`,`nama`,`nim`,`password`,`api_token`,`kelas_id`,`alamat`,`nomor_telepon`,`email`,`remember_token`,`created_at`,`updated_at`)
               SELECT id,nama,nim,password,api_token,kelas_id,alamat,nomor_telepon,email,remember_token,created_at,updated_at
               FROM `{$legacyDb}`.`praktikans`");

        $runStatement(
            'UPDATE `'.$newDb.'`.`praktikans`
             SET `password` = CONCAT(\'$2y$\', SUBSTRING(`password`, 5))
             WHERE `password` LIKE \'$2a$%\'',
            'Normalize praktikan password hashes'
        );

        $praktikanRoleId = $roleNameToId['PRAKTIKAN'] ?? null;
        if ($praktikanRoleId) {
            $this->info('Assigning praktikan roles');
            $runStatement(
                "INSERT IGNORE INTO `{$newDb}`.`model_has_roles` (`role_id`, `model_type`, `model_id`)
                 SELECT {$praktikanRoleId} AS role_id, 'App\\\\Models\\\\Praktikan' AS model_type, p.id
                 FROM `{$newDb}`.`praktikans` AS p",
                'Populate praktikan roles'
            );
        } else {
            $this->warn('Skipping praktikan role assignment because PRAKTIKAN role is missing.');
        }

        $this->info('Mapping: moduls');
        $exec("INSERT IGNORE INTO `{$newDb}`.`moduls`
              (`id`,`judul`,`deskripsi`,`created_at`,`updated_at`,`isEnglish`,`isUnlocked`)
               SELECT id, judul, isi AS deskripsi,
                      created_at, updated_at, 0 AS isEnglish, 0 AS isUnlocked
               FROM `{$legacyDb}`.`moduls`");

        $this->info('Mapping: laporan praktikans');
        $exec("INSERT IGNORE INTO `{$newDb}`.`laporan_praktikans`
              (`id`,`pesan`,`rating_praktikum`,`rating_asisten`,`praktikan_id`,`asisten_id`,`modul_id`,`created_at`,`updated_at`)
               SELECT id,pesan,rating_praktikum,rating_asisten,praktikan_id,asisten_id,modul_id,created_at,updated_at
               FROM `{$legacyDb}`.`laporan_praktikans`");

        $this->info('Mapping: soal_fitbs/jurnals/mandiris/tps');
        foreach (['soal_fitbs' => 'soal_fitbs', 'soal_jurnals' => 'soal_jurnals', 'soal_mandiris' => 'soal_mandiris'] as $legacy => $new) {
            $exec("INSERT IGNORE INTO `{$newDb}`.`{$new}` (`id`,`modul_id`,`soal`,`created_at`,`updated_at`)
                   SELECT id, modul_id, soal, created_at, updated_at
                   FROM `{$legacyDb}`.`{$legacy}`");
        }

        $exec("INSERT IGNORE INTO `{$newDb}`.`soal_tps`
              (`id`,`modul_id`,`soal`,`created_at`,`updated_at`)
               SELECT id, modul_id, soal, created_at, updated_at
               FROM `{$legacyDb}`.`soal_tps`");

        $this->info('Mapping: soal_tas (legacy text options → soal_opsis + FK columns)');
        $this->mapTaTk($connection, $legacyDb, $newDb, 'soal_tas', 'soal_tas', 'TA', $exec);
        $this->info('Mapping: soal_tks');
        $this->mapTaTk($connection, $legacyDb, $newDb, 'soal_tks', 'soal_tks', 'TK', $exec);

        $this->info('Mapping: jawaban essays');
        foreach (['jawaban_fitbs' => 'jawaban_fitbs', 'jawaban_jurnals' => 'jawaban_jurnals', 'jawaban_mandiris' => 'jawaban_mandiris', 'jawaban_tps' => 'jawaban_tps'] as $legacy => $new) {
            $exec("INSERT IGNORE INTO `{$newDb}`.`{$new}` (`id`,`praktikan_id`,`soal_id`,`modul_id`,`jawaban`,`created_at`,`updated_at`)
                   SELECT id, praktikan_id, soal_id, modul_id, jawaban, created_at, updated_at
                   FROM `{$legacyDb}`.`{$legacy}`");
        }

        $this->info('Mapping: jawaban_tas/tks → opsi_id (nulling by default)');
        foreach (['jawaban_tas' => 'jawaban_tas', 'jawaban_tks' => 'jawaban_tks'] as $legacy => $new) {
            $exec("INSERT IGNORE INTO `{$newDb}`.`{$new}` (`id`,`praktikan_id`,`soal_id`,`modul_id`,`opsi_id`,`created_at`,`updated_at`)
                   SELECT id, praktikan_id, soal_id, modul_id, NULL AS opsi_id, created_at, updated_at
                   FROM `{$legacyDb}`.`{$legacy}`");
        }

        $this->info('Resolving jawaban opsi references');
        $this->syncJawabanOpsi($conn, $legacyDb, $newDb, 'TA', $dryRun);
        $this->syncJawabanOpsi($conn, $legacyDb, $newDb, 'TK', $dryRun);

        $this->info('Mapping: jadwal_jagas');
        $runStatement("TRUNCATE TABLE `{$newDb}`.`jadwal_jagas`", 'TRUNCATE jadwal_jagas');
        $runStatement(
            "INSERT INTO `{$newDb}`.`jadwal_jagas` (`id`,`kelas_id`,`asisten_id`,`created_at`,`updated_at`)
             SELECT id, kelas_id, asisten_id, created_at, updated_at FROM `{$legacyDb}`.`jadwal_jagas`",
            'Insert jadwal_jagas from legacy'
        );

        $this->info('Mapping: nilais');
        $runStatement("TRUNCATE TABLE `{$newDb}`.`nilais`", 'TRUNCATE nilais');
        $runStatement(
            "INSERT INTO `{$newDb}`.`nilais`
            (`id`,`tp`,`ta`,`d1`,`d2`,`d3`,`d4`,`l1`,`l2`,`avg`,`rating`,`modul_id`,`asisten_id`,`kelas_id`,`praktikan_id`,`created_at`,`updated_at`)
            SELECT n.id, n.tp, n.ta,
                   n.jurnal / 4, n.jurnal / 4, n.jurnal / 4, n.jurnal / 4,
                   n.tk, n.skill,
                   (n.tp + n.ta + n.jurnal + n.skill + n.tk) / 8, n.rating,
                   n.modul_id, n.asisten_id, n.kelas_id, n.praktikan_id, n.created_at, n.updated_at
            FROM `{$legacyDb}`.`nilais` n",
            'Insert nilais from legacy'
        );

        $this->info('Mapping: praktikums');
        $runStatement("TRUNCATE TABLE `{$newDb}`.`praktikums`", 'TRUNCATE praktikums');
        $runStatement(
            "INSERT INTO `{$newDb}`.`praktikums`
            (`id`,`modul_id`,`kelas_id`,`pj_id`,`isActive`,`status`,`current_phase`,`started_at`,`ended_at`,`report_notes`,`report_submitted_at`,`created_at`,`updated_at`)
            SELECT p.id, p.modul_id, p.kelas_id, p.pj_id, 0,
                   'completed', NULL,
                   p.created_at, p.updated_at,
                   COALESCE(CONCAT(lp.allasisten_id, '\\n', lp.laporan), CONCAT('Legacy laporan_id: ', COALESCE(p.laporan_id, 'N/A'))),
                   COALESCE(lp.updated_at, p.updated_at),
                   p.created_at, p.updated_at
            FROM `{$legacyDb}`.`praktikums` p
            LEFT JOIN `{$legacyDb}`.`laporan_pjs` lp ON lp.id = p.laporan_id",
            'Insert praktikums from legacy'
        );

        $this->info('Mapping: configurations');
        $runStatement(
            'INSERT INTO `'.$newDb.'`.`configurations` (`id`, `registrationPraktikan_activation`, `registrationAsisten_activation`, `tp_activation`, `tubes_activation`, `secretfeature_activation`, `polling_activation`, `kode_asisten`, `created_at`, `updated_at`)
             VALUES (1, 0, 1, 0, 1, 1, 0, \'ABC\', \'2025-01-21 14:40:32\', \'2025-01-21 14:41:23\')
             ON DUPLICATE KEY UPDATE
                 `registrationPraktikan_activation` = VALUES(`registrationPraktikan_activation`),
                 `registrationAsisten_activation` = VALUES(`registrationAsisten_activation`),
                 `tp_activation` = VALUES(`tp_activation`),
                 `tubes_activation` = VALUES(`tubes_activation`),
                 `secretfeature_activation` = VALUES(`secretfeature_activation`),
                 `polling_activation` = VALUES(`polling_activation`),
                 `kode_asisten` = VALUES(`kode_asisten`),
                `created_at` = VALUES(`created_at`),
                `updated_at` = VALUES(`updated_at`)',
            'Upsert configurations row'
        );

        $this->info('Mapping: feedback');
        $runStatement("TRUNCATE TABLE `{$newDb}`.`feedback`", 'TRUNCATE feedback');
        $runStatement(
            "INSERT INTO `{$newDb}`.`feedback`
            (`id`,`asisten_id`,`praktikan_id`,`pesan`,`kelas_id`,`read`,`created_at`,`updated_at`)
            SELECT id, asisten_id, praktikan_id, pesan, kelas_id, `read`, created_at, updated_at
            FROM `{$legacyDb}`.`feedback`",
            'Insert feedback from legacy'
        );
    }

    private function mapTaTk(string $connection, string $legacyDb, string $newDb, string $legacyTable, string $newTable, string $type, callable $exec): void
    {
        // 1) Copy base soal rows (without opsi FKs)
        $exec("INSERT IGNORE INTO `{$newDb}`.`{$newTable}` (`id`,`modul_id`,`pertanyaan`,`created_at`,`updated_at`)
               SELECT id, modul_id, pertanyaan, created_at, updated_at
               FROM `{$legacyDb}`.`{$legacyTable}`");

        // 2) Create opsi rows and wire back to soal via UPDATEs
        //    We’ll use INSERT-SELECT union to create opsi rows (3 wrong + 1 correct),
        //    then update the four FK columns by joining on text match.
        foreach (['jawaban_salah1', 'jawaban_salah2', 'jawaban_salah3', 'jawaban_benar'] as $col) {
            $exec("INSERT INTO `{$newDb}`.`soal_opsis` (`soal_type`,`soal_id`,`text`,`created_at`,`updated_at`)
                   SELECT '{$type}', id, {$col}, created_at, updated_at
                   FROM `{$legacyDb}`.`{$legacyTable}`
                   WHERE {$col} IS NOT NULL AND {$col} <> ''");
        }

        // Update FK columns by matching opsi text back to the just-inserted options
        $map = [
            'jawaban_salah1' => 'opsi1_id',
            'jawaban_salah2' => 'opsi2_id',
            'jawaban_salah3' => 'opsi3_id',
            'jawaban_benar' => 'opsi_benar_id',
        ];

        foreach ($map as $legacyTextCol => $fkCol) {
            $exec("
                UPDATE `{$newDb}`.`{$newTable}` s
                JOIN `{$legacyDb}`.`{$legacyTable}` l ON s.id = l.id
                JOIN `{$newDb}`.`soal_opsis` o
                  ON o.soal_type = '{$type}' AND o.soal_id = s.id AND o.text = l.{$legacyTextCol}
                SET s.`{$fkCol}` = o.id
            ");
        }
    }

    private function syncJawabanOpsi(Connection $conn, string $legacyDb, string $newDb, string $type, bool $dryRun): void
    {
        $table = $type === 'TA' ? 'jawaban_tas' : 'jawaban_tks';
        $legacyTable = $type === 'TA' ? 'jawaban_tas' : 'jawaban_tks';

        if ($dryRun) {
            $this->line("[dry-run] resolve {$table}.opsi_id via string compare");

            return;
        }

        $options = $conn->select(
            "SELECT id, soal_id, text FROM `{$newDb}`.`soal_opsis` WHERE soal_type = ?",
            [$type]
        );

        if (empty($options)) {
            return;
        }

        $optionLookup = [];
        foreach ($options as $option) {
            $normalized = $this->normalizeAnswer($option->text ?? '');
            if ($normalized === '' || $normalized === '-') {
                continue;
            }

            $questionId = (int) $option->soal_id;
            if (! isset($optionLookup[$questionId][$normalized])) {
                $optionLookup[$questionId][$normalized] = (int) $option->id;
            }
        }

        if (empty($optionLookup)) {
            return;
        }

        $answers = $conn->select(
            "SELECT jt.id, jt.soal_id, legacy.jawaban
             FROM `{$newDb}`.`{$table}` jt
             JOIN `{$legacyDb}`.`{$legacyTable}` legacy ON legacy.id = jt.id
             WHERE jt.opsi_id IS NULL"
        );

        if (empty($answers)) {
            return;
        }

        $updates = [];
        foreach ($answers as $answer) {
            $normalized = $this->normalizeAnswer($answer->jawaban ?? '');
            if ($normalized === '' || $normalized === '-') {
                continue;
            }

            $questionId = (int) $answer->soal_id;
            if (! isset($optionLookup[$questionId][$normalized])) {
                continue;
            }

            $updates[(int) $answer->id] = $optionLookup[$questionId][$normalized];
        }

        foreach (array_chunk($updates, 500, true) as $chunk) {
            if (empty($chunk)) {
                continue;
            }

            $cases = [];
            $ids = [];
            foreach ($chunk as $id => $optionId) {
                $cases[] = 'WHEN '.(int) $id.' THEN '.(int) $optionId;
                $ids[] = (int) $id;
            }

            if (empty($ids)) {
                continue;
            }

            $sql = "UPDATE `{$newDb}`.`{$table}` SET `opsi_id` = CASE `id` "
                .implode(' ', $cases)
                .' END WHERE `id` IN ('.implode(',', $ids).')';

            $conn->statement($sql);
        }
    }

    private function normalizeAnswer(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $collapsed = preg_replace('/\s+/', ' ', trim($value));

        return Str::lower($collapsed ?? '');
    }
}
