@echo off
pushd %~dp1

setlocal
set INFILE=%1
set EXTRAS=%2

REM Command: --------------------------------------------------
set COMMAND=php -f %INFILE%

REM Switch: ---------------------------------------------------
if "%EXTRAS%" == "nowait" (
	set SWITCH=/c
) else (
	set SWITCH=/k
	echo.
	echo ====================================
	echo Use right mouse button to run again!
	echo %COMMAND%| clip
)

REM Run: ------------------------------------------------------
echo.
cmd %SWITCH% %COMMAND%

popd
