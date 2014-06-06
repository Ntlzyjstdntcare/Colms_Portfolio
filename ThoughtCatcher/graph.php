<?php
session_start();

include "Scripts/connect_to_mysql.php";

if(isset($_SESSION['userID']))
{
    $userID = $_SESSION['userID'];
}
if(isset($_GET['cmd']) && $_GET['cmd'] == "a")
{
    $_SESSION['mood']=$_GET['cmd'];	
    if(isset($_SESSION['recordID']))
	{
	    $recordID=$_SESSION['recordID'];
	
        $sql=mysql_query("UPDATE thoughts SET mood='Very Sad' WHERE id = '$recordID';") or die (mysql_error());
    }
	header("location: options.php");
    exit();
			
}
	
if(isset($_GET['cmd']) && $_GET['cmd'] == "b")
{	
	$_SESSION['mood']=$_GET['cmd'];
	if(isset($_SESSION['recordID']))
	{
		$recordID=$_SESSION['recordID'];
	
	    $sql=mysql_query("UPDATE thoughts SET mood='Sad' WHERE id = '$recordID';") or die (mysql_error());
	}
	header("location: options.php");
	exit();
		
}
	
if(isset($_GET['cmd']) && $_GET['cmd'] == "c")
{	
	$_SESSION['mood']=$_GET['cmd'];
	if(isset($_SESSION['recordID']))
    {
        $recordID=$_SESSION['recordID'];
	
        $sql=mysql_query("UPDATE thoughts SET mood='Neutral' WHERE id = '$recordID'") or die (mysql_error());	
	}
	header("location: options.php");
	exit();
}
	
if(isset($_GET['cmd']) && $_GET['cmd'] == "d")
{
	$_SESSION['mood']=$_GET['cmd'];
	if(isset($_SESSION['recordID']))
    {
		$recordID=$_SESSION['recordID'];
	
	    $sql=mysql_query("UPDATE thoughts SET mood='Happy' WHERE id = '$recordID'") or die (mysql_error());
	   
	}
	header("location: options.php");
	exit();
}
	
if(isset($_GET['cmd']) && $_GET['cmd'] == "e")
{
	$_SESSION['mood']=$_GET['cmd'];
	if(isset($_SESSION['recordID']))
	{
		$recordID=$_SESSION['recordID'];
	
	    $sql=mysql_query("UPDATE thoughts SET mood='Very Happy' WHERE id = '$recordID'") or die (mysql_error());
	}
	header("location: options.php");
	exit();
}
	
	
$name = $_SESSION['name'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
             <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		    <title>Graph Page</title>
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
		    <p><br/><br/><br/><br/>How are you feeling today?</p>
			<div align="left"><table cellpadding="20" width="200" cellspacing="10">
			<tr valign="top"><td>
			<a href="graph.php?cmd=a"><div class="imgWrap"><img src="Images/Very_sad_smiley1.jpg" alt="Very Sad" width="100" height="100" border="0"><p class="imgDescription">Very Sad</p></div></a>
			</td><td>
			<a href="graph.php?cmd=b"><div class="imgWrap"><img src="Images/sad_smiley2.png" alt="Sad" width="100" height="100" border="0"><p class="imgDescription">Sad</p></div></a>
			</td><td>
			<a href="graph.php?cmd=c"><div class="imgWrap"><img src="Images/neutral_smiley3.png" alt="Neutral" width="105" height="105" border="0"><p class="imgDescription">Neutral</p></div></a>
			</td><td>
			<a href="graph.php?cmd=d"><div class="imgWrap"><img src="Images/happy.png" alt="Happy" width="108" height="108" border="0"><p class="imgDescription">Happy</p></div></a>
			</td><td>
			<a href="graph.php?cmd=e"><div class="imgWrap"><img src="Images/very_happy_smiley5.png" alt="Very Happy" width="92" height="92" border="0"><p class="imgDescription">Very Happy</p></div></a>
			</td></tr>
			</table></div>
			<div>
			<img src="Images/graph.png" alt="graph"> 
			</div>
		    </body>
			</html>