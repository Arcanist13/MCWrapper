@echo off

ping 1.1.1.1 -n 1 -w 7000 >nul

wmic process where name="java.exe" CALL setpriority "high"

cls
exit