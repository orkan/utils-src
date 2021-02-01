@echo off
setlocal

rem -----------------------------------------------------------
REM set COMMAND=phpunit --testdox %1
set COMMAND=phpunit --testdox --stop-on-error %1
rem set COMMAND=phpunit --testdox --stop-on-error --stop-on-failure %~nx1
rem -----------------------------------------------------------

rem Copy COMMAND to clipboard
call clip.inc.bat "%COMMAND%"

echo.
rem /k - keep cmd window open
cmd /k %COMMAND%
echo.
