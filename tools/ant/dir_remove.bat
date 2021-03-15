@echo off
setlocal

REM Config: -------------------------------------------------
set BUILDFILE=%~dpn0.xml
set TARGET=%1
set EXTRAS=%2

REM Commands: -------------------------------------------------
set COMMAND=ant -DTargetDir = %TARGET% -f %BUILDFILE%
REM -----------------------------------------------------------

echo.
cmd /c %COMMAND%

REM -----------------------------------------------------------
if "nowait" == "%EXTRAS%" (
	exit /b
) else (
	pause
)
