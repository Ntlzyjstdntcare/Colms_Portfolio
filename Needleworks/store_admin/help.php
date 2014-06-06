<?php
//Start session
session_start();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Help Page</title>
		<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <!--Main div that encloses everything in the body-->
		<div align="center" id="mainWrapper">
		<!--Inserts html code that is saved in header php file-->
		<?php include_once("template_header.php");?>
		<!--Inner div-->
		<div id="pageContent">
		<div align="right" style="margin-right:32px"><a href="inventory_list.php#inventoryForm">+ Add New Inventory Item</a></div>
		<br/>
		<br/>
		<h2>How To Use Our Site</h2>
		<br/>
		<br/>
		<p align="center">"Hodor ipsum Hodor, hodor. Hodor. Hodor, hodor - HODOR hodor, hodor hodor?! 
		Hodor! Hodor hodor, hodor hodor hodor?! Hodor, HODOR hodor, hodor hodor - hodor, hodor, hodor hodor. 
		Hodor hodor HODOR! Hodor hodor, hodor. Hodor hodor hodor hodor?! Hodor hodor - hodor HODOR hodor, hodor hodor, hodor. 
		Hodor hodor. Hodor. Hodor hodor HODOR! Hodor hodor hodor. Hodor."</p>
		<br/>
		<br/>
		</div>
		<!--Inserts html saved in footer file-->
		<?php include_once("admin_footer.php");?>
		</div>
	</body>
</html>