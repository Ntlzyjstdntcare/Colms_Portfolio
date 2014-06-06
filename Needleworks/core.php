<?php

//We occasionally call this code in other files in order to avail of its functions and server variables
error_reporting(0);
session_start();
$current_file = $_SERVER['SCRIPT_NAME'];
$http_referer = $_SERVER['HTTP_REFERER'];


?>