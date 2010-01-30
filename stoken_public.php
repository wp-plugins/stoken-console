<?php

// [stoken]
function stoken_show($atts) {
	extract(shortcode_atts(array(
		'which' => 'default',		// ignored for now, this allows for multiple instances in future versions
	), $atts));

	$stokenConfig 			= StokenConfig::getInstance();
	$stokenTokenSecret 		= StokenTokenSecret::getInstance();
	$out 					= '<div class="stoken"><div class="stoken-receipt">';
	
	if ($stokenConfig->showStokenAuthor == 'yes') {
		$out .= '<div id="author"><a href="http://labs.leftcolumn.net/stoken-console/" title="SToken Console - Interactive Token-Controlled Secrets">SToken Console</a></div>';
	}
	
	$stokenToReflect ='';
	
	if ( isset($_POST['stokensubmit']) ) {
		
		
		$stokenToShow = $stokenTokenSecret->fetch($_POST['token']);
		$stokenToReflect = $stokenTokenSecret->cleanToken($_POST['token']);
		$out .= '<pre>' . $stokenToShow . '</pre>';
		
	} else {
		
		$out .= '<pre>' . $stokenConfig->welcomeMessage . '</pre>';
		
	}
	
	$out .= '</div>
	
	<div class="stoken-token">';
	$out .= '<form action="" method="post" id="stokenfetch" onload="formfocus(this);" name="stokenfetch" style="">
		<div id="inputblock"><input id="token" name="token" type="text" maxlength="255" value="' .$stokenToReflect . '" style="" />
		<input type="submit" id="stokensubmit" name="stokensubmit" value="GO &raquo;" /></div>';
	$out .= '</form>';
	$out .= '</div></div>';
	
	return $out;
	
}



	function stoken_css() {
		echo '<link type="text/css" rel="stylesheet" href="' . WP_PLUGIN_URL . '/stoken/stoken.css" />' . "\n";
	}

	
	function stoken_js() {
		$stokenConfig 			= StokenConfig::getInstance();
		if ($stokenConfig->enableFocusOnLoad == 'yes') {
			echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>';
			echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/stoken/stoken.js"></script>';
  		}
	}
	



// listen for any posts or pages using the shortcode
add_shortcode('stoken', 'stoken_show');
add_action('wp_head', 'stoken_js');




?>