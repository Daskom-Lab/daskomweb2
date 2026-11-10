#!/bin/sh
# Verifikasi image aplikasi memenuhi syarat runtime Laravel 13.
#
# Dijalankan di dalam container:
#   docker compose run --rm lms2_web sh docker/verify-image.sh
#
# Keluar dengan kode != 0 bila ada syarat yang tidak terpenuhi.
set -eu

fail=0

check() {
    label="$1"
    shift
    if "$@" >/dev/null 2>&1; then
        echo "  ok   ${label}"
    else
        echo "  FAIL ${label}"
        fail=1
    fi
}

echo "PHP: $(php -v | head -1)"

echo "Ekstensi wajib:"
for ext in pcntl posix pdo pdo_mysql redis mbstring openssl fileinfo tokenizer; do
    if php -m | grep -qix "${ext}"; then
        echo "  ok   ${ext}"
    else
        echo "  FAIL ${ext}"
        fail=1
    fi
done

echo "Composer:"
check "composer --version" composer --version

echo "Aplikasi:"
check "artisan terdaftar" php /app/artisan --version
check "tidak ada dependency hilang" sh -c 'cd /app && composer check-platform-reqs --no-dev'

echo "Proses background (supervisor):"
check "supervisord.conf terbaca" test -f /etc/supervisord.conf
check "supervisor terpasang" command -v supervisord
check "reverb tersedia" sh -c 'cd /app && php artisan list | grep -q "reverb:start"'
check "horizon tersedia" sh -c 'cd /app && php artisan list | grep -q "horizon"'

if [ "${fail}" -ne 0 ]; then
    echo "GAGAL: image belum memenuhi syarat runtime."
    exit 1
fi

echo "SEMUA SYARAT TERPENUHI"
