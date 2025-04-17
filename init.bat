@echo off
setlocal enabledelayedexpansion

:: === CONFIGURABLE VARIABLES ===
set "PROJECT_ROOT=C:\xampp\htdocs\BlissfulBeginnings"
set "XAMPP_PATH=C:\xampp"
set "HOSTS_FILE=%SystemRoot%\System32\drivers\etc\hosts"
set "VHOSTS_FILE=%XAMPP_PATH%\apache\conf\extra\httpd-vhosts.conf"
set "HTTPD_CONF=%XAMPP_PATH%\apache\conf\httpd.conf"
set "PHP_INI=C:\xampp\php\php.ini"
set "MIGRATIONS_SCRIPT=C:\xampp\htdocs\BlissfulBeginnings\migrations.php"
set "XAMPP_CONTROL=C:\xampp"


set "domains=blissfulbeginnings.com planner.blissfulbeginnings.com vendors.blissfulbeginnings.com cdn.blissfulbeginnings.com"

net session >nul 2>&1
if %errorLevel% NEQ 0 (
    echo Requesting administrative privileges...
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

:: === ADD TO HOSTS FILE ===
echo [*] Adding domains to hosts file...

for %%D in (%domains%) do (
    findstr /C:"%%D" "%HOSTS_FILE%" >nul
    if !errorlevel! equ 0 (
        echo [i] Entry for %%D already exists.
    ) else (
        echo 127.0.0.1      %%D >> "%HOSTS_FILE%"
        echo [✓] Added %%D to hosts file.
    )
)

echo [✓] Hosts file update complete.

:: === ADD TO VHOSTS FILE ===
for %%D in (%domains%) do (
    set "DOMAIN=%%D"
    set "FOLDER="

    if "!DOMAIN!"=="blissfulbeginnings.com" (
        set "FOLDER=%PROJECT_ROOT%\views\blissfulbeginnings.local"
    ) else if "!DOMAIN!"=="planner.blissfulbeginnings.com" (
        set "FOLDER=%PROJECT_ROOT%\views\planner.blissfulbeginnings.local"
    ) else if "!DOMAIN!"=="vendors.blissfulbeginnings.com" (
        set "FOLDER=%PROJECT_ROOT%\views\vendors.blissfulbeginnings.local"
    ) else if "!DOMAIN!"=="cdn.blissfulbeginnings.com" (
        set "FOLDER=%PROJECT_ROOT%\cdn"
    )

    :: Check if domain is already added
    findstr /C:"!DOMAIN!" "%VHOSTS_FILE%" >nul
    if !errorlevel! == 0 (
        echo [i] Virtual host for !DOMAIN! already exists.
    ) else (
        echo. >> "%VHOSTS_FILE%"
        echo ^<VirtualHost *:80^> >> "%VHOSTS_FILE%"
        echo     DocumentRoot "!FOLDER!" >> "%VHOSTS_FILE%"
        echo     ServerName !DOMAIN! >> "%VHOSTS_FILE%"
        echo     ^<Directory "!FOLDER!"^> >> "%VHOSTS_FILE%"
        echo         Options Indexes FollowSymLinks >> "%VHOSTS_FILE%"
        echo         AllowOverride All >> "%VHOSTS_FILE%"
        echo         Require all granted >> "%VHOSTS_FILE%"
        echo     ^</Directory^> >> "%VHOSTS_FILE%"
        echo ^</VirtualHost^> >> "%VHOSTS_FILE%"
        echo [✓] Added virtual host for !DOMAIN! to httpd-vhosts.conf.
    )
)


:: === ENABLE VHOSTS INCLUDE ===
findstr /R "^#*Include conf/extra/httpd-vhosts.conf" "%HTTPD_CONF%" >nul
if %errorlevel%==0 (
    powershell -Command "(Get-Content '%HTTPD_CONF%') -replace '^#(Include\s+conf/extra/httpd-vhosts.conf)', 'Include conf/extra/httpd-vhosts.conf' | Set-Content '%HTTPD_CONF%'"
    echo [✓] Enabled Include for httpd-vhosts.conf in httpd.conf.
) else (
    echo [i] Include already enabled.
)

:: === Enable sockets extension ===
echo [*] Enabling sockets extension in php.ini...

if not exist "%PHP_INI%.bak" (
    copy "%PHP_INI%" "%PHP_INI%.bak"
    echo [i] Backup created: %PHP_INI%.bak
)

set "TEMP_FILE=%PHP_INI%.tmp"
break> "%TEMP_FILE%"
for /f "usebackq delims=" %%A in ("%PHP_INI%") do (
    set "LINE=%%A"
    set "TEST=!LINE:~0,18!"

    if "!TEST!"==";extension=sockets" (
        echo extension=sockets >> "%TEMP_FILE%"
    ) else (
        echo !LINE! >> "%TEMP_FILE%"
    )
)

move /Y "%TEMP_FILE%" "%PHP_INI%" >nul
echo [✓] sockets extension enabled (if it wasn't already).

:: === Restart Apache Server ===
echo.
echo [*] Restarting Apache server...

cd /d "%XAMPP_PATH%"
call apache_stop.bat
timeout /t 2 /nobreak >nul
call apache_start.bat

echo [✓] Apache restarted.

:: === Run Database Migrations ===
echo.
echo [*] Running migrations...
php "%MIGRATIONS_SCRIPT%"

if %errorlevel%==0 (
    echo [✓] Migrations completed successfully.
) else (
    echo [x] There was an error running migrations.
)

echo.
echo All setup steps completed.

pause
