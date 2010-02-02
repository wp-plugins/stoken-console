<?php



class StokenInstaller
{
	
	// table insert definitions
	
	
	// other general vars
	public $wpdb;
	public $stoken_tables = array(); 
	public $stoken_db_version;
	

	function __construct()
	{
		// we need access to the wpdb global
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->stoken_opt_welcome_msg 				= 'Hi! Try typing something into the box below.';
		$this->stoken_opt_not_found_msg				= 'Not found.';
		$this->stoken_opt_enable_focus_onload		= 'yes';
		$this->stoken_opt_show_author 				= 'no';
		
		

		$this->initTableArray($this->wpdb->prefix);		
		$this->checkTables();
	}

	public function initTableArray()
	{
		if (!$this->wpdb->prefix) {
			$prefix = 'wp_';
		} else {
			$prefix = $this->wpdb->prefix;
			
		}
				
		$this->stoken_tables['stoken_token']['name'] = $prefix . 'stoken_token';
		$this->stoken_tables['stoken_token']['sql'] = "CREATE TABLE " . $this->stoken_tables['stoken_token']['name'] . " (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `token` varchar(255) NOT NULL default '',
			  `secret` MEDIUMTEXT default '',
			  `status` mediumint(5) unsigned NOT NULL default '1',
			  `dt_create` datetime default NULL,
			  `dt_expiry` datetime default NULL,
			  PRIMARY KEY  (`id`));";
			
	}


	// install tables if necessary
	function checkTables()
	{
		$detector = 0;	
		$upgrade = false;
		
		$stokenConfig 		= StokenConfig::getInstance();
		if ($stokenConfig->stoken_app_version != $stokenConfig->stoken_db_version) {
			$detector++;
			$upgrade = true;
		}
		
		
		$detector += $this->conditionallyInstall('stoken_token', $upgrade );
		
		

		
		// simple check to see whether we changed any tables
		// if so, update the stoken version in the db
		if ($detector > 0) {
			update_option("stoken_db_version", $stokenConfig->stoken_app_version);
			
		}
		$this->addDefaults();
		
	}

	


	function conditionallyInstall($table_base_name, $upgrade = false)
	{
		//$table_name = $this->wpdb->prefix . $table_base_name;
		$table_name = $this->stoken_tables[$table_base_name]['name'];
		
		if(($this->wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) || ($upgrade)) {
			$sql = $this->stoken_tables[$table_base_name]['sql'];
		
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);	
			
			update_option("stoken_db_table_" . $table_base_name, $table_name);
			
	      return 1;
		}
		return 0;
	}


	public function addDefaults()
	{
		$stokenConfig 		= StokenConfig::getInstance();
		
		$default_tokens['ver'] = 'Current SToken App version: ' . $stokenConfig->stoken_app_version;
		$default_tokens['hi'] = 'Hey there';
		$default_tokens['url'] = 'http://labs.leftcolumn.net/stoken-console/';
		$default_tokens['help'] = 'Type a command in the box below to get a response.';
		
		
		foreach ($default_tokens as $key => $value) {

			$key_exists = $this->wpdb->get_var($this->wpdb->prepare("SELECT COUNT(*) FROM $stokenConfig->stoken_db_table_stoken_token WHERE token ='{$key}';"));

			if ($key_exists != '1') {
				$this->wpdb->query( "
					INSERT INTO $stokenConfig->stoken_db_table_stoken_token
					( token, secret )
					VALUES ( '$key', '$value' )" );
			}	
		}
				
		// set up default config
		
		update_option("stoken_opt_welcome_msg", $this->stoken_opt_welcome_msg);
		update_option("stoken_opt_not_found_msg", $this->stoken_opt_not_found_msg);
		update_option("stoken_opt_enable_focus_onload", $this->stoken_opt_enable_focus_onload);
		update_option("stoken_opt_show_author", $this->stoken_opt_show_author);
		

		$this->wpdb->print_error();

	}
	
}

?>