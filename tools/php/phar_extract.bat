@echo off
echo %~dpnx0
setlocal EnableDelayedExpansion

echo.
echo Archive: %~1

set /p YESNO=Extract^? ^(y/N^):
if /i "!YESNO!" NEQ "Y" exit /b

echo.
set OUTPUT=%~dp1%~n1_phar

call phar.phar.bat extract -f %1 "%OUTPUT%"

echo.
if 0 == %errorlevel% (
	echo Extracted to: %OUTPUT%
	echo BUILD SUCCESSFUL
) else (
	echo BUILD FAILED
)

echo.
pause
