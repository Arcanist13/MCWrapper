@echo off
title Arcadia
color A

start /min ./motd.bat

start /min ./priority.bat

javac ServerWrap.java
java ServerWrap

echo Server process finished
pause
exit