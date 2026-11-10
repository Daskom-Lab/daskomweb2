#!/bin/sh
set -e

# Volume kosong tetap berupa direktori, jadi cek keberadaan autoload.php,
# bukan keberadaan folder vendor/, agar composer install benar-benar jalan.
if [ ! -f /app/vendor/autoload.php ]; then
    echo "vendor/ kosong, menjalankan composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Set permissions for Laravel directories
chown -R www-data:www-data /app/storage /app/bootstrap/cache
chmod -R 775 /app/storage /app/bootstrap/cache

mkdir -p /var/log/supervisor/

exec "$@"
