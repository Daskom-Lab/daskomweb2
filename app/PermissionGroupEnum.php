<?php

namespace App;

enum PermissionGroupEnum: string
{
    const MANAGE_ROLE = 'manage-role';
    const MANAGE_PRAKTIKUM = 'manage-praktikum';
    const LAPORAN_PRAKTIKUM = 'laporan-praktikum';
    const MANAGE_PLOT = 'manage-plot';
    const MANAGE_PELANGGARAN = 'manage-pelanggaran';
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
    const SEE_PELANGGARAN = 'see-pelanggaran';
    const SET_PRAKTIKAN = 'set-praktikan';
    const RESET_PRAKTIKAN = 'reset-praktikan';
    const CHECK_TUGAS_PENDAHULUAN = 'check-tugas-pendahuluan';
    const CHANGE_PASSWORD = 'change-password';
    const TP_CONFIGURATION = 'tp-configuration';
    const PRAKTIKAN_REGIST = 'praktikan-regist';
    const LOGOUT = 'logout';
    const DEFAULT = 'default-feature';

    const SUPER_ASLAB =[
        self::MANAGE_ROLE,
    ];
    
    const ASLAB =[
        self::LAPORAN_PRAKTIKUM,
        self::MANAGE_PLOT,
        self::MANAGE_PELANGGARAN,
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
        self::SEE_PELANGGARAN,
    ];
    
    const ASISTEN =[
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


    
}
