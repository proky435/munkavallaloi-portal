@echo off
cd /d "c:\Users\DELL\Desktop\GITHUB\munkavallaloi-portal\development\munkavallaloi-portal"
php artisan data-changes:process-scheduled >> storage/logs/scheduled_data_changes.log 2>&1
