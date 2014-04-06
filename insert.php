<?php 
		$link = mysql_connect('localhost', 'root', '');
		
		if (!$link) {
			return false;
		}
		
		mysql_select_db("city_like" ,$link);
		
		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'");
		
		$query = "INSERT INTO users ".
				 "(first_name, last_name, birth_date, network_avatar, network_id, sex, registration_date) ".
				 "VALUES ( '123', '123', '123', '123', '123', '123', '123' )";
		
		$sql = mysql_query($query ,$link);
		
		if(! $sql )
		{
		  die('Could not enter data: ' . mysql_error());
		}
		
		mysql_close($link);
		
?>