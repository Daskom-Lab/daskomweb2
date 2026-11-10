@echo off
REM Menyiapkan data E2E pada container aplikasi.
REM Dijalankan DI DALAM container agar memakai DB_HOST/DB_DATABASE yang sama
REM dengan yang dipakai server — kalau dijalankan dari host, data bisa masuk
REM ke database lain dan login akan gagal.
setlocal
docker compose exec -T -e APP_ENV=local lms2_web sh -c "cd /app && php tests/artisan-e2e.php e2e:seed %*"
endlocal
