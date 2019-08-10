<?php
  function about_display(){
    startPage();
    about_displayPresentation();
    about_displayDonations();
    endPage();
  }
  
  function about_displayPresentation(){
    global $content_color;
    global $text_color;
    global $about_presentation;
    global $manialinkimage;
	
    echo "  <frame posn='-160 55 1'>"; echo "\n";
    echo "    <quad id='' posn='2 0 -5' sizen='316 ".(14+5*substr_count($about_presentation, "\n"))."' bgcolor='$000' />"; echo "\n";
	echo "    <quad id='manialinkimage' posn='10 -7 1' sizen='300 110' image='$manialinkimage'/>"; echo "\n";
    echo "    <label id='' posn='7 -5' textsize='3' textcolor='$fff' text='".htmlspecialchars($about_presentation, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
    echo "  </frame>"; echo "\n";
  }
  
  function about_displayLinks(){
    global $about_presentation;
    global $content_color;
    global $text_color;
    global $about_servers;
    global $about_manialinks;
    global $about_websites;

    $width = 102;
    echo "  <frame posn='".(2-160)." ".(38-5*substr_count($about_presentation, "\n"))." 1'>"; echo "\n";
    echo "    <quad id='' posn='0 0 -5' sizen='$width ".(108-5*substr_count($about_presentation, "\n"))."' bgcolor='$content_color' />"; echo "\n";
    $i = 0;
    foreach($about_servers as $name=>$value) {
      echo "    <label id='' posn='7 ".(-3.5-$i*10)."' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
      echo "    <label id='' posn='".($width-5)." ".(-3-$i*10)."'  halign='right' style='CardButtonSmall' text='Join' url='$value' />"; echo "\n";
      $i++;
    }
    echo "  </frame>"; echo "\n";

    echo "  <frame posn='".(0-$width/2)." ".(38-5*substr_count($about_presentation, "\n"))." 1'>"; echo "\n";
    echo "    <quad id='' posn='0 0 -5' sizen='$width ".(108-5*substr_count($about_presentation, "\n"))."'  bgcolor='$content_color' />"; echo "\n";
    $i = 0;
    foreach($about_manialinks as $name=>$value) {
      echo "    <label id='' posn='7 ".(-3.5-$i*10)."' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
      echo "    <label id='' posn='".($width-5)." ".(-3-$i*10)."'  halign='right' style='CardButtonSmall' text='Visit' manialink='$value' />"; echo "\n";
      $i++;
    }
    echo "  </frame>"; echo "\n";
    
    echo "  <frame posn='".(160-2-$width)." ".(38-5*substr_count($about_presentation, "\n"))." 1'>"; echo "\n";
    echo "    <quad id='' posn='0 0 -5' sizen='$width ".(108-5*substr_count($about_presentation, "\n"))."' bgcolor='$content_color' />"; echo "\n";
    $i = 0;
    foreach($about_websites as $name=>$value) {
      echo "    <label id='' posn='7 ".(-3.5-$i*10)."' textsize='3' textcolor='$text_color' text='".htmlspecialchars($name, ENT_QUOTES, 'UTF-8')."' />"; echo "\n";
      echo "    <label id='' posn='".($width-5)." ".(-3-$i*10)."'  halign='right' style='CardButtonSmall' text='Visit' url='$value' />"; echo "\n";
      $i++;
    }
    echo "  </frame>"; echo "\n";
  }

  function about_displayDonations(){
    global $content_color;
    global $text_color;
    global $about_donations;
    global $manialink;
    $width = (320-count($about_donations)*4)/count($about_donations);
    $i = 0;
    $j = 0;
    foreach($about_donations as $value=>$thanks) {
      echo "    <frame posn='".(-160+2+($i*$width)+$i*4)." -74 1'>"; echo "\n";
      echo "    <quad id='' posn='0 0 -5' sizen='$width 12' bgcolor='$content_color' />"; echo "\n";
      echo "    <quad id='' posn='6 -2' sizen='8 8' style='ManiaPlanetLogos' substyle='IconPlanets' />"; echo "\n";
      echo "    <label id='' posn='17 -4' textsize='3' textcolor='$text_color' text='$value' />"; echo "\n";
      echo "    <label id='' posn='".($width-5)." -3.5'  halign='right' style='CardButtonSmall' text='Donate' manialink='$manialink:donate$value' />"; echo "\n";
      echo "    </frame>"; echo "\n";
      $i++;
      $j = $i-1;
    }
  }
  
  function about_displayManiacodeThanks(){
    global $about_donations;
    
    $message = 'Thanks!';
    foreach($about_donations as $key=>$value) {
      if(isset($_GET[$key])){
        $message = $value;
      }
    }
     
    header('Content-Type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?'.'>'; echo "\n";
    echo "<maniacode>"; echo "\n";
    echo "   <show_message>"; echo "\n";
    echo "    <message>".htmlspecialchars($message, ENT_QUOTES, 'UTF-8')."</message>"; echo "\n";
    echo "   </show_message>"; echo "\n";
    echo "</maniacode>";
  }

  function about_aboutHandle($force){
    if(isset($_GET['About']) || $force){
      about_display();
      return true;
    }
    return false;
  }
?>