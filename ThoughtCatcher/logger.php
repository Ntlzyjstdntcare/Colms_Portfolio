<?php
session_start();

include "Scripts/connect_to_mysql.php";

if(isset($_SESSION['userID']))
{
    $userID = $_SESSION['userID'];
}
if(!isset($_SESSION['name']))
{
    $sql = mysql_result(mysql_query("SELECT username FROM users WHERE id = '1' LIMIT 1"),0);
	$_SESSION['name'] = $sql;
}

if (isset($_SESSION['name']) && isset($_POST['thought']))
{	
	$thought=mysql_real_escape_string($_POST['thought']);	
	
	
	$sql=mysql_query("INSERT INTO thoughts(thought, last_log_date)
	       VALUES('$thought', now())") or die (mysql_error());
		   
	$sql=mysql_result(mysql_query("SELECT id FROM thoughts WHERE thought='$thought' LIMIT 1"), 0);
	$_SESSION['thought'] = true;	   
	$_SESSION['recordID'] = $sql;	   
		
	$_SESSION['posted_stuff'] = true;
	header("location: graph.php ");
	exit();
	
}
if(isset($_GET['cmd']) && $_GET['cmd'] == "previous")
{
    $sql=mysql_result(mysql_query("SELECT id FROM thoughts ORDER BY id DESC LIMIT 1"), 0);
	$_SESSION['last_id'] = $sql;
	$_SESSION['previous'] = $sql;
	
	header("location: thoughts.php");
	exit();
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Logging Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	    <head>
	    <body>
		<p style="font-size: 40px"><strong> <?php echo $_SESSION['name'];?></strong></p>
		<p>Date: <?php  echo date("l, j M Y"); ?> <br/><br/><br/></p>
		<div style="position:absolute; top:10px;  LEFT:300px;">
		<img src="Images/thought_icon_active.png" alt="Thought Icon" width="120" height="120">
		</div>
		<div style="position:absolute; top:10px;  LEFT:450px;">
		<a href="graph.php"><img src="Images/mood_icon_inactive.jpg" alt="Mood Icon" width="120" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:750px;">
		<a href="exit.php"><img src="Images/exit.jpg" alt="Exit Icon" width="100" height="100"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:600px;">
		<a href="CBT.php"><img src="Images/Diary.png" alt="Diary Icon" width="100" height="120"></a>
		</div>
		<p>What's on your mind?</p>
		<div style="float:left">
		<a href="logger.php?cmd=previous"><img src="Images/previous.jpg" alt="previous thoughts" height="120px" width="120px"></a>
		</div>
		<div>
		<form action="logger.php" method="POST">
		<textarea name="thought" rows="10" cols="100" maxlength="800">Max number characters: 800</textarea>
	    <br/>
		<br/>
		<br/>
		<br/>
	    <input type="submit" value="Enter" style="font-size:20px;"/>
		<br/>
		<br/>
	    </form>
		</div>
		</body>
		</html>