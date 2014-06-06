<?php
//Avail of core functions and variables
require "../core.php";
//Connect to databse
require "../storescripts/connect_to_mysql.php"; 
//If the admin is logged in...
if(isset($_SESSION['id']) && !empty($_SESSION['id']))
{
    //...display logout link   
    echo '<a href="admin_logout.php">Log Out</a>';
} 
?>