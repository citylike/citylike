<?php

class City_Like_Project 
{
	public function __construct()
	{
		$this->loadHeader();
		$this->loadContent();
		$this->loadFooter();
	}
	
	public function loadHeader()
	{
		require('header.php');
	}
	
	public function loadContent()
	{
		require('content.php');
	}
	
	public function loadFooter()
	{
		require('footer.php');
	}
}

new City_Like_Project();

?>