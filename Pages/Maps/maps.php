<?php
  function maps_getMaps(){
    global $maps_directories;
  
    $maps = array();
    foreach($maps_directories as $maps_directory_url=>$maps_directory) {
      if(is_dir($maps_directory)){
        if($sd = opendir($maps_directory)){
          while(($file = readdir($sd))!==false){
            if(is_file($maps_directory . $file) && preg_match('/\.Map\.Gbx$/i', $file)){
              $map = null;
              $map = maps_getMap($maps_directory, $maps_directory_url, $file);
              if($map!=null){
                //sort the maps
                $creationtime = filectime($maps_directory.$file);
                while(array_key_exists($creationtime, $maps)){
                  $creationtime++;
                }
                $maps[$creationtime] = $map;
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($maps);
    return $maps;    
  }
  
  function maps_getMap($directory, $directory_url, $file){
    $map = array();
    $map['file'] = $directory.$file;
    $map['url'] = $directory_url.$file;
    $map['simplename'] = preg_replace('/[\W]/i', '_', preg_replace('/\.Map\.Gbx$/i', '', $file));
    $map['thumbnail'] = maps_getThumbnail(preg_replace('/\.Map\.Gbx$/i', '', $file));
    return $map;
  }
  
  function maps_getMapWithDetails($map){
    $content = file_get_contents($map['file']);
    $start = strpos($content, '<header');
    $end = strpos($content, '</header>');
    if($start && $end){
      $xml = new SimpleXMLElement(substr($content, $start, $end-$start+strlen('</header>')));

      foreach($xml->ident->attributes() as $name=>$value) {
        $map[$name] = (string)$value;
      }
      foreach($xml->desc->attributes() as $name=>$value) {
        $map[$name] = (string)$value;
      }
      foreach($xml->times->attributes() as $name=>$value) {
        $map[$name] = (string)$value;
      }
    }
    return $map;
  }
  
  function maps_getMapIncludedScreenshot($map){
    $content = file_get_contents($map['file']);
    $start = strpos($content, '<Thumbnail.jpg>');
    $end = strpos($content, '</Thumbnail.jpg>');
    if($start && $end){
      $imgsrc = imagecreatefromstring(substr($content, $start+strlen('<Thumbnail.jpg>'), $end-($start+strlen('<Thumbnail.jpg>'))));
      //mirror image vertically
      $imgdest = imagecreatetruecolor (256, 256);
      for($i=0; $i<256; $i++){
        imagecopy($imgdest, $imgsrc, 0, 255-$i, 0, $i, 256, 1);
      }
      $map['includedScreenshot'] = $imgdest; 
    }
    return $map;
  }
  
  function maps_getThumbnail($name){
    global $maps_thumbnails_directories;
    global $maps_thumbnails_extensions;
    
    foreach ($maps_thumbnails_directories as $thumbnails_directory_url=>$thumbnails_directory) {
      foreach($maps_thumbnails_extensions as $extension){
        if(file_exists("$thumbnails_directory$name.$extension")){
          return "$thumbnails_directory_url$name.$extension";
        }
      }
    }
    return null;   
  }
  
  function maps_getTime($t){
    $m = floor($t/60000);
    if($m<1){
      $m = 0;
    }
    $t = $t-($m*60000);
    $s = floor($t/1000);
    $t = $t-($s*1000);
    if($s<1){
      $s = '00';
    }else if($s<10){
      $s = "0".$s;
    }
    if($t<1){
      $t = '000';
    }else if($t<10){
       $t = "00".$t;
    }else if($t<100){
       $t = "0".$t;
    }
    return "$m:$s.$t";
  }
  
  function maps_displayMap($map, $position){
    global $maps_authors;
    global $content_color;
    global $text_color;
    global $maps_map_price;
    global $manialink;
    global $server;
    
    $map = maps_getMapWithDetails($map);
    
    $x = -160 + 80*$position;

    $thumbnail = $map['thumbnail'];
    $name = $map['name'];    
    $author = $map['author'];
    if(array_key_exists($author, $maps_authors)){
      $author = $maps_authors[$author];
    }
    $authortime = maps_getTime($map['authortime']);
    $mood = $map['mood'];
    $coppers = $map['displaycost']."C";
    $simplename = $map['simplename'];
    $maptype = $map['maptype'];     
    
    echo "  <frame posn='$x 55 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 129' bgcolor='$content_color' />"; echo "\n";
    if($thumbnail!=null){
      echo "    <quad id='' posn='5 -3' sizen='70 50' image='$thumbnail' />"; echo "\n";
    }else{
      echo "    <quad id='' posn='15 -3' sizen='50 50' image='${server}manialink.php?MapScreenshot=$simplename".htmlspecialchars('&')."/.jpg' />"; echo "\n";
    }
    echo "    <quad id='' posn='6 -56 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -55' sizen='10 10'  style='UIConstructionSimple_Buttons' substyle='Challenge' />"; echo "\n";
    echo "    <label id='' posn='17 -58' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -66 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -65' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -68' textsize='3' textcolor='$text_color' text='".htmlspecialchars($author, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    if(preg_match('/ShootMania\\\\/i', $maptype)){
      $maptype2 = preg_replace('/ShootMania\\\\/i', '', $maptype);
      echo "    <quad id='' posn='6 -76 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
      echo "    <quad id='' posn='5 -75' sizen='10 10'  style='UIConstructionSimple_Buttons' substyle='Plugins' />"; echo "\n";
      echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='$maptype2' />"; echo "\n";
    }else{
      echo "    <quad id='' posn='6 -76 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
      echo "    <quad id='' posn='5 -75' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='AuthorTime' />"; echo "\n";
      echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='$authortime' />"; echo "\n";
    }
    echo "    <quad id='' posn='6 -85' sizen='10 10' style='Icons64x64_1' substyle='ToolLeague1' />"; echo "\n";
    echo "    <label id='' posn='17 -88' textsize='3' textcolor='$text_color' text='$mood' />"; echo "\n";
    echo "    <quad id='' posn='5 -95' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Stats' />"; echo "\n";
    echo "    <label id='' posn='17 -98' textsize='3' textcolor='$text_color' text='$coppers' />"; echo "\n";
    echo "    <quad id='' posn='6 -106' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
    echo "    <label id='' posn='17 -108' textsize='3' textcolor='$text_color' text='$maps_map_price' />"; echo "\n";
    echo "    <label id='maps' posn='40 -119' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:map?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";  
  }

  function maps_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Maps=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Maps=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Maps=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Maps=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function maps_displayMaps(){
    maps_displayMapsAt(1);
  }
  
  function maps_displayMapsAt($n){
    $maps = maps_getMaps();
    $number_of_maps = count($maps);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_maps/4))){
      $n = 1;
    }
    startPage();
    $displayed_maps = array_splice($maps, ($n-1)*4, min($n*4, $number_of_maps));
    for($i=0; $i<count($displayed_maps); $i++){
      maps_displayMap($displayed_maps[$i], $i);
    }
    maps_displayPages($n, max(1, ceil($number_of_maps/4)));
    endPage();
  }
  
  function maps_displayMapsScreenshot($mapName){
    $found = null;
    $maps = maps_getMaps();
    foreach($maps as $map) {
       if($map['simplename']==$mapName){
          $found = $map;
       }
    }
    if($found!=null){
      $found = maps_getMapIncludedScreenshot($found);
      header('Content-Type: image/jpeg');
      imagejpeg($found['includedScreenshot']);
    }else{
      header("HTTP/1.0 404 Not Found");
    }
  }
  
  function maps_displayManiacodeMap(){
    $found = null;
    $maps = maps_getMaps();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($maps as $map) {
           if($map['simplename']==$key){
              $found = $map;
           }
        }
      }
    }
    
    if($found!=null){
      $found = maps_getMapWithDetails($found);
      
      $name = $found['name'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_map>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <url>".htmlspecialchars($url, ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_map>"; echo "\n";
      echo "</maniacode>";
    }
  }

  function maps_mapsHandle($force){
    if($force){
       //default page
       maps_displayMapsAt(1);
    }else if(isset($_GET['Maps'])){
      maps_displayMapsAt($_GET['Maps']);
      return true;
    }else if(isset($_GET['MapScreenshot'])){
      maps_displayMapsScreenshot($_GET['MapScreenshot']);
      return true;
    }
    return false;
  }
?>