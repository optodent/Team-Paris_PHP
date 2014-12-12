<?php
ob_start();
session_start();

//database connection
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','php_blog');
$dataBase = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
//handle error reporting
$dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

date_default_timezone_set('Europe/Sofia');

//loading user class
require_once("../classes/classUser.php");
$user = new User($dataBase);

?>