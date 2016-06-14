<?php
	
	$url = 'https://fonts.googleapis.com/css?family=Open+Sans';
	$useragent = 'Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))';
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    $css = curl_exec($ch); 
    curl_close($ch); 
    
    echo $css;
    
?>

    
    