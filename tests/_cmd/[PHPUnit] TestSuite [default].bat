@echo off
setlocal

rem ------ config ----------
set TESTSUITE=default
rem ------------------------

echo.
echo PHPUnit TestSuite: %TESTSUITE%
echo =================

rem -----------------------------------------------------------
set COMMAND=phpunit --testdox --testsuite %TESTSUITE%
rem -----------------------------------------------------------

rem Copy COMMAND to clipboard
call clip.inc.bat "%COMMAND%"

echo.
rem /k - keep cmd window open
cmd /k %COMMAND%
echo.
