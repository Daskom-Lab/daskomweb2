@echo off
REM Menjalankan test suite pada PHP 8.5 (Laragon) dengan Redis Laragon (6379).
REM PHP 8.5 dipakai untuk memastikan tidak ada deprecation baru di versi lebih
REM baru dari yang dipakai di mesin developer (8.3).
setlocal
set PHP85=C:\laragon\bin\php\php-8.5.11-Win32-vs17-x64\php.exe

set APP_ENV=testing
set IMAGEKIT_PUBLIC_KEY=test-public-key
set IMAGEKIT_PRIVATE_KEY=test-private-key
set IMAGEKIT_ENDPOINT_URL=https://ik.imagekit.io/test

set DB_CONNECTION=mysql
set DB_HOST=127.0.0.1
set DB_PORT=3307
set DB_DATABASE=phpunit_ai_creds
set DB_USERNAME=root
set DB_PASSWORD=password

set CACHE_STORE=array
set CACHE_PREFIX=
set SESSION_DRIVER=array
set SESSION_DOMAIN=localhost

REM PHP 8.5 Laragon tidak punya ekstensi redis; predis murni PHP.
set REDIS_CLIENT=predis
set REDIS_HOST=127.0.0.1
set REDIS_PORT=6379
set REDIS_PASSWORD=

"%PHP85%" -d error_reporting=E_ALL -d display_errors=1 artisan test %*
endlocal
