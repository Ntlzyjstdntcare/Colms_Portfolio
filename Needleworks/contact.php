<?php
//This function is called in order to avoid unwanted notices (not errors) appearing on the page
error_reporting(0);
//Begin a session
session_start();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Contact Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <!--Main div that encloses everything in the body-->
		<div align="center" id="mainWrapper">
		<!--Inserts html code that is saved in header php file-->
		<?php include_once("template_header.php");?>
		<!--Inner div-->
		<div id="pageContent">
		<br/>
		<br/>
		<p align="left">
		<strong>Telephone:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="callto&#58;+35319996666">Call NeedleWorks</a>
		<br/>
		<br/>
		<strong>Email:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; info@needleworks.ie
		<br/>
		<br/>
		<strong>Postal Address:</strong>&nbsp; 44 Woolen Avenue, Yarn, Ireland
		</p>
		<br/>
		<br/>
		</div>
		<!--Inserts html saved in footer file-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>