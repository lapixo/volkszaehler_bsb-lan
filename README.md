# volkszaehler_bsb-lan
A script wich read the bsb-lan parameter an log them to volkszaehler



1. To use this Plugin, upload it to your volkszaehler home directory like "/home/pi"
2. Edit all the uuids in the php Script to your own volkszaehler uuids you created before!
3. Change the "$urlBSBLan" to your own BSB LAN Server
4. Edit your cron with the command "crontab -e" (example for the raspberry pi)
5. Add this line to your crontab "* * * * * /usr/bin/php /home/pi/bsblan.php >/dev/null 2>&1"
   Attention: EDIT THE DIRECTORY!
