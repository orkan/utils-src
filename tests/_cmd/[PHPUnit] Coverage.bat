@echo off
setlocal

set PHPUNIT_COVERAGE_DIR=..\_coverage
set PHPUNIT_COVERAGE=--coverage-html %PHPUNIT_COVERAGE_DIR%

rem -----------------------------------------------------------
rem whitelist moved to phpunit.xml
rem set COMMAND=phpunit %PHPUNIT_COVERAGE_WHITELIST% %PHPUNIT_COVERAGE%
set COMMAND=phpunit %PHPUNIT_COVERAGE%
rem -----------------------------------------------------------

rem clear coverag dir
rd /s /q %PHPUNIT_COVERAGE_DIR%

cmd /c %COMMAND%

echo.
pause
