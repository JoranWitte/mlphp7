<?php
  function stencils_getStencils(){
    global $stencils_directories;
    global $stencils_extensions;
  
    $stencils = array();
    foreach($stencils_directories as $stencils_directory_url=>$stencils_directory) {
      if(is_dir($stencils_directory)){
        if($sd = opendir($stencils_directory)){
          while(($file = readdir($sd))!==false){
            if(is_dir($stencils_directory . $file) && is_file($stencils_directory . $file. '/Brush.tga') && is_file($stencils_directory . $file. '/Icon.dds')){
              $stencil = stencils_getStencil($stencils_directory, $stencils_directory_url, $file);
              if($stencil!=null){
                //sort the stencils
                $creationtime = filectime($stencils_directory.$file);
                while(array_key_exists($creationtime, $stencils)){
                  $creationtime++;
                }
                $stencils[$creationtime] = $stencil;
              }
            }
          }
          closedir($sd);
        }
      }
    }
    krsort($stencils);
    return $stencils;
  }
  
  function stencils_getStencil($directory, $directory_url, $file){
    global $stencils_default_author;
    
    $stencil = array();
    $stencil['file'] = $directory.$file;
    $stencil['url'] = $directory_url.$file;
    $stencil['simplename'] = preg_replace('/[\W]/i', '_', $file);
    $stencil['name'] = $stencil['simplename'];
    $stencil['author'] = $stencils_default_author;
    $stencil['thumbnail'] = stencils_getThumbnail($file);
    return $stencil;
  }
  
  function stencils_getThumbnail($name){
    global $stencils_thumbnails_directories;
    global $stencils_thumbnails_extensions;

    foreach ($stencils_thumbnails_directories as $stencils_thumbnails_directory_url=>$stencils_thumbnails_directory) {
      foreach($stencils_thumbnails_extensions as $extension){
        if(file_exists("$stencils_thumbnails_directory$name.$extension")){
          return "$stencils_thumbnails_directory_url$name.$extension";
        }
      }
    }
    return null;
  }
  
  function stencils_getStencilWithDetails($stencil){
    $infofile = $stencil['file']. '.txt';
    if(is_file($infofile)){
      $content = file_get_contents($infofile);
      $lines = explode("\n", $content);
      foreach($lines as $line){
        if(preg_match('/^name=/i', $line)){
          $stencil['name'] = trim(preg_replace('/^name=/i', '', $line));
        }
        if(preg_match('/^author=/i', $line)){
          $stencil['author'] = trim(preg_replace('/^author=/i', '', $line));
        }
      }
    }
    return $stencil;
  }

  function stencils_displayStencil($stencil, $position){
    global $content_color;
    global $text_color;
    global $stencils_stencil_price;
    global $manialink;


    $x = -160 + 80*$position;
    
    $stencil = stencils_getStencilWithDetails($stencil);

    $simplename = $stencil['simplename'];
    $name = $stencil['name'];
    $author = $stencil['author'];
    $thumbnail = $stencil['thumbnail'];
    $url = $stencil['url'];


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
    echo "    <label id='' posn='17 -78' textsize='3' textcolor='$text_color' text='$stencils_stencil_price' />"; echo "\n";
    
    

    echo "    <label id='maps' posn='40 -119' halign='center' style='CardButtonSmall' text='Download' manialink='$manialink:stencil?$simplename' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }

  function stencils_displayPages($n, $total){
    global $manialink;
    global $text_color;
     
    echo "  <frame posn='-30 -75'>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Stencils=1' ";
    }    
    echo "    <quad id='' posn='0 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowFirst' $link/>"; echo "\n";
    $link = '';
    if($n!=1){
      $link = "manialink='$manialink?Stencils=".($n-1)."' ";
    }
    echo "    <quad id='' posn='10 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowPrev' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Stencils=".($n+1)."' ";
    }
    echo "    <quad id='' posn='40 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowNext' $link/>"; echo "\n";
    $link = '';
    if($n!=$total){
      $link = "manialink='$manialink?Stencils=$total' ";
    }
    echo "    <quad id='' posn='50 0' sizen='10 10' style='Icons64x64_1' substyle='ArrowLast' $link/>"; echo "\n";
    echo "    <label id='' posn='30 -5' halign='center' valign='center' textsize='3' textcolor='$text_color' text='$n/$total' /> "; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function stencils_displayStencils(){
    stencils_displayStencilsAt(1);
  }
  
  function stencils_displayStencilsAt($n){
    $stencils = stencils_getStencils();
    
    $number_of_stencils = count($stencils);
    if($n==null || !is_numeric($n) || $n<1 || $n>(ceil($number_of_stencils/4))){
      $n = 1;
    }
    startPage();
    $displayed_stencils = array_splice($stencils, ($n-1)*4, min($n*4, $number_of_stencils));
    for($i=0; $i<count($displayed_stencils); $i++){
      stencils_displayStencil($displayed_stencils[$i], $i);
    }
    stencils_displayPages($n, max(1, ceil($number_of_stencils/4)));
    endPage();
  }
  
  function stencils_displayManiacodeStencil(){
    $found = null;
    $stencils = stencils_getStencils();
    foreach($_GET as $key=>$value) {
      if($found==null){
        $found = null;
        foreach($stencils as $stencil) {
           if($stencil['simplename']==$key){
              $found = $stencil;
           }
        }
      }
    }

    if($found!=null){
      $found = stencils_getStencilWithDetails($found);

      $name = $found['name'];
      $simplename = $found['simplename'];
      $url = $found['url'];

      header('Content-Type: text/xml; charset=utf-8');
      echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
      echo "<maniacode>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Media/Painter/Stencils/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8')."/Icon.dds</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url.'/Icon.dds', ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "  <install_skin>"; echo "\n";
      echo "    <name>".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."</name>"; echo "\n";
      echo "    <file>Media/Painter/Stencils/".htmlspecialchars($simplename, ENT_QUOTES, 'UTF-8')."/Brush.tga</file>"; echo "\n";
      echo "    <url>".htmlspecialchars($url.'/Brush.tga', ENT_QUOTES, 'UTF-8')."</url>"; echo "\n";
      echo "  </install_skin>"; echo "\n";
      echo "</maniacode>";
    }
  }

  function stencils_stencilsHandle($force){
    if($force){
      stencils_displayStencilsAt(1);
    }else if(isset($_GET['Stencils'])){
      stencils_displayStencilsAt($_GET['Stencils']);
      return true;
    }
    return false;
  }
?>