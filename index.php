<?php

 error_reporting(E_ALL);
 ini_set('display_errors', 1);

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
		
		// default values for user_name and avatars. Only if user_info is defined
		if ($user_info) {
			(isset($instance['articles'])) ? $instance['articles'] : array();
			$user_info['name'] = (empty($user_info['first_name'])) ? $user_info['user_name'] : $user_info['first_name'].' '.$user_info['last_name'];
			$user_info['network_avatar'] = (empty($user_info['network_avatar'])) ? 'assets/images/default_avatar.png' : $user_info['network_avatar'];
		}

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
		$sql = mysql_query("SELECT * FROM members ORDER BY RAND()" ,$link);
		
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
	
	/**
	* Return false or array with user info username, email
	*
	**/
	private function isUserExist($required_filed, $additional_field = 'additional_field')
	{
		$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
			
			if (!$link) {
				return false;
			}
			
			mysql_select_db("city_like" ,$link);
			
			mysql_query("SET NAMES 'utf8'"); 
			mysql_query("SET CHARACTER SET 'utf8'");

			$sql = mysql_query("SELECT * FROM users WHERE user_name='$required_filed' OR email='$required_filed' OR user_name='$additional_field' OR email='$additional_field'" ,$link);
			
			$result = mysql_fetch_assoc($sql);
			
			mysql_close($link);
			
			if (! $result) return false;
			
			return $result;
	}
	
	private function addUser($user_name, $email, $password, $first_name, $last_name, $birth_day, $sex, $network_avatar, $network_id, $network)
	{
		if ($this->isAuth()) return;
	
		$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
		
		if (!$link) {
			return false;
		}
		
		mysql_select_db("city_like" ,$link);
		
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'");
		
		$session_id = md5($this->city_salt.$first_name.$email.$network_id.$network.(string)rand(0, 40514051));
		
		$query = "INSERT INTO users ".
				 "(user_name, email, password, first_name, last_name, birth_date, sex, network_avatar, network_id,  network, session_id, registration_date ) ".
				 "VALUES ('$user_name', '$email', '$password', '$first_name', '$last_name', '$birth_day', '$sex', '$network_avatar', '$network_id', '$network', '$session_id', '27.30.30' )";
		
		$sql = mysql_query($query ,$link);
		
		setcookie("session_id", $session_id, time()+60*60*24*30);
		
		mysql_close($link);
		
		return $sql;
	}
	
	private function addMember($first_name, $last_name, $permalink, $image)
	{
		$user_info = $this->isAuth();
		
		if (! $user_info) return;
		
		$user_id = $user_info['id_user'];
	
		$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
		
		if (!$link) {
			return false;
		}
		
		mysql_select_db("city_like" ,$link);
		
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'");
		
		$query = "INSERT INTO members ".
				 "(id_user, first_name, last_name, photo, permalink, votes) ".
				 "VALUES ('$user_id', '$first_name', '$last_name', '$image', '$permalink', '10')";
		
		$sql = mysql_query($query ,$link);
		
		mysql_close($link);
		
		return $sql;
	}
	
	private function loginUser($login_name, $password)
	{	
		if ($this->isAuth()) return;
		
		$link = mysql_connect($this->DB_host, $this->DB_username, $this->DB_password);
		
		if (!$link) {
			return false;
		}
		
		mysql_select_db("city_like" ,$link);
		
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'");
		
		$sql = mysql_query("SELECT * FROM users WHERE user_name='$login_name' AND password='$password' OR email='$login_name' AND password='$password'", $link);
		
		$result = mysql_fetch_assoc($sql);
		
		mysql_close($link);
		
		if (! $result) return false;
		
		setcookie("session_id", $result['session_id'], time()+60*60*24*30);
		
		return true;;
	}
	
	public function route()
	{
		if (isset($_GET['upload']) && $_GET['upload'] == true) {
			if (isset($_FILES['file'])) {
			
				$types = array('image/png', 'image/jpeg');
			
				if (!in_array($_FILES['file']['type'], $types)) exit('error_type');

				if ($_FILES['file']['size'] > 1024*3*1024) exit('error_size');
				
				$path = self::sanitizeTextField($_FILES['file']['name']);
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				
				$update_filename = time().".".$ext;
				
				move_uploaded_file($_FILES["file"]["tmp_name"], 'upload_dir/' . $update_filename);
				exit($update_filename);
			}
		}
		
		if (isset($_GET['crop']) && $_GET['crop'] == true) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$src = 'upload_dir/'.self::sanitizeTextField($_POST['src']);
				$coor_x = intval($_POST['x']);
				$coor_y = intval($_POST['y']);
				$coor_w = intval($_POST['w']);
				$coor_h = intval($_POST['h']);
				$ext = pathinfo($src, PATHINFO_EXTENSION);
				$update_filename = time().".".$ext;
				$upload_folder = 'images/squareform/';
				
				switch ($ext) {
					case 'jpeg':
						$targ_w = $targ_h = 270; 
						$jpeg_quality = 98;
						$img_r = imagecreatefromjpeg($src); 
						$dst_r = ImageCreateTrueColor( $targ_w, $targ_h ); 
						imagecopyresampled($dst_r, $img_r, 0, 0, $coor_x, $coor_y, $targ_w, $targ_h, $coor_w, $coor_h);
						header('Content-type: image/jpeg'); 
						imagejpeg($dst_r,$upload_folder.$update_filename, $jpeg_quality); 
						echo $upload_folder.$update_filename; 
						exit;
					break;
					case 'jpg':
						$targ_w = $targ_h = 270; 
						$jpeg_quality = 98;
						$img_r = imagecreatefromjpeg($src); 
						$dst_r = ImageCreateTrueColor( $targ_w, $targ_h ); 
						imagecopyresampled($dst_r, $img_r, 0, 0, $coor_x, $coor_y, $targ_w, $targ_h, $coor_w, $coor_h);
						header('Content-type: image/jpeg'); 
						imagejpeg($dst_r,$upload_folder.$update_filename, $jpeg_quality); 
						echo $upload_folder.$update_filename; 
						exit;
					break;
					case 'png':
						$targ_w = $targ_h = 270; 
						$img_r = imagecreatefrompng($src); 
						$dst_r = ImageCreateTrueColor( $targ_w, $targ_h ); 
						imagecopyresampled($dst_r, $img_r, 0, 0, $coor_x, $coor_y, $targ_w, $targ_h, $coor_w, $coor_h);
						header('Content-type: image/png'); 
						imagepng($dst_r,$upload_folder.$update_filename); 
						echo $upload_folder.$update_filename; 
						exit;
					break;
				}
			}
		}
		
		if (isset($_GET['participate']) && $_GET['participate'] == true) {
			if (isset($_POST['member'])) {
				$member_data = $_POST['member'];

				$first_name = self::sanitizeTextField($member_data['first_name']);
				$last_name = self::sanitizeTextField($member_data['last_name']);
				$permalink = self::sanitizeTextField($member_data['permalink']);
				$image = self::sanitizeTextField($member_data['image']);

				$success = $this->addMember($first_name, $last_name, $permalink, $image);
				if (!$success) exit("error");
				$member_info = array();
				$member_info['first_name'] = $first_name;
				$member_info['last_name'] = $last_name;
				$member_info['permalink'] = $permalink;
				$member_info['image'] = $image;
				exit(json_encode($member_info));
			}
		}
		
		if (! isset ($_GET['authorization']) && ! isset ($_GET['code'])) return false;
		
		if (isset ($_GET['authorization'])) {
			switch ($_GET['authorization']) {
				case 'vk':
					//if (isset($_POST['user_data'])) echo json_decode($_POST['user_data']['uid']); exit;
					if (isset($_POST['user_data'])) {
						$user_data = $_POST['user_data'];
						
						$user_name = '';
						$email = '';
						$password = '';
						$first_name = self::sanitizeTextField($user_data['first_name']);
						$last_name = self::sanitizeTextField($user_data['last_name']);
						$sex = intval($user_data['sex']);
						$birth_day = self::sanitizeTextField($user_data['bdate']);
						$network_avatar = self::sanitizeTextField($user_data['photo_small']);
						$network_id = self::sanitizeTextField((string)$user_data['uid']);
						$network = 'vk';
						
						$success = $this->addUser($user_name, $email, $password, $first_name, $last_name, $birth_day, $sex, $network_avatar, $network_id, $network);
						if (!$success) exit('error');
						exit('4051');
					}
					break;
				case 'email':
					if (isset($_POST['user'])) {
						$error_code = 0;
						
						$user_data = $_POST['user'];
						
						$user_name = self::sanitizeTextField($user_data['name']);
						if (empty($user_name) || !isset($user_name) || strlen($user_name) <5) $error_code = 1;
						$email = self::sanitizeTextField($user_data['email']);
						if (empty($email) || !isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $error_code = $error_code + 10;
						$password = self::sanitizeTextField($user_data['password'], false);
						if (empty($password) || !isset($password) || strlen($password) <5) $error_code = $error_code + 100;
						
						if ($error_code != 0) exit((string)$error_code);
						
						$user_info = $this->isUserExist($user_name, $email);
						
						if ($user_info) {
							if (in_array($user_name, $user_info)) $error_code = 2;
							if (in_array($email, $user_info)) $error_code = $error_code + 20;
							
							if ($error_code != 0) exit((string)$error_code);
						};
						
						$password = md5($password);
						$first_name = '';
						$last_name = '';
						$sex = '';
						$birth_day = '';
						$network_avatar = '';
						$network_id = '';
						$network = 'email';
						
						$success = $this->addUser($user_name, $email, $password, $first_name, $last_name, $birth_day, $sex, $network_avatar, $network_id, $network);
						if (!$success) exit('error');
						exit('4051');
						
					}
					break;
				case 'login':
					if (isset($_POST['login'])) {
						$error_code = 0;
						
						$login_data = $_POST['login'];
						
						// login_name variable maybe email or username
						$login_name = self::sanitizeTextField($login_data['name']);
						if (empty($login_name) || !isset($login_name) || strlen($login_name) <5) $error_code = 3;

						$password = self::sanitizeTextField($login_data['password'], false);
						if (empty($password) || !isset($password) || strlen($password) <5) $error_code = $error_code + 30;
						
						if ($error_code != 0) exit((string)$error_code);
						
						$login_info = $this->isUserExist($login_name);
						
						// if login user not found in database send 40 status code
						if (! $login_info) exit('300');
						
						$password = md5($password);
						
						if (! $this->loginUser($login_name, $password)) exit('3000');
						exit('4051');
						
					}
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
		
		// Instagram auth, we can't recieve token ajax or another ways
		if($_GET['code']) {
			$code = $_GET['code'];
			$url = "https://api.instagram.com/oauth/access_token";
			$access_token_parameters = array(
					'client_id'                =>     '1658ab65bb8b480a869d1be346857070',
					'client_secret'            =>     'd90e5c3697b442aba27601e09594b181',
					'grant_type'               =>     'authorization_code',
					'redirect_uri'             =>     'http://city-like.ru',
					'code'                     =>     $code
			);
			$curl = curl_init($url);    // we init curl by passing the url
 			curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
			curl_setopt($curl,CURLOPT_POSTFIELDS,$access_token_parameters);   // indicate the data to send
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
			$result = curl_exec($curl);   // to perform the curl session
			curl_close($curl);   // to close the curl session

			$user_data = json_decode($result,true);

			$user_name = self::sanitizeTextField($user_data['user']['username']);
			$email = '';
			$password = '';
			$first_name = self::sanitizeTextField($user_data['user']['full_name']);
			$last_name = '';
			$birth_day = '';
			$sex = '';
			$network_avatar = self::sanitizeTextField($user_data['user']['profile_picture']);
			$network_id = self::sanitizeTextField((string)$user_data['user']['id']);
			$network = 'ig';
			
			$success = $this->addUser($user_name, $email, $password, $first_name, $last_name, $birth_day, $sex, $network_avatar, $network_id, $network);
			if (!$success) exit('error');
			header("Location:index.php");
		}
	}
	
	static public function sanitizeTextField($str, $trim = true){
		if ($trim === true) $str = trim($str);
        $str = strip_tags($str);
        $str = mysql_real_escape_string($str);
		$str = strtolower($str);
        return $str;
	}
}

new City_Like_Project();

?>