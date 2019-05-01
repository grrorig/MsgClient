<?php

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
    	case('getState'):
        	if(file_exists($_POST['file'])) {
            	$lines = file($_POST['file']);
        	}
			//$log['state'] = count($lines); 
			$log['state'] = 0;
        	break;	
    	
    	case('update'):
        	$state = $_POST['state'];
        	if(file_exists($_POST['file'])) {
        		$lines = file($_POST['file']);
        	}
        	$count =  count($lines);
        	if($state == $count) {
        		$log['state'] = $state;
        		$log['text'] = false; 
        	}
        	else {
        		$text= array();
        		$log['state'] = $state + count($lines) - $state;
        		foreach ($lines as $line_num => $line)
                {
        			if($line_num >= $state) {
                    $text[] =  $line = str_replace("\n", "", $line);
        			}
                }
        		$log['text'] = $text; 
        	}  
            break;
    	 
    	case('send'):
			$nickname = htmlentities(strip_tags($_POST['nickname']));
			$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			$message = htmlentities(strip_tags($_POST['message']));
			$patterns = array("/TriHard/", "/FeelsGoodMan/", "/KappaPride/", "/:\)/", "/:D/", "/:p/", "/:P/", "/:\(/");
			$replacements = array("<img src='emotes/TriHard.png' title='TriHard'/>", "<img src='emotes/FeelsGoodMan.png' title='FeelsGoodMan'/>", "<img src='emotes/KappaPride.png' title='KappaPride'/>", "<img src='emotes/smile.gif'/>", "<img src='emotes/bigsmile.png'/>", "<img src='emotes/tongue.png'/>", "<img src='emotes/tongue.png'/>", "<img src='emotes/sad.png'/>");
			if(($message) != "\n") {
        
				if(preg_match($reg_exUrl, $message, $url)) {
       				$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				}
				$message = preg_replace($patterns, $replacements, $message);
			 
        		fwrite(fopen($_POST['file'], 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
		 	}
        	break;
    	
    }
    
    echo json_encode($log);

?>