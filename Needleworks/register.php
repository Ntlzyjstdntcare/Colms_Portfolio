<?php
error_reporting(0);
//We avail of the core.php functions and variables
require 'core.php';
//Connect to the database
require "storescripts/connect_to_mysql.php"; 

//If the user is logged in...
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
    //...echo this message
	echo 'You\'re already registered and logged in.'; 
//If they are not logged in
} else
{
	//If the user has entered non-null values in the registration form below...
	if(isset($_POST['username']) && ($_POST['username'] != "") && isset($_POST['password']) && ($_POST['password'] != "") 
	&& isset($_POST['password_again']) && ($_POST['password_again'] != ""))
	{
		//...assign the entered details to local variables
		$username=$_POST['username'];
		$password=md5($_POST['password']);
		
		//See if the username already exists
		$sql = mysql_query("SELECT username FROM users WHERE username = '".mysql_real_escape_string($username)."' AND admin= 'false'");
		if(mysql_num_rows($sql) == 1)
		{
			//If it does, echo this message
			echo 'The username ' . $username . ' already exists.';   
		//If the username does not exist...
		} else
		{
			//...add the username and password into a new tuple in the database
            //Also populate the date_added attribute			
		    if($sql = mysql_query("INSERT INTO users(username, password, date_added, admin)
			VALUES('$username', '$password', now(), 'false')"))			
			{
				//Then send the user to this page
				header('location: register_success.php');
				exit();
			//If there is some problem with adding the user to the database...
			} else
			{
				//...echo this message
				echo 'Sorry we couldn\'t register you at this time. Try again later.';
			}
		}
		
    }
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>NeedleWorks Home Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>	
        <script type="text/javascript" language="javascript" src="storescripts/storescripts.js"></script>		
	<head>
	
	<body>
	    <!--Main div that encloses everything in the body-->
		<div align="center" id="mainWrapper">
		<!--Inserts html code that is saved in header php file-->
		<?php include_once("template_header.php");?>
		<!--Inner div-->
		<div id="pageContent" align="left">
		<form action="register.php" enctype="multipart/form_data" name="registerForm" id="registerForm"method="POST" style="padding:20px;">
		<strong>Username:*</strong><input type="text" name="username" value="<?php echo $username ; ?>" style="position:absolute; LEFT:400px;"><br/><br/>
		<strong>Password:*</strong><input type="password" name="password" style="position:absolute; LEFT:400px;"><br/><br/>
		<strong>Password again:*</strong><input type="password" name="password_again" style="position:absolute; LEFT:400px;"><br/><br/>
		<input type="submit" name="register_button" value="Register" onclick="javascript:return validateRegisterForm();">
		</form>
		</div>
		<!--Inserts html saved in footer file-->
		<?php include_once("template_footer.php");?>
		</div>
	</body>
</html>