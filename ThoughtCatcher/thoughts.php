<?php
session_start();

include "Scripts/connect_to_mysql.php";
$lastID = $_SESSION['last_id'];
if(isset($_SESSION['posted_stuff']))
{
    if($_SESSION['previous'] == 0)
	{
		echo 'You have viewed all of your thoughts.	Please click <a href="logger.php">here</a> to return to the thoughts page.';
        exit();
	}
	
	$previous=$_SESSION['previous'];
    $sql=mysql_result(mysql_query("SELECT last_log_date FROM thoughts WHERE id='$previous' LIMIT 1"), 0);
    $date = $sql;
    $sql=mysql_result(mysql_query("SELECT thought FROM thoughts WHERE id='$previous' LIMIT 1"), 0);
    $thought = $sql;

} else
{
    $sql=mysql_query("SELECT * FROM thoughts LIMIT 1");
	$num_rows=mysql_num_rows($sql);
	if ($num_rows == 0)
	{
	    echo 'You have not yet logged any thoughts.	Please click <a href="logger.php">here</a> to return to the thoughts page.';
        exit();
	}
	
	if(!isset($_SESSION['previous']))
	{
	    $sql=mysql_result(mysql_query("SELECT id FROM thoughts ORDER BY id DESC LIMIT 1"), 0);
	    $previous = $sql;
	    $sql=mysql_result(mysql_query("SELECT last_log_date FROM thoughts WHERE id='$previous' LIMIT 1"), 0);
	    $date = $sql;
        $sql=mysql_result(mysql_query("SELECT thought FROM thoughts WHERE id='$previous' LIMIT 1"), 0);
        $thought = $sql;
	} else
	{
	    if($_SESSION['previous'] == 0)
		{
		    echo 'You have viewed all of your thoughts.	Please click <a href="logger.php">here</a> to return to the thoughts page.';
            exit();
		}
		
		$previous=$_SESSION['previous'];
        $sql=mysql_result(mysql_query("SELECT last_log_date FROM thoughts WHERE id='$previous' LIMIT 1"), 0);
        $date = $sql;
        $sql=mysql_result(mysql_query("SELECT thought FROM thoughts WHERE id='$previous' LIMIT 1"), 0);
        $thought = $sql;

	}
}
if(isset($_GET['cmd']) && $_GET['cmd'] == "previous" && $_SESSION['previous'] != 0)
{
	$_SESSION['previous'] = $previous - 1;
	header("location: thoughts.php");
	exit();
} 

if(isset($_GET['cmd']) && $_GET['cmd'] == "subsequent" && $_SESSION['previous'] != $_SESSION['last_id'])
{
    
	$_SESSION['previous'] = $previous + 1;
	header("location: thoughts.php");
	exit();
} 

if(isset($_GET['cmd']) && $_GET['cmd'] == "subsequent" && $_SESSION['previous'] == $_SESSION['last_id'])
{
	header("location: logger.php");
	exit();
} 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Thoughts Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	    <head>
	
	    <body>
		<p style="font-size: 40px"><strong> <?php echo $_SESSION['name'];?></strong></p>
		<p>Date: <?php  echo date("l, j M Y"); ?> <br/><br/><br/></p>
		<div style="position:absolute; top:10px;  LEFT:300px;">
		<a href="logger.php"><img src="Images/thought_icon_active.png" alt="Thought Icon" width="120" height="120"></a>
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
		<p><?php echo $date;?></p>
		<div style="float:left">
		<a href="thoughts.php?cmd=previous"><img src="Images/previous.jpg" alt="arrow" height="120px" width="120px"></a>
		</div>
		<div style="float:left;">
		<br/>
		<p style = "width:600px">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<strong><?php echo $thought; ?></strong>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</p>
		</div>
		<div style="float:left">
		<a href="thoughts.php?cmd=subsequent"><img src="Images/newer.jpg" alt="arrow" height="120px" width="120px"></a>
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		</body>
		</html>