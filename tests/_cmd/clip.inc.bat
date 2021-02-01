@echo off

rem remove double quotes
set COMMAND=%1
set COMMAND=%COMMAND:"=%

rem Copy COMMAND to clipboard
echo %COMMAND%| clip
echo.
echo Tip: Use right mouse button to exec again or copy-paste: %COMMAND%
echo =======================================================
