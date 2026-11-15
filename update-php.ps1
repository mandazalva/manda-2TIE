$path = [Environment]::GetEnvironmentVariable('Path', 'Machine')
$oldVersion = 'php-8.1.10-Win32-vs16-x64'
$newVersion = 'php-8.3.33-Win32-vs16-x64'

if ($path -like "*$oldVersion*") {
    $newPath = $path.Replace($oldVersion, $newVersion)
    try {
        [Environment]::SetEnvironmentVariable('Path', $newPath, 'Machine')
        Write-Host "BERHASIL: System PATH berhasil diperbarui ke PHP 8.3.33!" -ForegroundColor Green
    } catch {
        Write-Host "GAGAL: Izin ditolak. Script ini harus dijalankan sebagai Administrator." -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
    }
} else {
    Write-Host "Info: $oldVersion tidak ditemukan di System PATH (mungkin sudah diperbarui ke $newVersion)." -ForegroundColor Yellow
}
