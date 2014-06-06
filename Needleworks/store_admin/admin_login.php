<?php
//SECTION 1
//Start the session, in order to use session variables
session_start();
//Connect to the MySQL database
include"../storescripts/connect_to_mysql.php";
//If the manager session variable has been set (by the form details being posted and then the form variables being placed 
//in the session variable (see below)...
if(isset($SESSION["manager"]))
{
    //...then send user to the store_admin index page, and don't run the following php code
    header("location: index.php");
	exit();
}
?>
<?php
//SECTION 2
//Parse the log in form from the below html if the user has submitted the form
if(isset($_POST["username"])&&isset($_POST["password"]))
{
    //Put the entered form details into these two local variables, encrypting the password
	$manager=$_POST["username"];
	$password=md5($_POST["password"]);
	
	//This query selects the id from the database for the user with the entered username and password
	$sql=mysql_query("SELECT id FROM users WHERE username='".mysql_real_escape_string($manager)."' AND password='".mysql_real_escape_string($password)."' AND admin='true' LIMIT 1");
	//Count the number of rows that the above query returns
	$existCount=mysql_num_rows($sql);
	//If there is one such row (one such user)...
	if($existCount==1)
	{
	    //...pull out each row one by one (since there's one row, we pull out that row
	    while($row=mysql_fetch_array($sql))
		{
		    //Put the id into a local variable
			$id=$row["id"];
		}
		//Create session variables using the three local variables that we have instantiated on this page
		$_SESSION["id"]=$id;
		$_SESSION["manager"]=$manager;
		$_SESSION["password"]=$password;
		//Update the admin table's last login attribute
		$sql=mysql_query("UPDATE users SET last_log_date=now() WHERE id = '$id'");
		//Send the user to the store_admin index page now that they have successfully logged in. We will use our new session variable there
		header("location: index.php");
		exit();
	} else
	{
	    //Otherwise, if there is not exactly one user with the entered username and password
		//give the user the below message, giving them the option to reenter the details
	    echo'That information is incorrect, please try again.';
		//exit();
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Admin Log In</title>
		<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <!--Main div-->
		<div align="center" id="mainWrapper">
		<!--Insert the header php-->
		<?php include_once("template_header.php");?>
		<!--Inner div-->
		<div id="pageContent"><br/>
		<!--Inner inner div-->
		<div align="left" style="margin-left:24px;">
		<h2>Please Log In To Manage the Store</h2>
		<!--Log-in form that provides the post variable for the php script above-->
		<form id="form1" name="form1" method="post" action="admin_login.php">
		User Name:<br/>
		<input name="username" type="text" id="username" size="40"/>
		<br/><br/>
		Password:<br/>
		<input name="password" type="password" id="password" size="40"/>
		<br/>
		<br/>
		<br/>
		<input type="submit" name="button" id="button" value="Log In"/>
		</form>
		</div>
		<br/>
		<br/>
		<br/>
		</div>
		<!--Insert footer php-->
		<?php include_once("../template_footer.php");?>
		</div>
	</body>
</html>