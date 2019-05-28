@echo off

g++ -o motd.exe motd.cpp
start "motd" .\motd.exe

cls
exit