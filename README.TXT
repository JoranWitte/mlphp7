=====================
 Quick Manialink 1.4
=====================

1. Requirements
~~~~~~~~~~~~~~~
A web server with PHP 5 installed.

2. Features
~~~~~~~~~~~
The manialink is easy to update:
  To add a map on the manialink, the player just has to upload the map and a screenshot in a folder of Quick Manialink.
  To add a screenshot on the manialink, the player just has to upload the screenshot and a thumbnail in a folder of Quick Manialink.
  To add an avatar on the manialink, the player just has to upload the avatar and a screenshot in a folder of Quick Manialink.
  To add a horn on the manialink, the player just has to upload the horn in a folder of Quick Manialink.
  To add a sticker on the manialink, the player just has to upload the files of the sticker and a screenshot in a folder of Quick Manialink.
  To add a stencil on the manialink, the player just has to upload the files of the stencil and a screenshot in a folder of Quick Manialink.
  To add a gamemode on the manialink, the player just has to upload the files of the gamemode and a screenshot in a folder of Quick Manialink.

Ten manialink pages:
  'Maps' page which shows the maps uploaded on the Manialink.
  'Skins' page which shows the skins uploaded on the Manialink.
  'Screenshots' page which shows the screenshots uploaded on the Manialink.
  'Screenshot' page which show the screenshots uploaded on the Manialink in fullscreen.
  'Avatars' page which shows the avatars uploaded on the Manialink.
  'Horns' page which shows the horns uploaded on the Manialink.
  'Stickers' page which shows the stickers uploaded on the Manialink.
  'Stencils' page which shows the stencils uploaded on the Manialink.
  'Gamemodes' page which shows the gamemodes uploaded on the Manialink.
  'About' page which shows the player's description and his favorites servers, manialinks and websites.

Eight maniacodes:
  ':map' to download a map.
  ':skin' to download a skin.
  ':avatar' to download an avatar.
  ':horn' to download a horn.
  ':sticker' to download a sticker.
  ':stencil' to download a brush.
  ':gamemode' to download a gamemode.
  ':donate' to make a donation.

3. Installation
~~~~~~~~~~~~~~~
Upload Quick Manialink on a server which has PHP 5 installed.

Modify the file Config/config.php to change the name of the manialink, the url of the manialink, the colors, the price of the maps, the favorites...
Make sure that you save your config.php file in UTF-8.

Register the following manialinks on http://player.maniaplanet.com/:

  Code: mymanialink (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/manialink.php
  Cost: 0

  Code: mymanialink:map (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodemap.php
  Cost: the price that you set in the file Config/config.php
  
  Code: mymanialink:skin (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodeskin.php
  Cost: the price that you set in the file Config/config.php
  
  Code: mymanialink:avatar (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodeavatar.php
  Cost: the price that you set in the file Config/config.php
  
  Code: mymanialink:horn (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodehorn.php
  Cost: the price that you set in the file Config/config.php

  Code: mymanialink:sticker (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodesticker.php
  Cost: the price that you set in the file Config/config.php

  Code: mymanialink:stencil (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodestencil.php
  Cost: the price that you set in the file Config/config.php

  Code: mymanialink:gamemode (replace mymanialink by the name of the manialink)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodegamemode.php
  Cost: the price that you set in the file Config/config.php
  
  For each donation value
  Code: mymanialink:donate10 (replace mymanialink by the name of the manialink and replace 10 by the value of the donation)
  Url of the XML file: http://www.myserver.com/QuickManialink/maniacodedonate.php?10 (replace 10 by the value of the donation)
  Cost: the value of the donation

4. Utilization
~~~~~~~~~~~~~~
To add a map on the Manialink, the player has to:
  (required) upload the map in the folder Content/Maps of Quick Manialink
  (optional) upload a screenshot (400x290 as on Mania Exchange) in the folder Content/Thumbnails of Quick Manialink
  
To add a skin on the Manialink, the player has to:
  (required) upload the skin in the folder Content/Skins of Quick Manialink
  (required) upload a screenshot (400x290) in the folder Content/Thumbnails of Quick Manialink
  (optional) upload a file NameOfYouSkin.txt in the folder Content/Skins of Quick Manialink with the following content:
    Name=Name of the skin
    Model=Name of the model
    2D=Name of the 2D author
    2D=Name of the 3D author

To add a screenshot on the Manialink, the player has to:
  (required) upload the screenshot in the folder Content/Screenshots of Quick Manialink
  (required) upload a thumbnail of the screenshot (400x290) in the folder Content/Thumbnails of Quick Manialink

To add an avatar on the Manialink, the player has to:
  (required) upload the avatar in the folder Content/Avatars of Quick Manialink
  (optional) upload a screenshot (400x290) in the folder Content/Thumbnails of Quick Manialink
  (optional) upload a file NameOfYouAvatar.txt in the folder Content/Avatars of Quick Manialink with the following content:
    Name=Name of the avatar
    Author=Name of the author

To add a horn on the Manialink, the player has to:
  (required) upload the horn in the folder Content/Horns of Quick Manialink
  (optional) upload a file NameOfYouHorn.txt in the folder Content/Horns of Quick Manialink with the following content:
    Name=Name of the horn
    Author=Name of the author
  
To add a sticker on the Manialink, the player has to:
  (required) create a folder NameOfYourSticker in the folder Content/Stickers of Quick Manialink
  (required) in this folder, upload the files Icon.dds and Sticker.tga of the sticker
  (optional) upload a screenshot (400x290) in the folder Content/Thumbnails of Quick Manialink
  (optional) upload a file NameOfYouSticker.txt in the folder Content/Avatars of Quick Manialink with the following content:
    Name=Name of the sticker
    Author=Name of the author
    
To add a stencil on the Manialink, the player has to:
  (required) create a folder NameOfYourStencil in the folder Content/Stencils of Quick Manialink
  (required) in this folder, upload the files Icon.dds and Brush.tga of the stencil
  (optional) upload a screenshot (400x290) in the folder Content/Thumbnails of Quick Manialink
  (optional) upload a file NameOfYouStencil.txt in the folder Content/Stencils of Quick Manialink with the following content:
    Name=Name of the stencil
    Author=Name of the author

To add a gamemode on the Manialink, the player has to:
  (required) upload the gamemode in the folder Content/Gamemodes of Quick Manialink
  (required) upload a screenshot (400x290) in the folder Content/Thumbnails of Quick Manialink
  (optional) upload the gametype in the folder Content/Gamemodes of Quick Manialink
  (optional) upload a file NameOfYouGamemode.txt in the folder Content/Gamemodes of Quick Manialink with the following content:
    Name=Name of the gamemode
    Author=Name of the author