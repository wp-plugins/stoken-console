<?php


class StokenAdminFormTokenList extends StokenAdminForm
{
	
	public $wpdb;
	public $tokens;
	
	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
		$stokenConfig = StokenConfig::getInstance();
				
		$table = $stokenConfig->stoken_db_table_stoken_token;
		$query = "SELECT id, token, secret FROM $table;";
		$this->tokens = $wpdb->get_results($query);
	}
	
	
	public function show()
	{		
		$out =  '<h1>SToken Console - Token-Controlled Secrets for your Wordpress Site</h1>';
		$out .= '<p>For more information and examples, visit <a href="http://labs.leftcolumn.net/stoken-console/">labs.leftcolumn.net/stoken-console/</a></p>';
		
		$out .= '<div class="stokenTokenList">';
		$out .= '<p><a class="btn" href="?page=stoken/stoken_admin.php&stokenpage=add"><span>Add a New Token</span></a></p>';
		$out .= '<table class="stokenTable" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<th>Token</th>
				<th>Secret</th>
				<th>Actions</th>
			</tr>';
			
		$styles = array('odd','even');
		$rownum = 0;
				
		$url_edit = '?page=stoken/stoken_admin.php&stokenpage=edit&id=';
		$url_del = '?page=stoken/stoken_admin.php&stokenpage=delete&id=';	
		
		if (isset($this->tokens) && count($this->tokens) > 0) {


			foreach ($this->tokens as $onerow) {

				$out .= "<tr class='" . $styles[$rownum % 2] . "'>";
				$out .= "<td><a class='stokentext' href='{$url_edit}{$onerow->id}'>" .$onerow->token ."</a></td>";
				$out .= "<td><a class='stokentext' href='{$url_edit}{$onerow->id}'>" .$onerow->secret ."</a></td>";
				$out .= "<td class='btns'><a class='btn' href='{$url_edit}{$onerow->id}'><span>Edit</span></a> <a class='btn' href='{$url_del}{$onerow->id}'><span>Delete</span></a></td>";
				$out .= "</tr>";
				$rownum++;


			}
		} else {
			$out .= "<tr class='" . $styles[$rownum % 2] . "'>";

			$empty_message = 'No Tokens .';

			$out .= "<td colspan='5'>{$empty_message}</td>";

			$out .= "</tr>";

		}
		
		$out .= '</table></div>';
	
	echo $out;	
		
	}
	
}

?>