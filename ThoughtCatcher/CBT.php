<?php
session_start();

include "Scripts/connect_to_mysql.php";

$name = $_SESSION['name'];

if (isset($_SESSION['name']) && isset($_POST['before']))
{	
	$before=mysql_real_escape_string($_POST['before']);	
	$feel=mysql_real_escape_string($_POST['feel']);	
	$self_image=mysql_real_escape_string($_POST['self_image']);	
	$supporting_evidence=mysql_real_escape_string($_POST['supporting_evidence']);	
	$contradictory_evidence=mysql_real_escape_string($_POST['contradictory_evidence']);	
	$another_explanation=mysql_real_escape_string($_POST['another_explanation']);	
	
	
	$sql=mysql_query("INSERT INTO CBT(before_, feel, self_image, supporting_evidence, 
	                                  contradictory_evidence, another_explanation, date_entered)
	       VALUES('$before', '$feel', '$self_image', '$supporting_evidence', '$contradictory_evidence', 
		           '$another_explanation',now())") or die (mysql_error());
		   
    $sql=mysql_result(mysql_query("SELECT id FROM CBT WHERE before='$before' LIMIT 1"), 0);
	$_SESSION['CBT'] = true;	   
	$_SESSION['CBT_recordID'] = $sql;	   
		
	$_SESSION['posted_CBT'] = true;

	header("location: confirmation.php ");
	exit();
}

if(isset($_GET['cmd']) && $_GET['cmd'] == "prior")
{
    $sql=mysql_result(mysql_query("SELECT id FROM CBT ORDER BY id DESC LIMIT 1"), 0);
	$_SESSION['last_CBT_id'] = $sql;
	$_SESSION['prior'] = $sql;
	
	header("location: prior_CBT.php");
	exit();
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>CBT Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	    <head>
	
	    <body>
		<!--<?php echo 'user id is ' . $userID . ', I hope it prints.';?>-->
		<!--<?php echo 'id is ' . $id . ', I hope it prints.';?>-->
		<p style="font-size: 40px"><strong> <?php echo $_SESSION['name'];?></strong></p>
		<p>Date: <?php  echo date("l, j M Y"); ?> <br/><br/><br/></p>
		<div style="position:absolute; top:10px;  LEFT:300px;">
		<a href="logger.php"><img src="Images/thought_icon_inactive.png" alt="Thought Icon" width="120" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:450px;">
		<a href="graph.php"><img src="Images/mood_icon_inactive.jpg" alt="Mood Icon" width="120" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:600px;">
		<a href="CBT.php"><img src="Images/diary_active.png" alt="Diary Icon" width="100" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:750px;">
		<a href="exit.php"><img src="Images/exit.jpg" alt="Mood Icon" width="100" height="100"></a>
		</div>
		<div>
		<form action="CBT.php" method="POST">
		<textarea name="before" rows="4" cols="100" maxlength="800">What happened before you started feeling down?</textarea>
	    <br/>
		<textarea name="feel" rows="4" cols="100" maxlength="800">How did this make you feel?</textarea>
		<br/>
		<textarea name="self_image" rows="4" cols="100" maxlength="800">What did you think about yourself after this happened?</textarea>
		<br/>
		<textarea name="supporting_evidence" rows="4" cols="100" maxlength="800">What evidence supports this?</textarea>
		<br/>
		<textarea name="contradictory_evidence" rows="4" cols="100" maxlength="800">What evidence doesn’t support this?</textarea>
		<br/>
		<textarea name="another_explanation" rows="4" cols="100" maxlength="800">Is there another possible explanation for why this happened?</textarea>
		<br/>
	    <input type="submit" value="Enter" style="font-size:20px;"/>
		<br/>
		<br/>
	    </form>
		</div>
		<div style="float:left">
		<!--<form action=thoughts.php" method="get">-->
		<a href="CBT.php?cmd=prior"><img src="Images/previous.jpg" alt="prior CBT" height="120px" width="120px"></a>
		<!--</form>-->
		</div>
		</body>
		</html>