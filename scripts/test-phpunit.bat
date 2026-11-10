@echo off
REM Menjalankan test suite dengan environment testing yang bersih.
REM Variabel DB_* yang ter-export dari shell/dev .env harus di-unset agar
REM .env.testing (port 3307, database phpunit_ai_creds) benar-benar dipakai.
REM
REM Pemakaian:
REM   scripts\test-phpunit.bat
REM   scripts\test-phpunit.bat --filter=SomeTest
setlocal

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

REM Redis dev/container dipublikasikan di 6380 (lihat .env.testing).
REM Tanpa ini, variabel REDIS_PORT dari shell dev menutupi nilai testing.
set REDIS_CLIENT=phpredis
set REDIS_HOST=127.0.0.1
set REDIS_PORT=6380
set REDIS_PASSWORD=

php -d error_reporting=E_ALL -d display_errors=1 artisan test %*

endlocal
