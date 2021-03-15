@echo off

setlocal

REM Retrieve absolute path to vendor dir
pushd %1
set ABS=%CD%\bin\phpunit.bat
popd

REM Add quotes if path have spaces
for /f "tokens=1-2 delims= " %%a in ( "%ABS%" ) do set SPACES=%%b
if "%SPACES%" NEQ "" (
	set ABS="%ABS%"
)

echo %ABS%
