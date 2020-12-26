# How to repost Notification messages from ADApools.org  to your telegram group?
###### (php, curl example)


1. create new telegram bot via BotFather - https://t.me/BotFather (save APIKEY like: 123456789:AABBCCDDEEFF_HHQQ somewhere)
2. you can „tune“ your bot here – change name, description, profile pic,...
3. add this bot as member into your group
4. write into group some test message from your personal account
5. now you need extract „chat id“ – simply open this url (modify APIKEY with your bot api key) in your browser: https://api.telegram.org/botAPIKEY/getUpdates

in our example like this:

 https://api.telegram.org/bot123456789:AABBCCDDEEFF_HHQQ/getUpdates

and you need find chat > id (not sender_chat, not update_id, really in structure chat > id; there should be only one record with your test message from step 4)

![Example](https://raw.githubusercontent.com/cardanians/adapools.org/master/notifications/i1.png)

so, our chat id is: -1001308187 (with minus char)

6. download script (here: https://raw.githubusercontent.com/cardanians/adapools.org/master/notifications/example-script.php) and upload it on your webhosting - save it for example as: secretscript123.php
7. modify line 25 with your APIKEY
8. modify line 42 with your chat id
9. login on https://adapools.org and manage your (claimed) pool and open tab "Config"
10. insert url of your script into Callback URI, like this: http://yourpoolwebsite.com/secretscript123.php and SAVE.
11. when you open in your browser http://yourpoolwebsite.com/secretscript123.php you should receive blank message into your telegram group; if you have some error, you should see error there.
12. you can uncomment lines 17-22 if you want receive only specific messages into group chat (for ex. only minted blocks or so...)

Do you like it? We are missing some Patreons :) https://adapools.org/donate 
