<?php
  function horns_getHorns(){
    global $horns_directories;
    global $horns_extensions;
  
    $horns = array();
    foreach($horns_directories as $horns_directory_url=>$horns_directory) {
      if(is_dir($horns_directory)){
        if($sd = opendir($horns_directory)){
          while(($file = readdir($sd))!==false){
            foreach($horns_extensions as $extension){
              if(is_file($horns_directory . $file) && preg_match('/\.'.$extension.'$/i', $file)){
                $horn = horns_getHorn($horns_directory, $horns_directory_url, $file, $extension);
                if($horn!=null){
                  //sort the horns
                  $creationtime = filectime($horns_directory.$file);
                  while(array_key_exists($creationtime, $horns)){
                    $creationtime++;
                  }
                  $horns[$creationtime] = $horn;
                }
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($horns);
    return $horns;
  }
  
  function horns_getHorn($directory, $directory_url, $file, $extension){
    global $horns_default_author;
    
    $horn = array();
    $horn['file'] = $directory.$file;
    $horn['url'] = $directory_url.$file;
    $horn['simplename'] = preg_replace('/[\W]/i', '_', preg_replace('/\.'.$extension.'$/i', '', $file));
    $horn['extension'] = $extension;
    $horn['name'] = $horn['simplename'];
    $horn['author'] = $horns_default_author;
    return $horn;
  }
  
  function horns_getHornWithDetails($horn){
    $infofile = preg_replace('/\.'. $horn['extension'].'$/i', '.txt', $horn['file']);
    if(is_file($infofile)){
      $content = file_get_contents($infofile);
      $lines = explode("\n", $content);
      foreach($lines as $line){
        if(preg_match('/^name=/i', $line)){
          $horn['name'] = trim(preg_replace('/^name=/i', '', $line));
        }
        if(preg_match('/^author=/i', $line)){
          $horn['author'] = trim(preg_replace('/^author=/i', '', $line));
        }
      }
    }
    return $horn;
  }

  function horns_displayHorn($horn, $position){
    global $content_color;
    global $text_color;
    global $horns_horn_price;
    global $manialink;


    $y = 55;
    if($position>3){
      $y = $y - 66;
      $position = $position - 4;
    }
    $x = -160 + 80*$position;
    
    $horn = horns_getHornWithDetails($horn);

    $simplename = $horn['simplename'];
    $name = $horn['name'];
    $author = $horn['author'];
    $url = $horn['url'];

    echo "  <frame posn='$x $y 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 63' bgcolor='$content_color' />"; echo "\n";
    echo "    <audio id='' posn='5 -5' sizen='10 10'  play='0' looping='0' >".htmlspecialchars($url, ENT_QUOTES, 'UTF-8')."</audio>"; echo "\n";
    echo "    <label id='' posn='17 -8' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -16 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -15' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -18' textsize='3' textcolor='$text_color' text='".htmlspecialchars($author, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -26' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
    echo "    <label id='' posn='17 -28' textsize='3' textcolor='$text_color' text='$horns_horn_price' />"; echo "\n";
    
    

    echo "    <label id='maps' posn='40 -53' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:horn?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }

  function horns_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Horns=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Horns=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Horns=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Horns=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function horns_displayHorns(){
    horns_displayHornsAt(1);
  }
  
  function horns_displayHornsAt($n){
    $horns = horns_getHorns();
    
    $number_of_horns = count($horns);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_horns/8))){
      $n = 1;
    }
    startPage();
    $displayed_horns = array_splice($horns, ($n-1)*8, min($n*8, $number_of_horns));
    for($i=0; $i<count($displayed_horns); $i++){
      horns_displayHorn($displayed_horns[$i], $i);
    }
    horns_displayPages($n, max(1, ceil($number_of_horns/8)));
    endPage();
  }
  
  function horns_displayManiacodeHorn(){
    $found = null;
    $horns = horns_getHorns();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($horns as $horn) {
           if($horn['simplename']==$key){
              $found = $horn;
           }
        }
      }
    }

    if($found!=null){
      $found = horns_getHornWithDetails($found);

      $name = $found['name'];
      $simplename = $found['simplename'];
      $extension = $found['extension'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Skins/Horns/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8').".".htmlspecialchars($extension, ENT_QUOTES, 'UTF-8')."</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url, ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "</maniacode>";
    }
  }

  function horns_hornsHandle($force){
    if($force){
      horns_displayHornsAt(1);
    }else if(isset($_GET['Horns'])){
      horns_displayHornsAt($_GET['Horns']);
      return true;
    }
    return false;
  }
?>