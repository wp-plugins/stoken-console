<?php


class StokenAdminFormTokenEdit extends StokenAdminForm
{
	
	public $wpdb;
//	public $tense = 'future';
	public $tokens;
	
	public function __construct()
	{
		$this->tense = $tense;
		global $wpdb;
		$this->wpdb = $wpdb;
		
		
		//$this->events = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts				WHERE post_status = 'draft' AND post_author = 5");
	}
	
	
	public function show($id = false)
	{
		
		$token ='';
		$secret = '';
		$save_text = 'Add Token';
		
		if ($id) {
			$stokenTokenSecret 		= StokenTokenSecret::getInstance();
			$stokenDeets = $stokenTokenSecret->fetchAll($_GET['id']);
			
		//	var_dump($stokenDeets);
			
			if ($stokenDeets) {
				$id = $stokenDeets->id;
				$token = $stokenDeets->token;
				$secret = $stokenDeets->secret;
				
				$save_text = 'Save Token';
			}
			
			
		}
		
		$out =  '<h2>SToken Console - Edit a Token</h2>';		
		$out .= '<div class="stokenTokenAdd">';
		$out .= '<form action="" method="post" id="stoken-add" style="width: 400px; ">
		<input type="hidden" name="id" value="' . $id .'" id="id">
		<h3><label for="token">Token</label></h3>
		<p><input id="token" name="token" type="text" size="46" maxlength="255" value="' . stripslashes($token) . '" style="" /></p>
		<h3><label for="secret">Secret</label></h3>
		<p><textarea name="secret" id="secret" rows="8" cols="40">' . stripslashes($secret) . '</textarea></p>
		<p class="submit"><input type="submit" name="submit" value="' . $save_text . ' &raquo;" /></p>';
		
		$out .= '</form>';	
		$out .= '</div>';
	
		echo $out;	
		
	}
	
}

?>