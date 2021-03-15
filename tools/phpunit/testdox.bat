@echo off
call %~dp0_header.bat "%~f0"

setlocal
set VENDOR=%1
set EXTRAS=%2
set INFILE=%3

REM Config: ---------------------------------------------------
REM set SWITCHES=--testdox --stop-on-error --stop-on-failure
set SWITCHES="--testdox --stop-on-error"

call %~dp0_runner.bat %VENDOR% %EXTRAS% %SWITCHES% %INFILE%
