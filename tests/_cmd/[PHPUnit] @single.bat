@echo off
setlocal

rem ------ config ----------
set GROUP=single
rem ------------------------

echo.
echo PHPUnit Group: %GROUP%
echo =============

rem -----------------------------------------------------------
set COMMAND=phpunit --testdox --group %GROUP% %1
rem -----------------------------------------------------------

rem Copy COMMAND to clipboard
call clip.inc.bat "%COMMAND%"

echo.
rem /k - keep cmd window open
cmd /k %COMMAND%
echo.
