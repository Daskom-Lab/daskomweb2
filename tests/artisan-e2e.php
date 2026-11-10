<?php

/**
 * Entry point artisan khusus pengujian.
 *
 * Perintah helper E2E tinggal di tests/ agar tidak ikut ter-deploy, sehingga
 * `php artisan` biasa tidak mengenalnya. Skrip ini mendaftarkan helper
 * tersebut lalu meneruskan argumen ke konsol Laravel.
 *
 * Pemakaian:
 *   php tests/artisan-e2e.php e2e:seed
 */
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->addCommands([
    Tests\Support\SeedE2eData::class,
]);

exit($kernel->handle(
    new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
));
