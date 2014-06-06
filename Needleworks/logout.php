<?php
error_reporting(0);
//On a user logging out, the session is destroyed and they are returned to the home page
require 'core.php';
session_destroy();
header('Location: index.php' );

?>