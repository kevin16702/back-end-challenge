<?php
// Defining constants

define('DB_TYPE', 'mysql');		
define('DB_HOST', '127.0.0.1'); 
define('DB_NAME', 'back-end-challenge'); 
define('DB_USER', 'root'); 		
define('DB_PASS', 'mysql');			
define('DB_CHARSET', 'utf8'); 

// opening a database connection

function openDatabaseConnection() 
{
	$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
	
	$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);

	return $db;
}

function stripData($data){
    $data = trim($data);
    $data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>