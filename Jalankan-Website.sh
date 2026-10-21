#!/usr/bin/env sh
set -eu
cd "$(dirname "$0")"

if ! command -v php >/dev/null 2>&1; then
  echo "PHP tidak ditemukan. Buka BUKA_DEMO_PRODUK.html untuk demo tanpa server." >&2
  exit 1
fi

missing=""
for extension in mbstring pdo_sqlite dom; do
  if ! php -r "exit(extension_loaded('$extension') ? 0 : 1);"; then
    missing="$missing $extension"
  fi
done

if [ -n "$missing" ]; then
  echo "Ekstensi PHP yang belum aktif:$missing" >&2
  echo "Demo produk tetap dapat dibuka melalui BUKA_DEMO_PRODUK.html." >&2
  exit 1
fi

printf '%s\n' "Website berjalan di http://127.0.0.1:8000"
php -S 127.0.0.1:8000 -t public server.php
