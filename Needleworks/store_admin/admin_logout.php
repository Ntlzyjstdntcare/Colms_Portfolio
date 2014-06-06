<?php
//Avail of the core file's functions and variables
require '../core.php';
//Destroy the session
session_destroy();
//Send the admin back to the admin login page
header('Location: admin_login.php');

?>