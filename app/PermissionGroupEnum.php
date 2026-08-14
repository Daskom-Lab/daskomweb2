<?php

namespace App;

enum PermissionGroupEnum: string
{
    const MANAGE_ROLE = 'manage-role';

    const MANAGE_PRAKTIKUM = 'manage-praktikum';

    const LAPORAN_PRAKTIKUM = 'laporan-praktikum';

    const MANAGE_PLOT = 'manage-plot';

    const MANAGE_MODUL = 'manage-modul';

    const MANAGE_SOAL = 'manage-soal';

    const UNLOCK_JAWABAN = 'unlock-jawaban';

    const TUGAS_PENDAHULUAN = 'tugas-pendahuluan';

    const LMS_CONFIGURATION = 'lms-configuration';

    const MANAGE_PROFILE = 'manage-profile';

    const SEE_PRAKTIKUM = 'see-praktikum';

    const SEE_HISTORY = 'see-history';

    const SEE_SOAL = 'see-soal';

    const NILAI_PRAKTIKAN = 'nilai-praktikan';

    const SEE_PLOT = 'see-plot';

    const RANKING_PRAKTIKAN = 'ranking-praktikan';

    const SEE_POLLING = 'see-polling';

    const SET_PRAKTIKAN = 'set-praktikan';

    const RESET_PRAKTIKAN = 'reset-praktikan';

    const CHECK_TUGAS_PENDAHULUAN = 'check-tugas-pendahuluan';

    const CHANGE_PASSWORD = 'change-password';

    const TP_CONFIGURATION = 'tp-configuration';

    const PRAKTIKAN_REGIST = 'praktikan-regist';

    const LOGOUT = 'logout';

    // permission praktikan
    const LIHAT_PROFILE = 'lihat-profile';

    const LIHAT_NILAI = 'lihat-nilai';

    const LIHAT_MODUL = 'lihat-modul';

    const LIHAT_ASISTEN = 'lihat-asisten';

    const LIHAT_LEADERBOARD = 'lihat-leaderboard';

    const PRAKTIKUM_LMS = 'praktikum-lms';

    const ISI_POLLING = 'isi-polling';

    const GANTI_PASSWORD = 'ganti-password';

    const LOGOUT_PRAKTIKAN = 'logout-praktikan';

    const SUPER_ASLAB = [
        self::MANAGE_ROLE,
    ];

    const ASLAB = [
        self::LAPORAN_PRAKTIKUM,
        self::MANAGE_PLOT,
        self::LMS_CONFIGURATION,
    ];

    const ATC = [
        self::MANAGE_MODUL,
        self::MANAGE_SOAL,
        self::UNLOCK_JAWABAN,
        self::TUGAS_PENDAHULUAN,
    ];

    const RDC = [
        self::MANAGE_PRAKTIKUM,
        self::TP_CONFIGURATION,
        self::PRAKTIKAN_REGIST,
    ];

    const ASISTEN = [
        self::MANAGE_PROFILE,
        self::SEE_PRAKTIKUM,
        self::SEE_HISTORY,
        self::SEE_SOAL,
        self::NILAI_PRAKTIKAN,
        self::SEE_PLOT,
        self::RANKING_PRAKTIKAN,
        self::SEE_POLLING,
        self::SET_PRAKTIKAN,
        self::RESET_PRAKTIKAN,
        self::CHECK_TUGAS_PENDAHULUAN,
        self::CHANGE_PASSWORD,
        self::LOGOUT,
    ];

    const PRAKTIKAN = [
        self::LIHAT_PROFILE,
        self::LIHAT_NILAI,
        self::LIHAT_MODUL,
        self::LIHAT_ASISTEN,
        self::LIHAT_LEADERBOARD,
        self::PRAKTIKUM_LMS,
        self::ISI_POLLING,
        self::GANTI_PASSWORD,
        self::LOGOUT_PRAKTIKAN,
    ];
}
