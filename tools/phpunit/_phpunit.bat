@echo off
call %~dp0_header.bat "%~f0"

setlocal
set COMMAND=%*

REM In shortcut:
REM Set current working dir to shortcut location to properly find 'vendor' dir
REM for /f "tokens=*" %%x in ( 'php -f "%~dp0functions.php" get_phpunit_loc' ) do set PHPUNIT=%%x

echo.
echo --------------------------------------------------------------------------------------
echo [Tool] %~f0
echo  [CWD] %CD%
echo  [Cmd] %COMMAND%
echo --------------------------------------------------------------------------------------

if "%DEBUG%" == "" (
	echo.
	%COMMAND%
)
