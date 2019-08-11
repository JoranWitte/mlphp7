<?php
  function startPage(){
    global $background_color;
    global $text_color;
    global $title;
    global $header_color;
    global $header_line_color;
    global $pages;
    global $pages2;
    global $manialink;
    global $quick_manialink_text_color;
    
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
    echo "<manialink version='1' background='0'>"; echo "\n";
    echo "  <timeout>0</timeout>"; echo "\n";
    echo "  <!-- background -->"; echo "\n";
    echo "  <quad id='background' posn='-160 90 -10' sizen='320 180' bgcolor='$background_color' />"; echo "\n";
    echo ""; echo "\n";
    echo "  <!-- header -->"; echo "\n";
    echo "  <label id='title' posn='-155 72 1' halign='left' valign='center' textsize='10' textcolor='$text_color' text='".htmlspecialchars($title, ENT_QUOTES, 'UTF-8')."' /> "; echo "\n";
    echo "  <quad id='headerbackground' posn='-160 90 -5' sizen='320 30' bgcolor='$header_color' />"; echo "\n";
    echo "  <quad id='headerline' posn='-160 60 -1' sizen='320 0.5' bgcolor='$header_line_color' />"; echo "\n";
    echo ""; echo "\n";
    $i = 0;
    foreach($pages as $name) {
      if($name!=''){
        $simplename = preg_replace('/ /i', '', $name);
        echo "  <label posn='".(122-(count($pages)-1-$i)*36)." 70 1' style='CardButtonSmall' text='$name' manialink='$manialink?$simplename' />"; echo "\n";
      }
      $i++;
    }
    if($pages2!=null){
	    $i = 0;
	    foreach($pages2 as $name) {
        if($name!=''){
  	      $simplename = preg_replace('/ /i', '', $name);
  	      echo "  <label posn='".(122-18-(count($pages2)-1-$i)*36)." 76 1' style='CardButtonSmall' text='$name' manialink='$manialink?$simplename' />"; echo "\n";
        }
	      $i++;
	    }
	  }
    echo "  <label id='copyright' posn='-157 88 1' halign='left' textsize='1' textcolor='$quick_manialink_text_color' text='Powered by Quick Manialink' manialink='akbalder?QuickManialink' />"; echo "\n";
  }
  
  function endPage(){
    echo "</manialink>";
  }
?>