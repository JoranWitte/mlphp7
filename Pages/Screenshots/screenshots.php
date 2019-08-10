<?php
  function screenshots_getScreenshots(){
    global $screenshots_directories;
    global $screenshots_extensions;
  
    $screenshots = array();
    foreach($screenshots_directories as $screenshots_directory_url=>$screenshots_directory) {
      if(is_dir($screenshots_directory)){
        if($sd = opendir($screenshots_directory)){
          while(($file = readdir($sd))!==false){
            foreach($screenshots_extensions as $extension){
              if(is_file($screenshots_directory . $file) && preg_match('/\.'.$extension.'$/i', $file)){
                $screenshot = screenshots_getScreenshot($screenshots_directory, $screenshots_directory_url, $file, $extension);
                if($screenshot!=null){
                  //sort the maps
                  $creationtime = filectime($screenshots_directory.$file);
                  while(array_key_exists($creationtime, $screenshots)){
                    $creationtime++;
                  }
                  $screenshots[$creationtime] = $screenshot;
                }
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($screenshots);
    return $screenshots;
  }
  
  function screenshots_getScreenshot($directory, $directory_url, $file, $extension){
    $screenshot = array();
    $screenshot['file'] = $directory.$file;
    $screenshot['url'] = $directory_url.$file;
    $screenshot['simplename'] = preg_replace('/[\W]/i', '_', preg_replace('/\.'.$extension.'$/i', '', $file));
    $screenshot['thumbnail'] = screenshots_getThumbnail(preg_replace('/\.'.$extension.'$/i', '', $file));
    return $screenshot;
  }
  

  function screenshots_getThumbnail($name){
    global $screenshots_thumbnails_directories;
    global $screenshots_extensions;
    
    foreach ($screenshots_thumbnails_directories as $screenshots_thumbnail_directory_url=>$screenshots_thumbnail_directory) {
      foreach($screenshots_extensions as $extension){
        if(file_exists("$screenshots_thumbnail_directory$name.$extension")){
          return "$screenshots_thumbnail_directory_url$name.$extension";
        }
      }
    }
    return null;
  }

  function screenshots_displayScreenshot($screenshot, $position){
    global $content_color;
    global $manialink;

    $y = 55;
    if($position>3){
      $y = $y - 66;
      $position = $position - 4;
    }
    $x = -160 + 80*$position;

    $thumbnail = $screenshot['thumbnail'];
    $simplename = $screenshot['simplename'];
    
    echo "  <frame posn='$x $y 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='76 63' bgcolor='$content_color' />"; echo "\n";
    echo "    <quad id='' posn='5 -3' sizen='70 50' image='$thumbnail' />"; echo "\n";
    echo "    <label id='maps' posn='40 -55' halign='center' style='CardButtonSmall' text='Fullscreen' manialink='$manialink?Screenshot=$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function screenshots_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Screenshots=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Screenshots=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Screenshots=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Screenshots=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function screenshots_displayScreenshots(){
    screenshots_displayScreenshotsAt(1);
  }
  
  function screenshots_displayScreenshotsAt($n){
    $screenshots = screenshots_getScreenshots();
    $number_of_screenshots = count($screenshots);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_screenshots/8))){
      $n = 1;
    }
    startPage();
    $displayed_screenshots = array_splice($screenshots, ($n-1)*8, min($n*8, $number_of_screenshots));
    for($i=0; $i<count($displayed_screenshots); $i++){
      screenshots_displayScreenshot($displayed_screenshots[$i], $i);
    }
    screenshots_displayPages($n, max(1, ceil($number_of_screenshots/8)));
    endPage();
  }
  
  function screenshots_displayFullscreenScreenshot($name){
    global $content_color;
    global $text_color;
    global $manialink;
  
    $found = null;
    $i = 0;
    $screenshots = screenshots_getScreenshots();
    $found = null;
    foreach($screenshots as $screenshot) {
      if($found==null){
        $i++;
        if($screenshot['simplename']==$name){
          $found = $screenshot;
        }
      }
    }
    
    if($found!=null){
      $url = $found['url'];
      $pageNumber = ceil($i/8);
      
      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<manialink version='1' background='0'>"; echo "\n";
      echo "  <timeout>0</timeout>"; echo "\n";
      echo "  <!-- background -->"; echo "\n";
      echo "  <quad id='background' posn='-160 90 -10' sizen='320 180' bgcolor='$content_color' />"; echo "\n";
      echo ""; echo "\n";
      echo "  <quad id='screenshot' posn='-160 90 -1' sizen='320 180' image='$url' />"; echo "\n";
      echo "  <label id='' posn='0 -70 -2' halign='center' valign='center' textsize='3' textcolor='$text_color' text='Downloading...' /> "; echo "\n";
      echo "  <label id='maps' posn='86 -79 1' style='CardButtonSmall' text='Open in web browser' url='$url' />"; echo "\n";
      echo "  <label id='maps' posn='122 -79 1' style='CardButtonSmall' text='Back' manialink='$manialink?Screenshots=$pageNumber' />"; echo "\n";
      echo "</manialink>";
    }
  }

  
  function screenshots_screenshotsHandle($force){
    if($force){
      screenshots_displayScreenshotsAt(1);
    }else if(isset($_GET['Screenshots'])){
      screenshots_displayScreenshotsAt($_GET['Screenshots']);
      return true;
    }else if(isset($_GET['Screenshot'])){
       screenshots_displayFullscreenScreenshot($_GET['Screenshot']);
       return true;
    }
    return false;
  }
?>