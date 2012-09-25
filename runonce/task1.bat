@start "" /b "C:\Program Files\Internet Explorer\iexplore.exe" http://localhost/dict/runonce/wordoftheday.php
@ping -n 4 localhost >nul 2>&1
@tskill iexplore /A