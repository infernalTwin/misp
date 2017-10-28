<!DOCTYPE html>
<html lang="en">

<head>
  <title>android</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<div class="container">

<?php
	// Include the DOM parsing library
	include('simple_html_dom.php');

	// get DOM
	$symantec = file_get_html('https://www.symantec.com/security_response/landing/azlisting.jsp');
	// Find all "a" tags
	foreach($symantec->find('a') as $e){
		//Find Name, URL
		if (preg_match("/Android\.[a-zA-Z]{1,30}/", $e)) {
			$malname = $e->innertext;
            $malurl = $e->href; 
			echo "{ <br /> \"value\": \"";
	 		echo $malname . "\"," . "<br />";
			echo "\"description\": \"" . maldesc($malname, $malurl) . "\"" . ",<br />" . "\"meta\": {" . "<br />" . "\"refs\": [" . "<br />"; 
			echo "\"https://www.symantec.com" . $malurl . "\"<br />";
			echo "] <br /> } <br /> },<br />";
			break;
		}	
	}
	
	
	function maldesc($aname, $aurl) {
	
        $burl = "https://www.symantec.com/security_response/writeup.jsp?docid=2014-032814-2947-99";
        //$burl = "https://www.symantec.com" . $aurl;
            
        $descurl = file_get_html($burl);
        $matches = array();

	
        foreach($descurl->find('div.nextSibling') as $d){
            if (preg_match("/(^)Android.*/", $d->innertext, $matches)) {
                $substring = substr($matches[0], 0, strpos($matches[0], '<br>'));
                //echo var_dump($matches);	    		
                return ($substring);
            }
        }

        if ($matches == null) {
            return "no result";
        }
    }
    
    
?>		
</div>

</body>
</html>