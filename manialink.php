<?php
  $requestHandled = false;

  include('Config/config.php');
  include('Pages/page.php');
  foreach($pages as $name){
    if($name!=''){
      $simplename = preg_replace('/ /i', '', $name);
      include_once('Pages/'.$simplename.'/'.strtolower($simplename).'.php');
      if(!$requestHandled){
        $functionName = strtolower($simplename).'_'.strtolower($simplename).'Handle';
        $requestHandled = $functionName(false);
      }
    }
  }
  if(isset($pages2)){  
		foreach($pages2 as $name){
      if($name!=''){
  	    $simplename = preg_replace('/ /i', '', $name);
  	    include_once('Pages/'.$simplename.'/'.strtolower($simplename).'.php');
  	    if(!$requestHandled){
  	      $functionName = strtolower($simplename).'_'.strtolower($simplename).'Handle';
  	      $requestHandled = $functionName(false);
  	    }
      }
	  }
	}
  if(!$requestHandled){
    //displays default page
    $value = reset($pages);
    $simplename =  preg_replace('/ /i', '', $value);
    $functionName = strtolower($simplename).'_'.strtolower($simplename).'Handle';
    $requestHandled = $functionName(true);
  }
?>