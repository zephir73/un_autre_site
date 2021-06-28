<?php

Class Connection
{
	private $_bdd;
	
	//pour le pc
/*
	public function Bdd_get()
	{
		$this->_bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'cafejadore', 'ftiygBF05@@');
		return $this->_bdd;
	}
	*/
	
	//pour le server

	public function Bdd_get()
	{
		$host_name = 'db714629882.db.1and1.com';
		$database = 'db714629882';
		$user_name = 'dbo714629882';
		$password = 'changuitos';
		$this->_bdd = new PDO('mysql:host='.$host_name.';dbname='.$database.'', ''.$user_name.'', ''.$password.'');
		return $this->_bdd;
	}
	
	
}

?>