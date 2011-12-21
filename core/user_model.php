<?php
/**
 * Description of user_model
 *
 * @author alex
 */
class User {
	
	public $id;
	public $name;
	public $password;
	private $db;
	
	public function __construct() 
	{
		$this->db = Db::getInstance();
		$user_data =  $this->check();
		if ( ! empty ($user_data) )
		{
			foreach ($user_data[0] as $key => $value) 
			{
				$this->$key = $value;
			}
		}
	}
	
	
	function check()
	{
	
		$user_data = array();
		
		if (! empty( $_SESSION["name"] )  && ! empty( $_SESSION["password"] ))
		{
			$query = "SELECT id, name, password
						FROM Users 
						WHERE name = " . $this->db->quote($_SESSION["name"]) . "AND password =".  $this->db->quote($_SESSION["password"]);	
			
			$user_data = $this->db->get_results($query);
			
		}
		elseif ( ! empty( $_COOKIE["name"] )  && ! empty( $_COOKIE["password"] ) )
		{
			$query = "SELECT id, name, password
						FROM Users 
						WHERE name = " . $this->db->quote($_COOKIE["name"]) . "AND password =".  $this->db->quote($_COOKIE["password"]);
							
			$user_data = $this->db->get_results($query);
		}
		elseif ( ! empty( $_POST["name"] )  && ! empty( $_POST["password"] ) )
		{
				$query = "SELECT id, name, password
							FROM Users 
							WHERE name = " . $this->db->quote($_POST["name"]) . "AND password =".  $this->db->quote(md5($_POST["password"]));

				$user_data = $this->db->get_results($query);
		}
		
		
		
		return $user_data;
		
	}

	function getLoginLink()
	{
		
		$str = '';
		
		if ( ! empty ( $this->id ) )
		{	// logout
			$str = '<a href="/administrator.php?action=logout">${{logout_link}}</a>';
		}
		else
		{
			$str = '<a href="/administrator.php?action=login">${{login_link}}</a>';
		}
		
		return $str;
	}

}



?>
