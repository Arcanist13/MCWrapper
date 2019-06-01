@echo off
title Arcadia
color A

cd C:\MC\Spigot

echo Changing motd
start /min .\motd.bat

echo Starting priority bat
start /min .\priority.bat

cd C:\MC\Spigot\web
start .\webserver.bat
cd C:\MC\Spigot

echo Compiling Server
javac ServerWrap.java
echo Starting Server
java ServerWrap

echo Server process finished
pause
exit
