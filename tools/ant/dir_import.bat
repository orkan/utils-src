@echo off
setlocal

REM Config: -------------------------------------------------
set BUILDFILE=%~dpn0.xml
set SOURCE=%1
set TARGET=%2
set EXTRAS=%3

REM Commands: -------------------------------------------------
set COMMAND=ant -DSourceDir = %SOURCE% -DTargetDir = %TARGET% -f %BUILDFILE%
REM -----------------------------------------------------------

echo.
cmd /c %COMMAND%

REM -----------------------------------------------------------
if "nowait" == "%EXTRAS%" (
	exit /b
) else (
	pause
)
