<!--The user is sent to this page upon succesful registration-->


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>NeedleWorks Home Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>		
	<head>
	
	<body>
	    <!--Main div that encloses everything in the body-->
		<div align="center" id="mainWrapper">
		<!--Inserts html code that is saved in header php file-->
		<?php include_once("register_success_header.php");?>
		<!--Inner div-->
		<div id="pageContent" >
		<p style="padding:20px; border-bottom: 1px solid black;">
		<strong>You have successfully registered! Now you can <a href="index.php" alt="index">log in</a>.</strong>
		</p>
		</div>
		<div>
		<!--Inserts html saved in footer file-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>
		
		