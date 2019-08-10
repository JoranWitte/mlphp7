<?php
  /**
   * Server configuration
   */
  //external url of the server hosting the manialink
  //WARNING: Don't forget the character '/' at the end of the url
  $server = 'http://www.joranwitte.nl/tm/';
  //name of the manialink (You have to register it on http://player.maniaplanet.com/)
  $manialink = 'JuvoTM';

  /**
   * Pages
   */
  //list of the pages displayed on the manialink
  //remove from this list the pages that you don't want to display on your manialink
  //the possibilites are 'Maps', 'Skins', 'Screenshots', 'Avatars', 'Horns', 'Stickers', 'Stencils' and 'About'
  //the default page displayed when someone visit the manialink is the first of this array
  $pages = array('About', 'Maps', 'Skins', 'Horns');
  //use this list of pages if every page buttons can't be displayed on a single line
  //$pages2 = array('Avatars', 'Horns', 'Stickers', 'Stencils', 'Gamemodes');

  /**
   * Design
   */
  //title
  $title = '$fff$i$n$oJuvo\'s Trackmania Hub';
  //url of the logo dispayed next to the title (the size of the logo must be arround 160x160)
  //WARNING: the only supported image formats are png, jpg and dds 
  $logo = $server.'Content/JWLogo.png';
  $manialinkimage = $server.'Content/manialinkimage.png';
  //color of the header
  $header_color = '4ad';
  //color of the line under the header
  $header_line_color = '4ad';
  //color of the background
  $background_color = 'fff';
  //color of the rectangles which contain the content
  $content_color = '4ad';
  //color of the text
  $text_color = 'fff';
  //color of the text 'Powered by Quick Manialink'
  $quick_manialink_text_color = '4ad';

  /**
   * Maps
   */
  //price of a map
  $maps_map_price = '0';
  //formatted name of the maps authors
  //each element in this array must be something like 'login'=>'Pretty name'
  $maps_authors = array('Juvo'=>'$fff$i$n$oJuvo');
  //extensions accepted for the screenshots /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $maps_thumbnails_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the maps /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $maps_directories = array($server.'Content/Maps/'=>'Content/Maps/');
  //folders which contain the thumbnails of the maps /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $maps_thumbnails_directories = array($server.'Content/Thumbnails/'=>'Content/Thumbnails/');
  
  /**
   * Skins
   */
  //price of a skin
  $skins_skin_price = '0';
  //author of the skin
  //used only if there is no other 2D author defined in a file SkinName.txt
  $skins_default_2d_author = '$fff$i$n$oJuvo';
  //extensions accepted for the screenshots /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $skins_thumbnails_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the skins /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $skins_directories = array($server.'Content/Skins/'=>'Content/Skins/');
  //folders which contain the thumbnails of the skins /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $skins_thumbnails_directories = array($server.'Content/Thumbnails/'=>'Content/Thumbnails/');
  
  /**
   * Avatars
   */
  //price of an avatar
  $avatars_avatar_price = '0';
  //author of the avatar
  //used only if there is no author defined in a file AvatarName.txt
  $avatars_default_author = '$fff$i$n$oJuvo';
  //extensions accepted for the avatars /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $avatars_extensions = array('png', 'jpg', 'jpeg', 'dds');
  //extensions accepted for the avatars thumbnails /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $avatars_thumbnails_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the maps /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $avatars_directories = array($server.'Content/Avatars/'=>'Content/Avatars/');
  //folders which contain the thumbnails of the avatars /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $avatars_thumbnails_directories = array($server.'Content/Thumbnails/'=>'Content/Thumbnails/');
  
  /**
   * Horns
   */
  //price of a horn
  $horns_horn_price = '0';
  //author of the horn
  //used only if there is no author defined in a file HornName.txt
  $horns_default_author = '$fff$i$n$oJuvo';
  //extensions accepted for the horns /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $horns_extensions = array('ogg', 'wav', 'mux');
  //folders which contain the maps /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $horns_directories = array($server.'Content/Horns/'=>'Content/Horns/');

  /**
   * Stickers
   */
  //price of a sticker
  $stickers_sticker_price = '0';
  //author of the sticker
  //used only if there is no author defined in a file StickerName.txt
  $stickers_default_author = '$fff$i$n$oJuvo';
  //extensions accepted for the stickers thumbnails /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $stickers_thumbnails_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the maps /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $stickers_directories = array($server.'Content/Stickers/'=>'Content/Stickers/');
  //folders which contain the thumbnails of the sticker /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $stickers_thumbnails_directories = array($server.'Content/Thumbnails/'=>'Content/Thumbnails/');

  /**
   * Stencils
   */
  //price of a stencil
  $stencils_stencil_price = '0';
  //author of the stencil
  //used only if there is no author defined in a file StencilName.txt
  $stencils_default_author = '$fff$i$n$oJuvo';
  //extensions accepted for the stencils thumbnails /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $stencils_thumbnails_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the maps /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $stencils_directories = array($server.'Content/Stencils/'=>'Content/Stencils/');
  //folders which contain the thumbnails of the stencil /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $stencils_thumbnails_directories = array($server.'Content/Thumbnails/'=>'Content/Thumbnails/');
  
	/**
   * Gamemodes
   */
  //price of a gamemode
  $gamemodes_gamemode_price = '0';
  //author of the gamemode
  //used only if there is no other author defined in a file GamemodeName.txt
  $gamemodes_default_author = '$fff$i$n$oJuvo';
  //extensions accepted for the screenshots /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $gamemodes_thumbnails_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the gamemodes /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $gamemodes_directories = array($server.'Content/Gamemodes/'=>'Content/Gamemodes/');
  //folders which contain the thumbnails of the gamemodes /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $gamemodes_thumbnails_directories = array($server.'Content/Gamemodes/'=>'Content/Gamemodes/');

  /**
   * Screenshots
   */
  //extensions accepted for the screenshots /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  $screenshots_extensions = array('png', 'jpg', 'jpeg');
  //folders which contain the screenshots /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $screenshots_directories = array($server.'Content/Screenshots/'=>'Content/Screenshots/');
  //folders which contain the thumbnails of the screenshots /!\ MODIFY ONLY IF YOU KNOW WHAT YOU'RE DOING
  //each element of this array must be something like 'external url'=>'local path'
  $screenshots_thumbnails_directories = array($server.'Content/Thumbnails/'=>'Content/Thumbnails/');

  /**
   * About
   */
  //text displayed on the about page
  //use \n to go at the line
  //add \ in front of the $ characters
  $about_presentation = "";
  //list of favorite servers
  //each element of this array must be something like 'pretty server name'=>'join server link'
  $about_servers = array('$06f$oSmurfen.net $n$fffCanyon'=>'maniaplanet://#join=smurfer@TMCanyon', '$06f$oSmurfen.net $n$fffValley'=>'maniaplanet://#join=valleysmurfer@TMValley', '$c00$oJ$00aust$c00F$00aor$c00F$00aun'=>'maniaplanet://#join=Zimsy@Trackmania_2@nadeolabs', '$e80$oSpam Weekly Race'=>'maniaplanet://#join=spam_cup_1@esl_comp@lt_forever', '$eeeM$09fX $eeeKnockout $09fTM2'=>'maniaplanet://#join=mx_knockout@Trackmania_2@nadeolabs', '$d00TM Masters'=>'maniaplanet://#join=tm2m_ttc');
  //list of favorite manialinks
  //each element of this array must be something like 'pretty manialink name'=>'manialink name'
  $about_manialinks = array('$fff$i$n$oJuvoTM'=>'JuvoTM');
  //list of favorite websites
  //each element of this array must be something like 'pretty website name'=>'website url'
  $about_websites = array('$fff$i$n$oWebsite'=>'http://www.joranwitte.nl/trackmania');
  //list of the possible donations (there must be between 1 and 4 donations)
  //each element of this array must be something like 'price'=>'thanks message'
  $about_donations = array('10'=>'Thanks for your donation!', '100'=>'Thanks for your donation!', '250'=>'Thanks for your donation!', '500'=>'Thanks for your donation!');
?>