@echo off
setlocal enabledelayedexpansion
cd /d "%~dp0"

where php >nul 2>nul
if errorlevel 1 (
  echo PHP tidak ditemukan. Buka BUKA_DEMO_PRODUK.html untuk demo tanpa server.
  pause
  exit /b 1
)

set "MISSING="
for %%E in (mbstring pdo_sqlite dom) do (
  php -r "exit(extension_loaded('%%E') ? 0 : 1);"
  if errorlevel 1 set "MISSING=!MISSING! %%E"
)

if defined MISSING (
  echo Ekstensi PHP yang belum aktif:!MISSING!
  echo Aktifkan ekstensi tersebut di php.ini, lalu jalankan kembali berkas ini.
  echo Demo produk tetap dapat dibuka melalui BUKA_DEMO_PRODUK.html.
  pause
  exit /b 1
)

start "" "http://127.0.0.1:8000"
echo Website berjalan di http://127.0.0.1:8000
php -S 127.0.0.1:8000 -t public server.php
endlocal
