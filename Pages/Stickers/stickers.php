<?php
  function stickers_getStickers(){
    global $stickers_directories;
    global $stickers_extensions;
  
    $stickers = array();
    foreach($stickers_directories as $stickers_directory_url=>$stickers_directory) {
      if(is_dir($stickers_directory)){
        if($sd = opendir($stickers_directory)){
          while(($file = readdir($sd))!==false){
            if(is_dir($stickers_directory . $file) && is_file($stickers_directory . $file. '/Sticker.tga') && is_file($stickers_directory . $file. '/Icon.dds')){
              $sticker = stickers_getSticker($stickers_directory, $stickers_directory_url, $file);
              if($sticker!=null){
                //sort the stickers
                $creationtime = filectime($stickers_directory.$file);
                while(array_key_exists($creationtime, $stickers)){
                  $creationtime++;
                }
                $stickers[$creationtime] = $sticker;
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($stickers);
    return $stickers;
  }
  
  function stickers_getSticker($directory, $directory_url, $file){
    global $stickers_default_author;
    
    $sticker = array();
    $sticker['file'] = $directory.$file;
    $sticker['url'] = $directory_url.$file;
    $sticker['simplename'] = preg_replace('/[\W]/i', '_', $file);
    $sticker['name'] = $sticker['simplename'];
    $sticker['author'] = $stickers_default_author;
    $sticker['thumbnail'] = stickers_getThumbnail($file);
    return $sticker;
  }
  
  function stickers_getThumbnail($name){
    global $stickers_thumbnails_directories;
    global $stickers_thumbnails_extensions;

    foreach ($stickers_thumbnails_directories as $stickers_thumbnails_directory_url=>$stickers_thumbnails_directory) {
      foreach($stickers_thumbnails_extensions as $extension){
        if(file_exists("$stickers_thumbnails_directory$name.$extension")){
          return "$stickers_thumbnails_directory_url$name.$extension";
        }
      }
    }
    return null;
  }
  
  function stickers_getStickerWithDetails($sticker){
    $infofile = $sticker['file']. '.txt';
    if(is_file($infofile)){
      $content = file_get_contents($infofile);
      $lines = explode("\n", $content);
      foreach($lines as $line){
        if(preg_match('/^name=/i', $line)){
          $sticker['name'] = trim(preg_replace('/^name=/i', '', $line));
        }
        if(preg_match('/^author=/i', $line)){
          $sticker['author'] = trim(preg_replace('/^author=/i', '', $line));
        }
      }
    }
    return $sticker;
  }

  function stickers_displaySticker($sticker, $position){
    global $content_color;
    global $text_color;
    global $stickers_sticker_price;
    global $manialink;


    $x = -160 + 80*$position;
    
    $sticker = stickers_getStickerWithDetails($sticker);

    $simplename = $sticker['simplename'];
    $name = $sticker['name'];
    $author = $sticker['author'];
    $thumbnail = $sticker['thumbnail'];
    $url = $sticker['url'];


    echo "  <frame posn='$x 55 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 129' bgcolor='$content_color' />"; echo "\n";
    if($thumbnail!=null){
      echo "    <quad id='' posn='5 -3' sizen='70 50' image='$thumbnail' />"; echo "\n";
    }else{
      echo "    <quad id='' posn='15 -3' sizen='50 50' image='$url/Icon.dds' />"; echo "\n";
    }
    echo "    <quad id='' posn='6 -56 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -55' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Paint' />"; echo "\n";
    echo "    <label id='' posn='17 -58' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -66 -4' sizen='8 8' style='UIConstructionSimple_Buttons' substyle='Item' />"; echo "\n";
    echo "    <quad id='' posn='5 -65' sizen='10 10' style='UIConstructionSimple_Buttons' substyle='Author' />"; echo "\n";
    echo "    <label id='' posn='17 -68' textsize='3' textcolor='$text_color' text='".htmlspecialchars($author, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "    <quad id='' posn='6 -76' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
    echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='$stickers_sticker_price' />"; echo "\n";
    
    

    echo "    <label id='maps' posn='40 -119' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:sticker?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }

  function stickers_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Stickers=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Stickers=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Stickers=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Stickers=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function stickers_displayStickers(){
    stickers_displayStickersAt(1);
  }
  
  function stickers_displayStickersAt($n){
    $stickers = stickers_getStickers();
    
    $number_of_stickers = count($stickers);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_stickers/4))){
      $n = 1;
    }
    startPage();
    $displayed_stickers = array_splice($stickers, ($n-1)*4, min($n*4, $number_of_stickers));
    for($i=0; $i<count($displayed_stickers); $i++){
      stickers_displaySticker($displayed_stickers[$i], $i);
    }
    stickers_displayPages($n, max(1, ceil($number_of_stickers/4)));
    endPage();
  }
  
  function stickers_displayManiacodeSticker(){
    $found = null;
    $stickers = stickers_getStickers();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($stickers as $sticker) {
           if($sticker['simplename']==$key){
              $found = $sticker;
           }
        }
      }
    }

    if($found!=null){
      $found = stickers_getStickerWithDetails($found);

      $name = $found['name'];
      $simplename = $found['simplename'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Media/Painter/Stickers/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8')."/Icon.dds</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url.'/Icon.dds', ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Media/Painter/Stickers/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8')."/Sticker.tga</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url.'/Sticker.tga', ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "</maniacode>";
    }
  }

  function stickers_stickersHandle($force){
    if($force){
      stickers_displayStickersAt(1);
    }else if(isset($_GET['Stickers'])){
      stickers_displayStickersAt($_GET['Stickers']);
      return true;
    }
    return false;
  }
?>