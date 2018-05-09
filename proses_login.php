<?php
error_reporting(0);
require( dirname(__FILE__).'/config.php' );

$username = $_POST['username'];
$password = md5($_POST['password']); 
$login   = mysql_query("SELECT * FROM admin WHERE username='$username' and password='$password'"); 
$row = mysql_fetch_array($login);
if ($row['username'] == $username AND $row['password'] == $password)
{
	session_start();
	$_SESSION['username'] = $row['username'];
	$_SESSION['password'] = $row['password'];
	header( "Location: ".URL."/index.php" );

}

else
{
	msgbox ("Gagal Login","login.php");
}


?>
