<?php

class City_Like_Project 
{
	private $DB_host = '109.120.150.218';
	private $DB_username = 'root';
	private $DB_password = 'opensky24ilovephp1';
	
	//private $DB_host = 'localhost';
	//private $DB_username = 'root';
	//private $DB_password = '';
	private $city_salt = '613152196cb8a9243d5ef9d751bdc0e4';

	public function __construct()
	{
		$this->route();
		$this->loadHeader();
		$this->loadContent();
		$this->loadFooter();
	}
	
	public function loadHeader()
	{
		require('partials/header.php');
	}
	
	public function loadContent()
	{
		$members = $this->getMembers();
		
		$user_info = $this->isAuth();
		
		require('partials/content.php');
	}
	
	public function loadFooter()
	{
		require('partials/footer.php');
	}
	
	private function getMembers()
	{
		$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
		
		if (!$link) {
			return false;
		}
		
		mysql_select_db("city_like" ,$link);
		
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'"); 
		
		// select users only with participate 1!
		$sql = mysql_query("SELECT * FROM members" ,$link);
		
		while($row = mysql_fetch_assoc($sql)){
			 $result[] = $row;
		}
		
		mysql_close($link);
		
		return $result;
	}
	
	/**
	* Return false or array with user info by session ID
	*
	**/
	private function isAuth()
	{
		if (isset($_COOKIE['session_id']) && !empty($_COOKIE['session_id'])) {
			
			$session_id = $_COOKIE['session_id'];
			
			$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
			
			if (!$link) {
				return false;
			}
			
			mysql_select_db("city_like" ,$link);
			
			mysql_query("SET NAMES 'utf8'"); 
			mysql_query("SET CHARACTER SET 'utf8'");

			$sql = mysql_query("SELECT * FROM users WHERE session_id='$session_id'" ,$link);
			
			$result = mysql_fetch_assoc($sql);
			
			mysql_close($link);
			
			if (! $result) return false;
			
			return $result;
		}
		
		return false;
	}
	
	private function addUser($first_name, $last_name, $birth_day, $network_avatar, $network_id, $sex, $network)
	{
		if ($this->isAuth()) return;
	
		$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
		
		if (!$link) {
			return false;
		}
		
		mysql_select_db("city_like" ,$link);
		
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'");
		
		$session_id = md5($this->city_salt.$network.$network_id);
		
		$query = "INSERT INTO users ".
				 "(first_name, last_name, birth_date, network_avatar, network_id, sex, network, session_id, registration_date ) ".
				 "VALUES ( '$first_name', '$last_name', '$birth_day', '$network_avatar', '$network_id', '$sex', '$network', '$session_id', '27.30.30' )";
		
		$sql = mysql_query($query ,$link);
		
		setcookie("session_id", $session_id, time()+60*60*24*30);
		
		mysql_close($link);
		
		return $sql;
	}
	
	private function deleteUser()
	{	
		
	}
	
	public function route()
	{
		if (! isset ($_GET['authorization']) ) return false;
		
		switch ($_GET['authorization']) {
			case 'vk':
				//if (isset($_POST['user_data'])) echo json_decode($_POST['user_data']['uid']); exit;
				if (isset($_POST['user_data'])) {
					$user_data = $_POST['user_data'];
					
					$first_name = $user_data['first_name'];
					$last_name = $user_data['last_name'];
					$birth_day = $user_data['bdate'];
					$network_avatar = $user_data['photo_small'];
					$network_id = (string)$user_data['uid'];
					$sex = $user_data['sex'];
					$network = 'vk';
					
					exit ($this->addUser($first_name, $last_name, $birth_day, $network_avatar, $network_id, $sex, $network));
				}
				break;
			case 'ig':
				exit('instagram');
				break;
			case 'odn':
				exit('odnoklassniki');
				break;
			case 'exit':
				if (isset($_COOKIE['session_id']) && !empty($_COOKIE['session_id'])) {
					setcookie('session_id', '', time()-3600);
					header("Location:index.php");
				} else {
					return false;
				}
				break;
		}
	}
}

new City_Like_Project();

?>