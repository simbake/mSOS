Set WshShell = CreateObject("WScript.Shell")
WshShell.Run chr(34) & "C:\xampp\htdocs\msos\bat_files\session_manager\test.bat" & Chr(34), 0
Set WshShell = Nothing