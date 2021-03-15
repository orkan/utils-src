@echo off
call %~dp0_header.bat "%~f0"

setlocal
set COMMAND=%*

echo.
echo Use right mouse button to run again!

REM Copy COMMAND to clip.exe
echo %COMMAND%| clip
