<?php



final class StokenConfig
{	
	
	public $wpdb;
	public $stoken_tables = array(); 
	public $stoken_db_version;
	protected static $_instance;

	
    protected function __construct()
    { 		
		global $wpdb;
		$this->wpdb = $wpdb;
		
		$this->stoken_app_version 				=  '0.8';
		$this->stoken_db_version 				= get_option ( 'stoken_db_version' );
		$this->stoken_db_table_stoken_token 	= get_option ( 'stoken_db_table_stoken_token' );
		$this->welcomeMessage 					= get_option ( 'stoken_opt_welcome_msg' );
		$this->notFoundMessage 					= get_option ( 'stoken_opt_not_found_msg' );
		$this->enableFocusOnLoad 				= get_option ( 'stoken_opt_enable_focus_onload' );
		$this->showStokenAuthor 				= get_option ( 'stoken_opt_show_author' );
	
	//	var_dump($this);
	
	}

	// cannot clone singleton
    protected function __clone()
    { 
	
	}

	
	// singleton class returns itself
    public static function getInstance() 
    {
      if( self::$_instance === NULL ) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }



	public function showForm()
	{
		$enableFocusOnLoad_html = '';
		$showStokenAuthor_html = '';
		
		if ($this->enableFocusOnLoad == 'yes') {
			$enableFocusOnLoad_html = ' checked="checked"';
		}
		
		if ($this->showStokenAuthor == 'yes') {
			$showStokenAuthor_html = ' checked="checked"';
		}
		

		$out .= '<div class="stokenSettings">';
		$out .= '<form action="" method="post" id="stoken-config" style="width: 600px; ">
			<h3><label for="welcome_msg">Welcome Message</label></h3>
			<p><input id="welcome_msg" name="welcome_msg" type="text" size="80" maxlength="255" value="' . $this->welcomeMessage .'" style="" /></p>
			
			<h3><label for="not_found_msg">\'Not Found\' Message</label></h3>
			<p><input id="not_found_msg" name="not_found_msg" type="text" size="80" maxlength="255" value="' . $this->notFoundMessage .'" style="" /></p>
			
			<h3><label for="show_author">Try to make input area the focus at page load (user experience enhancement)</label></h3>
			<p><input id="enable_focus_onload" name="enable_focus_onload" type="checkbox" value="1"' . $enableFocusOnLoad_html .' style="" /></p>
		
			<h3><label for="show_author">Show Unobtrusive Author link</label></h3>
			<p><input id="show_author" name="show_author" type="checkbox" value="1" ' . $showStokenAuthor_html .' style="" /></p>
			
			<p class="submit"><input type="submit" name="submit" value="Save &raquo;" /></p>
		';
		$out .= '</form>';	
		$out .= '</div>';

		return $out;
	}


	public function cleanGeneric($input='')
	{
		$input = trim($input);
		$input = substr($input, 0, 255);
		return $input;
	}



	public function saveSettings() 
	{
		$welcome_msg			= $this->cleanGeneric($_POST['welcome_msg']);
		$not_found_msg			= $this->cleanGeneric($_POST['not_found_msg']);
		$enableFocusOnLoad		= $this->cleanGeneric($_POST['enable_focus_onload']);
		$showStokenAuthor		= $this->cleanGeneric($_POST['show_author']);
	
		$enableFocusOnLoad 	= $this->convertCheckboxValToString($enableFocusOnLoad);
		$showStokenAuthor 	= $this->convertCheckboxValToString($showStokenAuthor);		
		
		update_option("stoken_opt_welcome_msg", $welcome_msg);
		update_option("stoken_opt_not_found_msg", $not_found_msg);
		update_option("stoken_opt_enable_focus_onload", $enableFocusOnLoad);
		update_option("stoken_opt_show_author", $showStokenAuthor);
		
		$this->welcomeMessage 	 	= $welcome_msg;
		$this->notFoundMessage  	= $not_found_msg;
		$this->enableFocusOnLoad  	= $enableFocusOnLoad;
		$this->showStokenAuthor  	= $showStokenAuthor;
		
	}
	
	
	
	
	public function convertCheckboxValToString($inputval = false)
	{
		switch ($inputval) {
			case true:
			case '1':
				$out_string = 'yes';
				break;
			
			default:
				$out_string = 'no';
				break;
		}
		
		return $out_string;
	}
	
	
		
}
?>