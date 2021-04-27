@echo off
setlocal

REM Config: --------------------------------------------
set SOURCE=%~1
set EXTRAS=%~2

if not exist %SOURCE% (
	echo Source dir not found: %SOURCE%
	exit /b 1
)

REM Run: -----------------------------------------------
echo.
cmd /c ant -DSourceDir="%SOURCE%" -f "%~dpn0.xml"

REM ----------------------------------------------------
:end
popd
if "%EXTRAS%" == "nowait" (
	exit /b
) else (
	pause
)
