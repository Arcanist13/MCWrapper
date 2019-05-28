@echo off
title Reboot selector
color A

choice /c:FU /n /m "Was this a forced shutdown? (F,U)" /t:10 /d:U
if errorlevel 2 (goto unforced) else (goto forced)

:unforced
echo UNFORCED
start /realtime ./start.bat
goto end

:forced
echo FORCED
goto end


:end
pause
cls
exit