<?php
//Start a session in order to use session variables
session_start();
//Connect to the database
include "Scripts/connect_to_mysql.php";

if(isset($_POST['begin']))
{
    $sql = mysql_query("SELECT * FROM users LIMIT 1");
    $num_rows=mysql_num_rows($sql);
	if ($num_rows > 0)
	{
	    header("location: logger.php ");
	    exit();
	} else
    {
        header("location: enter_username.php");
		exit();
    }	
	
	
	$_SESSION['name'] = $name;

	//See if the customer is already in the system.
	$sql =mysql_query("SELECT id FROM users WHERE username = '$name' LIMIT 1");
	
	$userMatch=mysql_num_rows($sql);
	if ($userMatch > 0)
	{
	    //If it is, insert the date of login into the database, and then send the user to logger page.
		$sql=mysql_query("UPDATE users SET last_log_date=now() WHERE username='$name'")
	    or die (mysql_error());
		$sql = mysql_result(mysql_query("SELECT id FROM users WHERE username = '$name' LIMIT 1"),0);
	    $_SESSION['userID'] = $sql;
	header("location: logger.php ");
	    exit();
	} else
	{
	    //if the customer is not in the system, add it to the database
	    //Run an sql query to insert the product details into the database
	    $sql=mysql_query("INSERT INTO users(username, last_log_date)
	                      VALUES('$name', now())") or die (mysql_error());
	    $sql = mysql_result(mysql_query("SELECT id FROM users WHERE username = '$name' LIMIT 1"),0);
	    $_SESSION['userID'] = $sql;	   
	
	    header("location: logger.php ");
        exit();
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>ThoughtCatcher Home Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
		<div style="float: left; position:relative; TOP:15px; LEFT:170px;">
		<img src="Images/thought_icon_inactive.png" alt="Thought Icon" width="120" height="120">
		</div>
		<div style="float: right; position:relative; TOP:15px; RIGHT:170px;">
		<img src="Images/mood_icon_inactive.jpg" alt="Mood Icon" width="120" height="120">
		</div>
		<div align="center" style="position:relative; top:125px; font-size:35px; color:blue;"><h1>Welcome!</h1></div>
		<div style="position:relative; top: 200px;"><p style="font-size:20px;">Store your thoughts and moods here.</p></div>
		<div style="position:relative; top: 270px; left: 120px;">
		    <form action="index.php" method="POST">
			<br/>
		    <br/>
		    <br/>
			<input type="submit" value="Begin" name="begin" style="position:relative; left: 500px; font-size:30px;"/>
			<br/>
		    <br/>
		    <br/>
			</form>
		</div>
	
	</body>
</html>