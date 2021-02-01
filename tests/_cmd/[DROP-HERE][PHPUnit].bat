@echo off
setlocal

rem -----------------------------------------------------------
set COMMAND=phpunit %1
rem -----------------------------------------------------------

rem Copy COMMAND to clipboard
call clip.inc.bat "%COMMAND%"

echo.
rem /k - keep cmd window open
cmd /k %COMMAND%
echo.
