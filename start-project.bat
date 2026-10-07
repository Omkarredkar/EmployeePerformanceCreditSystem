@echo off
title Employee Performance & Credit Management System

echo ================================================
echo   Employee Performance & Credit Management System
echo ================================================
echo.

echo Starting Spring Boot backend...
start "Employee Performance Backend" cmd /k "cd /d C:\Users\Tanvi\OneDrive\Desktop\EmployeePerformanceCreditSystem_FINAL && mvn spring-boot:run"

echo.
echo Waiting for backend to start...
timeout /t 12 /nobreak >nul

echo Opening application...
start "" "http://localhost/EmployeePerformanceCreditSystem/login.php"

echo.
echo Application opened in your browser.
echo Keep the backend terminal running while using the system.
echo.
pause