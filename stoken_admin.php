<?php


function stoken_admin_menu_setup() {
	add_options_page('Stoken Config', 'Stoken Config', 'administrator', __FILE__, 'stoken_admin_config');
	add_management_page('Stoken Admin', 'Stoken Tokens', 'administrator', __FILE__, 'stoken_admin_tokens');
}



function stoken_admin_config() {
	
	global $stokenConfig;
	$out =  '<h1>' . get_bloginfo('name') . ': SToken Console - Token-Controlled Secrets for your Wordpress Site</h1>';
	$out .=  '<h2>Application Version: ' . $stokenConfig->stoken_app_version . '</h2>';
	$out .=  '<h2>Database Version: ' . $stokenConfig->stoken_db_version . '</h2>';
	
	
	$out .= "<p>This plugin lets you add an interactive console to your Wordpress site, then set up 'Tokens' that 
	control access to 'Secrets.' Your users type the Token into the console to reveal the corresponding secret. 
	You manage the process via the Wordpress Admin Dashboard.</p>";
	
	$out .= '<p>For more information and examples, visit <a href="http://labs.leftcolumn.net/stoken-console/">labs.leftcolumn.net/stoken-console/</a></p>';
	
	

	
	// $out .=  '<h2>Database Tables:</h2>';
	// 	$out .= '<ul><li>' . $stokenConfig->stoken_db_table_stoken_token . '</li>';	
	
	if ( isset($_POST['submit']) ) {
		$stokenConfig->saveSettings();
		
		$out .= '<b>Settings Saved.</b>';
		
	}
	$out .= $stokenConfig->showForm();

	echo $out;
}


function stoken_admin_tokens() {
//	global $wpdb;
	
//	var_dump($_GET);
//	var_dump($_POST);
	
$stokenTokenSecret = StokenTokenSecret::getInstance();
	$show_list = true;
	
		if (isset($_GET['stokenpage']) && (strlen($_GET['stokenpage']) > 0) ) {
			switch ($_GET['stokenpage']) {
				
				case 'add':
				
					$stokenForm = new StokenAdminFormTokenAdd();
					if ( isset($_POST['submit']) ) {
						$stokenTokenSecret->saveNew($_POST['token'], $_POST['secret']);
					} else {
						$show_list = false;
						$stokenForm->show();
					}
					break;
					
				
				case 'edit':
										
					$stokenForm = new StokenAdminFormTokenEdit();
					if ( isset($_POST['submit']) ) {
						$stokenTokenSecret->saveExisting($_POST['id'], $_POST['token'], $_POST['secret']);
					} else {
						$show_list = false;
						$stokenForm->show($_GET['id']);
					}
					
					break;
				
				
				case 'delete':
					
					if ( isset($_GET['id']) ) {
						$stokenTokenSecret->delete($_GET['id']);			
					}
					
					break;
				
				default:

					break;
			}
		} else {

		}
	
	if ($show_list) {
		$stokenForm = new StokenAdminFormTokenList();
		$stokenForm->show();
	}

		
	
}



function stoken_admin_install() {
	$stokenInstaller = new stokenInstaller();
}




?>