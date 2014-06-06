<?php
error_reporting(0);
//This script is inserted into headers throughout the site, to dynamically handle the different login scenarios
//We avail of the core.php file's functions and variables
require "core.php";
//Connect to the database
require "storescripts/connect_to_mysql.php"; 

//If the user is logged in, display the a 'logout' link and put their username in a variable for display in the html code
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
    echo '<a href="logout.php">Log Out</a>';
	$user_id = $_SESSION['user_id'];
	$sql=mysql_result(mysql_query("SELECT username FROM users WHERE id = '".mysql_real_escape_string($user_id)."'"), 0);
	$username = $sql;
	$_SESSION['username'] = "Hello " . $username . "!";
//Otherwise...	
} else
{
    //...display the login form
    include "login_form.php";
}
?>