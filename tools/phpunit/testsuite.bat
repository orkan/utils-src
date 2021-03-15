@echo off
call %~dp0_header.bat "%~f0"

setlocal
set VENDOR=%1
set EXTRAS=%2
set TESTSUITE=%~3

REM Config: ---------------------------------------------------
REM if "%TESTSUITE%" == "" set TESTSUITE=default
set SWITCHES="--testdox --testsuite %TESTSUITE%"

echo.
echo PHPUnit TestSuite: %TESTSUITE%
echo =================

call %~dp0_runner.bat %VENDOR% %EXTRAS% %SWITCHES%
