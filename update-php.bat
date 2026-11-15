@echo off
setlocal
cd /d "%~dp0"

net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Meminta izin Administrator...
    powershell -Command "Start-Process cmd.exe -ArgumentList '/c \"\"%~f0\"\"' -Verb RunAs"
    exit /b
)

echo Menjalankan pembaruan System PATH...
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0update-php.ps1"

echo.
echo Selesai! Silakan restart terminal atau IDE kamu.
pause
