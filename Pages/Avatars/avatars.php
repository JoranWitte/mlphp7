<?php
  function avatars_getAvatars(){
    global $avatars_directories;
    global $avatars_extensions;
  
    $avatars = array();
    foreach($avatars_directories as $avatars_directory_url=>$avatars_directory) {
      if(is_dir($avatars_directory)){
        if($sd = opendir($avatars_directory)){
          while(($file = readdir($sd))!==false){
            foreach($avatars_extensions as $extension){
              if(is_file($avatars_directory . $file) && preg_match('/\.'.$extension.'$/i', $file)){
                $avatar = avatars_getAvatar($avatars_directory, $avatars_directory_url, $file, $extension);
                if($avatar!=null){
                  //sort the avatars
                  $creationtime = filectime($avatars_directory.$file);
                  while(array_key_exists($creationtime, $avatars)){
                    $creationtime++;
                  }
                  $avatars[$creationtime] = $avatar;
                }
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($avatars);
    return $avatars;
  }
  
  function avatars_getAvatar($directory, $directory_url, $file, $extension){
    global $avatars_default_author;
    
    $avatar = array();
    $avatar['file'] = $directory.$file;
    $avatar['url'] = $directory_url.$file;
    $avatar['simplename'] = preg_replace('/[\W]/i', '_', preg_replace('/\.'.$extension.'$/i', '', $file));
    $avatar['extension'] = $extension;
    $avatar['name'] = $avatar['simplename'];
    $avatar['author'] = $avatars_default_author;
    $avatar['thumbnail'] = avatars_getThumbnail(preg_replace('/\.'.$extension.'$/i', '', $file));
    return $avatar;
  }
  
  function avatars_getThumbnail($name){
    global $avatars_thumbnails_directories;
    global $avatars_thumbnails_extensions;

    foreach ($avatars_thumbnails_directories as $avatars_thumbnails_directory_url=>$avatars_thumbnails_directory) {
      foreach($avatars_thumbnails_extensions as $extension){
        if(file_exists("$avatars_thumbnails_directory$name.$extension")){
          return "$avatars_thumbnails_directory_url$name.$extension";
        }
      }
    }
    return null;
  }
  
  function avatars_getAvatarWithDetails($avatar){
    $infofile = preg_replace('/\.'. $avatar['extension'].'$/i', '.txt', $avatar['file']);
    if(is_file($infofile)){
      $content = file_get_contents($infofile);
      $lines = explode("\n", $content);
      foreach($lines as $line){
        if(preg_match('/^name=/i', $line)){
          $avatar['name'] = trim(preg_replace('/^name=/i', '', $line));
        }
        if(preg_match('/^author=/i', $line)){
          $avatar['author'] = trim(preg_replace('/^author=/i', '', $line));
        }
      }
    }
    return $avatar;
  }

  function avatars_displayAvatar($avatar, $position){
    global $content_color;
    global $text_color;
    global $avatars_avatar_price;
    global $manialink;


    $x = -160 + 80*$position;
    
    $avatar = avatars_getAvatarWithDetails($avatar);

    $simplename = $avatar['simplename'];
    $name = $avatar['name'];
    $author = $avatar['author'];
    $thumbnail = $avatar['thumbnail'];
    $url = $avatar['url'];


    echo "  <frame posn='$x 55 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 129' bgcolor='$content_color' />"; echo "\n";
    if($thumbnail!=null){
      echo "    <quad id='' posn='5 -3' sizen='70 50' image='$thumbnail' />"; echo "\n";
    }else{
      echo "    <quad id='' posn='15 -3' sizen='50 50' image='$url' />"; echo "\n";
    }
    echo "    <quad id='' posn='6 -56 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -55' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Paint' />"; echo "\n";
    echo "    <label id='' posn='17 -58' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -66 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -65' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -68' textsize='3' textcolor='$text_color' text='".htmlspecialchars($author, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -76' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
    echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='$avatars_avatar_price' />"; echo "\n";
    
    

    echo "    <label id='maps' posn='40 -119' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:avatar?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }

  function avatars_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Avatars=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Avatars=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Avatars=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Avatars=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function avatars_displayAvatars(){
    avatars_displayAvatarsAt(1);
  }
  
  function avatars_displayAvatarsAt($n){
    $avatars = avatars_getAvatars();
    
    $number_of_avatars = count($avatars);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_avatars/4))){
      $n = 1;
    }
    startPage();
    $displayed_avatars = array_splice($avatars, ($n-1)*4, min($n*4, $number_of_avatars));
    for($i=0; $i<count($displayed_avatars); $i++){
      avatars_displayAvatar($displayed_avatars[$i], $i);
    }
    avatars_displayPages($n, max(1, ceil($number_of_avatars/4)));
    endPage();
  }
  
  function avatars_displayManiacodeAvatar(){
    $found = null;
    $avatars = avatars_getAvatars();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($avatars as $avatar) {
           if($avatar['simplename']==$key){
              $found = $avatar;
           }
        }
      }
    }

    if($found!=null){
      $found = avatars_getAvatarWithDetails($found);

      $name = $found['name'];
      $simplename = $found['simplename'];
      $extension = $found['extension'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Skins/Avatars/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8').".".htmlspecialchars($extension, ENT_QUOTES, 'UTF-8')."</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url, ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "</maniacode>";
    }
  }

  function avatars_avatarsHandle($force){
    if($force){
      avatars_displayAvatarsAt(1);
    }else if(isset($_GET['Avatars'])){
      avatars_displayAvatarsAt($_GET['Avatars']);
      return true;
    }
    return false;
  }
?>