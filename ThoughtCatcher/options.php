<?php
session_start();

$name = $_SESSION['name'];

if(isset($_GET['cmd']) && $_GET['cmd'] == "yes" && ($_SESSION['mood'] == "a" || $_SESSION['mood'] == "b"))
{
	header("location: CBT.php");
	exit();
}

if(isset($_GET['cmd']) && $_GET['cmd'] == "yes" && $_SESSION['mood'] == "c" )
{
	header("location: tip.php");
	exit();
}

if(isset($_GET['cmd']) && $_GET['cmd'] == "yes" && ($_SESSION['mood'] == "d" || $_SESSION['mood'] == "e"))
{
	header("location: mindfulness.php");
	exit();
}

if(isset($_GET['cmd']) && $_GET['cmd'] == "no")
{
	header("location: confirmation.php");
	exit();
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
             <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		    <title>Option Page</title>
		    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	        <head>
	        <body>
		    <p style="font-size: 40px"><strong> <?php echo $name; ?></strong></p>
		    <p>Date: <?php  echo date("l, j M Y"); ?> <br/><br/><br/></p>
		    <div style="position:absolute; top:10px;  LEFT:300px;">
		    <a href="logger.php"><img src="Images/thought_icon_inactive.png" alt="Thought Icon" width="120" height="120"></a>
		    </div>
		    <div style="position:absolute; top:10px;  LEFT:450px;">
		    <img src="Images/mood_icon_active.jpg" alt="Mood Icon" width="120" height="120">
		    </div>
			<div style="position:absolute; top:10px;  LEFT:750px;">
		    <a href="exit.php"><img src="Images/exit.jpg" alt="Exit Icon" width="100" height="100"></a>
		    </div>
			<div style="position:absolute; top:10px;  LEFT:600px;">
		    <a href="CBT.php"><img src="Images/Diary.png" alt="Diary Icon" width="100" height="120"></a>
		    </div>
		    <p style="position:relative; top:15px; font-size:35px; color:blue;">
			<br/><br/><br/><br/>Would you like to try a guided exercise to improve your mental health?
			</p>
			</br>
			</br>
			<div align="left">
			<a href="options.php?cmd=yes" style="position:relative; left:345px;"><img src="Images/yes_button.jpeg" alt="Yes" width="100" height="50"></a>
			<a href="options.php?cmd=no" style="position:relative; left:445px;"><img src="Images/no_button.jpeg" alt="Yes" width="100" height="50"></a>
			</div>
			<div>
			</div>
		    </body>
			</html>