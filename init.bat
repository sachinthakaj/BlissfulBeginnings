@echo off
setlocal enabledelayedexpansion

:: === CONFIGURABLE VARIABLES ===
set "PROJECT_NAME=myproject.local"
set "PROJECT_PATH=C:\xampp\htdocs\myproject"
set "XAMPP_PATH=C:\xampp"
set "HOSTS_FILE=%SystemRoot%\System32\drivers\etc\hosts"
set "VHOSTS_FILE=%XAMPP_PATH%\apache\conf\extra\httpd-vhosts.conf"
set "HTTPD_CONF=%XAMPP_PATH%\apache\conf\httpd.conf"

echo [*] Setting up virtual host: %PROJECT_NAME%

:: === ADD TO HOSTS FILE ===
findstr /C:"%PROJECT_NAME%" "%HOSTS_FILE%" >nul
if %errorlevel%==0 (
    echo [i] Entry already exists in hosts file.
) else (
    echo 127.0.0.1       %PROJECT_NAME% >> "%HOSTS_FILE%"
    echo [✓] Added %PROJECT_NAME% to hosts file.
)

:: === ADD TO VHOSTS FILE ===
findstr /C:"%PROJECT_NAME%" "%VHOSTS_FILE%" >nul
if %errorlevel%==0 (
    echo [i] Virtual host already exists in httpd-vhosts.conf.
) else (
    echo. >> "%VHOSTS_FILE%"
    echo ^<VirtualHost *:80^> >> "%VHOSTS_FILE%"
    echo     ServerAdmin webmaster@%PROJECT_NAME% >> "%VHOSTS_FILE%"
    echo     DocumentRoot "%PROJECT_PATH%" >> "%VHOSTS_FILE%"
    echo     ServerName %PROJECT_NAME% >> "%VHOSTS_FILE%"
    echo     ^<Directory "%PROJECT_PATH%"^> >> "%VHOSTS_FILE%"
    echo         Options Indexes FollowSymLinks >> "%VHOSTS_FILE%"
    echo         AllowOverride All >> "%VHOSTS_FILE%"
    echo         Require all granted >> "%VHOSTS_FILE%"
    echo     ^</Directory^> >> "%VHOSTS_FILE%"
    echo ^</VirtualHost^> >> "%VHOSTS_FILE%"
    echo [✓] Added virtual host to httpd-vhosts.conf.
)

:: === ENABLE VHOSTS INCLUDE ===
findstr /R "^#*Include conf/extra/httpd-vhosts.conf" "%HTTPD_CONF%" >nul
if %errorlevel%==0 (
    powershell -Command "(Get-Content '%HTTPD_CONF%') -replace '^#(Include\s+conf/extra/httpd-vhosts.conf)', 'Include conf/extra/httpd-vhosts.conf' | Set-Content '%HTTPD_CONF%'"
    echo [✓] Enabled Include for httpd-vhosts.conf in httpd.conf.
) else (
    echo [i] Include already enabled.
)

echo [✓] All done! Restart Apache in XAMPP Control Panel to apply changes.

pause
