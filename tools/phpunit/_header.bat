@echo off
setlocal

REM Display [header] only in DEBUG mode
if "%DEBUG%" == "" exit /b

echo.
echo [BAT] %~1
echo [CWD] %CD%
