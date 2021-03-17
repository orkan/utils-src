@echo off
setlocal

REM Config: --------------------------------------------
set BUILDFILE=%~dpn0.xml
set SOURCE=%1
set TARGET=%2
set EXTRAS=%3
set YESNO=%~4

REM Confirm: -------------------------------------------
if "%YESNO%" NEQ "" (
	set /p ANSWER=%YESNO% [y/N]: 
)
if "%YESNO%" NEQ "" (
	if "%ANSWER%" NEQ "y" (
		goto :end
	)
)

REM Command: -------------------------------------------
set COMMAND=ant -DSourceDir = %SOURCE% -DTargetDir = %TARGET% -f %BUILDFILE%

REM Run: -----------------------------------------------
echo.
cmd /c %COMMAND%

REM ----------------------------------------------------
:end
if "%EXTRAS%" == "nowait" (
	exit /b
) else (
	pause
)
