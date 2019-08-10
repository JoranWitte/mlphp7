<?php
  function skins_getSkins(){
    global $skins_directories;

    $skins = array();
    foreach($skins_directories as $skins_directory_url=>$skins_directory) {
      if(is_dir($skins_directory)){
        if($sd = opendir($skins_directory)){
          while(($file = readdir($sd))!==false){
            if(is_file($skins_directory . $file) && preg_match('/\.zip$/i', $file)){
              $skin = skins_getSkin($skins_directory, $skins_directory_url, $file);
              if($skin!=null){
                //sort the skins
                $creationtime = filectime($skins_directory.$file);
                while(array_key_exists($creationtime, $skins)){
                  $creationtime++;
                }
                $skins[$creationtime] = $skin;
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($skins);
    return $skins;
  }
  
  function skins_getSkin($directory, $directory_url, $file){
    global $skins_default_2d_author;
    global $skins_default_3d_author;
    
    $skin = array();
    $skin['file'] = $directory.$file;
    $skin['url'] = $directory_url.$file;
    $skin['simplename'] = preg_replace('/[\W]/i', '_', preg_replace('/\.zip$/i', '', $file));
    $skin['name'] = $skin['simplename'];
    $skin['2dauthor'] = $skins_default_2d_author;
    $skin['model'] = 'CanyonCar';
    $skin['3dauthor'] = "Nadeo";
    $skin['thumbnail'] = skins_getThumbnail(preg_replace('/\.zip$/i', '', $file));
    return $skin;
  }
  
  function skins_getThumbnail($name){
    global $skins_thumbnails_directories;
    global $skins_thumbnails_extensions;

    foreach ($skins_thumbnails_directories as $skins_thumbnails_directory_url=>$skins_thumbnails_directory) {
      foreach($skins_thumbnails_extensions as $extension){
        if(file_exists("$skins_thumbnails_directory$name.$extension")){
          return "$skins_thumbnails_directory_url$name.$extension";
        }
      }
    }
    return null;
  }
  
  function skins_getSkinWithDetails($skin){
    $infofile = preg_replace('/\.zip$/i', '.txt', $skin['file']);
    if(is_file($infofile)){
      $content = file_get_contents($infofile);
      $lines = explode("\n", $content);
      foreach($lines as $line){
        if(preg_match('/^name=/i', $line)){
          $skin['name'] = trim(preg_replace('/^name=/i', '', $line));
        }
        if(preg_match('/^model=/i', $line)){
          $skin['model'] = trim(preg_replace('/^model=/i', '', $line));
        }
        if(preg_match('/^2D=/i', $line)){
          $skin['2dauthor'] = trim(preg_replace('/^2D=/i', '', $line));
        }
        if(preg_match('/^3D=/i', $line)){
          $skin['3dauthor'] = trim(preg_replace('/^3D=/i', '', $line));
        }


      }
    }
    return $skin;
  }

  function skins_displaySkin($skin, $position){
    global $content_color;
    global $text_color;
    global $skins_skin_price;
    global $manialink;


    $x = -160 + 80*$position;
    
    $skin = skins_getSkinWithDetails($skin);

    $simplename = $skin['simplename'];
    $name = $skin['name'];
    $model = $skin['model'];
    $_2dauthor = $skin['2dauthor'];
    $_3dauthor = $skin['3dauthor'];
    $thumbnail = $skin['thumbnail'];


    echo "  <frame posn='$x 55 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 129' bgcolor='$content_color' />"; echo "\n";
    echo "    <quad id='' posn='5 -3' sizen='70 50' image='$thumbnail' />"; echo "\n";
    echo "    <quad id='' posn='5.5 -55' sizen='10 10'  style='UIConstructionSimple_Buttons' substyle='Drive' />"; echo "\n";
    echo "    <label id='' posn='17 -58' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -66 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -65' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -68' textsize='3' textcolor='$text_color' text='".htmlspecialchars($_2dauthor, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='5.5 -75' sizen='10 10'  style='UIConstructionSimple_Buttons' substyle='Drive' />"; echo "\n";
    echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='".htmlspecialchars($model, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -86 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -85' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -88' textsize='3' textcolor='$text_color' text='".htmlspecialchars($_3dauthor, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -96' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
    echo "    <label id='' posn='17 -98' textsize='3' textcolor='$text_color' text='$skins_skin_price' />"; echo "\n";
    
    

    echo "    <label id='maps' posn='40 -119' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:skin?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }

  function skins_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Skins=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Skins=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Skins=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Skins=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function skins_displaySkins(){
    skins_displaySkinsAt(1);
  }
  
  function skins_displaySkinsAt($n){
    $skins = skins_getSkins();
    
    $number_of_skins = count($skins);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_skins/4))){
      $n = 1;
    }
    startPage();
    $displayed_skins = array_splice($skins, ($n-1)*4, min($n*4, $number_of_skins));
    for($i=0; $i<count($displayed_skins); $i++){
      skins_displaySkin($displayed_skins[$i], $i);
    }
    skins_displayPages($n, max(1, ceil($number_of_skins/4)));
    endPage();
  }
  
  function skins_displayManiacodeSkin(){
    $found = null;
    $skins = skins_getSkins();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($skins as $skin) {
           if($skin['simplename']==$key){
              $found = $skin;
           }
        }
      }
    }

    if($found!=null){
      $found = skins_getSkinWithDetails($found);

      $name = $found['name'];
      $simplename = $found['simplename'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Skins/Vehicles/CarCommon/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8').".zip</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url, ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "</maniacode>";
    }
  }

  function skins_skinsHandle($force){
    if($force){
      skins_displaySkinsAt(1);
    }else if(isset($_GET['Skins'])){
      skins_displaySkinsAt($_GET['Skins']);
      return true;
    }
    return false;
  }
?>