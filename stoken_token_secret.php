<?php



final class StokenTokenSecret
{	
		// 
		public $wpdb;
		public $valid_pair; 
		protected static $_instance;
		
		// public $stoken_db_version;
		// protected static $_instance;

	
    protected function __construct()
    { 		
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->valid_pair =  false;	
	
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


	public function validToken($token='')
	{
		if (strlen($token) >= 1) {

			return true;
		} else {
			return false;
		}
		
	}
	
	public function validSecret($secret='')
	{
		if (strlen($secret) < 1) {			
			return false;
		} else {
			return true;
		}
		
	}
	
	public function validId($id='')
	{
		if ($id > 0) {			
			return true;
		} else {
			return false;
		}
		
	}
	
	
	public function cleanToken($token='')
	{
		$token = trim($token);
		$token = substr($token, 0, 255);		
		return $token;
	}
	
	public function cleanSecret($secret='')
	{
		$secret = trim($secret);
		$secret = substr($secret, 0, 16777215);
		return $secret;
	}
	
	public function cleanId($id='')
	{
		$id = trim($id);
		$id = substr($id, 0, 11);
		$id = (int)$id;
		return $id;
	}



	public function saveNew($token, $secret) 
	{
		$stokenConfig 		= StokenConfig::getInstance();
		$token				= $this->cleanToken($token);
		$secret 			= $this->cleanSecret($secret);
			
		if (!$this->validToken($token)) {
			echo '<br>cannot add: invalid token';
			return false;	
		} 
		
		if (!$this->validSecret($secret)) {
			echo '<br>cannot add: invalid secret';
			return false;
		} 
	
		$this->wpdb->query( $this->wpdb->prepare( "
			INSERT INTO $stokenConfig->stoken_db_table_stoken_token
			( token, secret )
			VALUES ( %s, %s )", 
		        $token, $secret ) );			

		$this->wpdb->print_error();

	}
	
	public function saveExisting($id, $token, $secret) 
	{
		$stokenConfig 		= StokenConfig::getInstance();
		$id					= $this->cleanId($id);
		$token				= $this->cleanToken($token);
		$secret 			= $this->cleanSecret($secret);
			
			
		if (!$this->validId($id)) {
			echo '<br>cannot add: invalid id';
			return false;	
		}
		
		if (!$this->validToken($token)) {
			echo '<br>cannot add: invalid token';
			return false;	
		} 
		
		if (!$this->validSecret($secret)) {
			echo '<br>cannot add: invalid secret';
			return false;
		} 
	
	
		$this->wpdb->update(
		  $stokenConfig->stoken_db_table_stoken_token,
		  array( 'token' => $token, 'secret' => $secret ),
		  array( 'id' => $id )
		);		

		
		$this->wpdb->print_error();

	}
	
	public function delete($id) 
	{
		$stokenConfig 		= StokenConfig::getInstance();
		$id				= $this->cleanId($id);
			
		if (!$this->validId($id)) {
			echo '<br>cannot delete: invalid id';
			return false;	
		} 
		
		$this->wpdb->query("
			DELETE FROM $stokenConfig->stoken_db_table_stoken_token WHERE id = '{$id}'");			

		$this->wpdb->print_error();

	}
	
	
	public function fetch($token='')
	{
		$stokenConfig = StokenConfig::getInstance();
		$token				= $this->cleanToken($token);
			
		if ($this->validToken($token)) {
		
			$table = $stokenConfig->stoken_db_table_stoken_token;
			$query = "SELECT id, token, secret FROM $table WHERE token = '{$token}' LIMIT 1";
			$this->tokens = $this->wpdb->get_results($query);
		
			if (isset($this->tokens) && count($this->tokens) > 0) {

				return esc_html($this->tokens[0]->secret);

			} 
		
		}
		
		return $stokenConfig->notFoundMessage;
		

	}
	
	
	public function fetchAll($id='')
	{
		$stokenConfig = StokenConfig::getInstance();
		$id				= $this->cleanId($id);
			
		if ($this->validId($id)) {
		
			$table = $stokenConfig->stoken_db_table_stoken_token;
			$query = "SELECT id, token, secret FROM $table WHERE id = '{$id}' LIMIT 1";
			$this->tokens = $this->wpdb->get_results($query);
		
			if (isset($this->tokens) && count($this->tokens) > 0) {
				
				return $this->tokens[0];
				//return esc_html($this->tokens[0]->secret);

			} 
		
		}
		
		return false;
		

	}
	
	
}



?>