<?php
  function gamemodes_getGamemodes(){
    global $gamemodes_directories;

    $gamemodes = array();
    foreach($gamemodes_directories as $gamemodes_directory_url=>$gamemodes_directory) {
      if(is_dir($gamemodes_directory)){
        if($sd = opendir($gamemodes_directory)){
          while(($file = readdir($sd))!==false){
            if(is_file($gamemodes_directory . $file) && preg_match('/\.Script\.txt$/i', $file) && !preg_match('/Arena\.Script\.txt$/i', $file)){
              $gamemode = gamemodes_getGamemode($gamemodes_directory, $gamemodes_directory_url, $file);
              if($gamemode!=null){
                //sort the gamemodes
                $creationtime = filectime($gamemodes_directory.$file);
                while(array_key_exists($creationtime, $gamemodes)){
                  $creationtime++;
                }
                $gamemodes[$creationtime] = $gamemode;
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($gamemodes);
    return $gamemodes;
  }
  
  function gamemodes_getGamemode($directory, $directory_url, $file){
    global $gamemodes_default_author;

    $gamemode = array();
    $gamemode['file'] = $directory.$file;
    $gamemode['url'] = $directory_url.$file;
    $gamemode['simplename'] = preg_replace('/[\W]/i', '_', preg_replace('/\.Script.txt/i', '', $file));
    $gamemode['name'] = $gamemode['simplename'];
    $gamemode['author'] = $gamemodes_default_author;
    $gamemode['thumbnail'] = gamemodes_getThumbnail(preg_replace('/\.Script.txt$/i', '', $file));
    if(is_file($directory . $gamemode['simplename'] . 'Arena.Script.txt')){
			$gamemode['maptypefile'] = $directory . $gamemode['simplename'] . 'Arena.Script.txt';
			$gamemode['maptypeurl'] = $directory_url . $gamemode['simplename'] . 'Arena.Script.txt';
		}
    return $gamemode;
  }
  
  function gamemodes_getThumbnail($name){
    global $gamemodes_thumbnails_directories;
    global $gamemodes_thumbnails_extensions;

    foreach ($gamemodes_thumbnails_directories as $gamemodes_thumbnails_directory_url=>$gamemodes_thumbnails_directory) {
      foreach($gamemodes_thumbnails_extensions as $extension){
        if(file_exists("$gamemodes_thumbnails_directory$name.$extension")){
          return "$gamemodes_thumbnails_directory_url$name.$extension";
        }
      }
    }
    return null;
  }
  
  function gamemodes_getGamemodeWithDetails($gamemode){
    $infofile = preg_replace('/\.Script.txt$/i', '.txt', $gamemode['file']);
    if(is_file($infofile)){
      $content = file_get_contents($infofile);
      $lines = explode("\n", $content);
      foreach($lines as $line){
        if(preg_match('/^name=/i', $line)){
          $gamemode['name'] = trim(preg_replace('/^name=/i', '', $line));
        }
        if(preg_match('/^author=/i', $line)){
          $gamemode['author'] = trim(preg_replace('/^author=/i', '', $line));
        }
      }
    }
    return $gamemode;
  }

  function gamemodes_displayGamemode($gamemode, $position){
    global $content_color;
    global $text_color;
    global $gamemodes_gamemode_price;
    global $manialink;


    $x = -160 + 80*$position;
    
    $gamemode = gamemodes_getGamemodeWithDetails($gamemode);

    $simplename = $gamemode['simplename'];
    $name = $gamemode['name'];
    $author = $gamemode['author'];
    $thumbnail = $gamemode['thumbnail'];


    echo "  <frame posn='$x 55 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 129' bgcolor='$content_color' />"; echo "\n";
    echo "    <quad id='' posn='5 -3' sizen='70 50' image='$thumbnail' />"; echo "\n";
    echo "    <quad id='' posn='6 -56 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -55' sizen='10 10'  style='UIConstructionSimple_Buttons' substyle='Plugins' />"; echo "\n";
    echo "    <label id='' posn='17 -58' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -66 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -65' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -68' textsize='3' textcolor='$text_color' text='".htmlspecialchars($author, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -76' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
    echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='$gamemodes_gamemode_price' />"; echo "\n";
    
    echo "    <label id='maps' posn='40 -119' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:gamemode?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }

  function gamemodes_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Gamemodes=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Gamemodes=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Gamemodes=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Gamemodes=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function gamemodes_displayGamemodes(){
    gamemodes_displayGamemodesAt(1);
  }
  
  function gamemodes_displayGamemodesAt($n){
    $gamemodes = gamemodes_getGamemodes();
    
    $number_of_gamemodes = count($gamemodes);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_gamemodes/4))){
      $n = 1;
    }
    startPage();
    $displayed_gamemodes = array_splice($gamemodes, ($n-1)*4, min($n*4, $number_of_gamemodes));
    for($i=0; $i<count($displayed_gamemodes); $i++){
      gamemodes_displayGamemode($displayed_gamemodes[$i], $i);
    }
    gamemodes_displayPages($n, max(1, ceil($number_of_gamemodes/4)));
    endPage();
  }
  
  function gamemodes_displayManiacodeGamemode(){
    $found = null;
    $gamemodes = gamemodes_getGamemodes();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($gamemodes as $gamemode) {
           if($gamemode['simplename']==$key){
              $found = $gamemode;
           }
        }
      }
    }

    if($found!=null){
      $found = gamemodes_getGamemodeWithDetails($found);

      $name = $found['name'];
      $simplename = $found['simplename'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_script>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Scripts/Modes/ShootMania/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8').".Script.txt</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url, ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_script>"; echo "\n";
      if(array_key_exists('maptypeurl', $found)){
				$maptypeurl = $found['maptypeurl'];
	      echo "  <install_script>"; echo "\n";
	      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."Arena</name>"; echo "\n";
	      echo "    <file>Scripts/MapTypes/ShootMania/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8')."Arena.Script.txt</file>"; echo "\n";
	      echo "    <url>".htmlspecialchars($maptypeurl, ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
	      echo "  </install_script>"; echo "\n";
			}                                
      echo "</maniacode>";
    }
  }

  function gamemodes_gamemodesHandle($force){
    if($force){
      gamemodes_displayGamemodesAt(1);
    }else if(isset($_GET['Gamemodes'])){
      gamemodes_displayGamemodesAt($_GET['Gamemodes']);
      return true;
    }
    return false;
  }
?>