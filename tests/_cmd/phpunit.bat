@echo off
setlocal
REM echo %~f0

set PATH_GLOBAL=C:\path
set BAT=phpunit.bat

REM One location: vendor\orkan\tvniper\src
set PATH_VENDOR=..\..\..\..\bin
if not exist "%PATH_VENDOR%" (
	REM Second location: tvniper\src
	set PATH_VENDOR=..\..\..\vendor\bin
)
if not exist "%PATH_VENDOR%" (
	echo Vendor dir not found: %PATH_VENDOR% at %CD%
	pause
	exit
)

REM Check if "require-dev: phpunit/phpunit" was loaded by Composer?
REM If PHPUnit namespace present in autoload.php - load it
REM If not - load global PHPUnit from path env
for /f "tokens=*" %%x in ( 'php phpunit-check.php' ) do (

	if "no" == "%%x" (
		set PHPUNIT_PATH=%PATH_GLOBAL%
	) else (
		set PHPUNIT_PATH=%PATH_VENDOR% 
	)

)

pushd %PHPUNIT_PATH%
set PHPUNIT_PATH=%CD%
popd

set COMMAND=%PHPUNIT_PATH%\%BAT%

echo.
echo --------------------------------------------------------------------------------------
echo PHPUnit sel: %~f0
echo PHPUnit cmd: %COMMAND%
echo PHPUnit arg: %*
echo --------------------------------------------------------------------------------------
echo.

call %COMMAND% %*
