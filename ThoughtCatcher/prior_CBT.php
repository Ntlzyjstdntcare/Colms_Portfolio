<?php
session_start();

include "Scripts/connect_to_mysql.php";
$lastID = $_SESSION['last_CBT_id'];
if(isset($_SESSION['posted_CBT']))
{
    if($_SESSION['prior'] == 0)
	{
		echo 'You have viewed all of your reflections.	Please click <a href="CBT.php">here</a> to return to the cognitive behavioural therapy page.';
        exit();
	}
	
	$prior=$_SESSION['prior'];
    $sql=mysql_result(mysql_query("SELECT date_entered FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $date = $sql;
    
	$sql=mysql_result(mysql_query("SELECT before_ FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $before = $sql;
	
	$sql=mysql_result(mysql_query("SELECT feel FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $feel = $sql;
	
	$sql=mysql_result(mysql_query("SELECT self_image FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $self_image = $sql;
	
	$sql=mysql_result(mysql_query("SELECT supporting_evidence FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $supporting_evidence = $sql;
	
	$sql=mysql_result(mysql_query("SELECT contradictory_evidence FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $contradictory_evidence = $sql;
	
	$sql=mysql_result(mysql_query("SELECT another_explanation FROM CBT WHERE id='$prior' LIMIT 1"), 0);
    $another_explanation = $sql;
} else
{
    $sql=mysql_query("SELECT * FROM CBT LIMIT 1");
	$num_rows=mysql_num_rows($sql);
	if ($num_rows == 0)
	{
	    echo 'You have not yet logged any thoughts.	Please click <a href="CBT.php">here</a> to return to the cognitive behavioural therapy page.';
        exit();
	}
	
	if(!isset($_SESSION['prior']))
	{
	    $sql=mysql_result(mysql_query("SELECT id FROM CBT ORDER BY id DESC LIMIT 1"), 0);
	    $prior = $sql;
	    
		$sql=mysql_result(mysql_query("SELECT date_entered FROM CBT WHERE id='$prior' LIMIT 1"), 0);
        $date = $sql;
    
	    $sql=mysql_result(mysql_query("SELECT before_ FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$before = $sql;
	
		$sql=mysql_result(mysql_query("SELECT feel FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$feel = $sql;
	
		$sql=mysql_result(mysql_query("SELECT self_image FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$self_image = $sql;
		
		$sql=mysql_result(mysql_query("SELECT supporting_evidence FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$supporting_evidence = $sql;
		
		$sql=mysql_result(mysql_query("SELECT contradictory_evidence FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$contradictory_evidence = $sql;
		
		$sql=mysql_result(mysql_query("SELECT another_explanation FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$another_explanation = $sql;
		
	} else
	{
	    if($_SESSION['prior'] == 0)
		{
		    echo 'You have viewed all of your thoughts.	Please click <a href="CBT.php">here</a> to return to the cognitive behavioural therapy page.';
            exit();
		}
		
		$prior=$_SESSION['prior'];
        $sql=mysql_result(mysql_query("SELECT date_entered FROM CBT WHERE id='$prior' LIMIT 1"), 0);
        $date = $sql;
        
		$sql=mysql_result(mysql_query("SELECT before_ FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$before = $sql;
	
		$sql=mysql_result(mysql_query("SELECT feel FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$feel = $sql;
	
		$sql=mysql_result(mysql_query("SELECT self_image FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$self_image = $sql;
		
		$sql=mysql_result(mysql_query("SELECT supporting_evidence FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$supporting_evidence = $sql;
		
		$sql=mysql_result(mysql_query("SELECT contradictory_evidence FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$contradictory_evidence = $sql;
		
		$sql=mysql_result(mysql_query("SELECT another_explanation FROM CBT WHERE id='$prior' LIMIT 1"), 0);
		$another_explanation = $sql;
		
	}
}
if(isset($_GET['cmd']) && $_GET['cmd'] == "prior" && $_SESSION['prior'] != 0)
{
	$_SESSION['prior'] = $prior - 1;
	header("location: prior_CBT.php");
	exit();
} 

if(isset($_GET['cmd']) && $_GET['cmd'] == "next" && $_SESSION['prior'] != $_SESSION['last_CBT_id'])
{
    
	$_SESSION['prior'] = $prior + 1;
	header("location: prior_CBT.php");
	exit();
} 

if(isset($_GET['cmd']) && $_GET['cmd'] == "next" && $_SESSION['prior'] == $_SESSION['last_CBT_id'])
{
	header("location: CBT.php");
	exit();
} 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Prior CBT Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	    <head>
	
	    <body>
		<p style="font-size: 40px"><strong> <?php echo $_SESSION['name'];?></strong></p>
		<p>Date: <?php  echo date("l, j M Y"); ?> <br/><br/><br/></p>
		<div style="position:absolute; top:10px;  LEFT:300px;">
		<a href="logger.php"><img src="Images/thought_icon_inactive.png" alt="Thought Icon" width="120" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:450px;">
		<img src="Images/mood_icon_inactive.jpg" alt="Mood Icon" width="120" height="120">
		</div>
		<div style="position:absolute; top:10px;  LEFT:600px;">
		<a href="CBT.php"><img src="Images/diary_active.png" alt="Diary Icon" width="100" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:750px;">
		<a href="exit.php"><img src="Images/exit.jpg" alt="Mood Icon" width="100" height="100"></a>
		</div>
		<p><?php echo $date;?></p>
		<div style="float:left">
		<a href="prior_CBT.php?cmd=prior"><img src="Images/previous.jpg" alt="arrow" height="120px" width="120px"></a>
		</div>
		<div style="float:left;">
		<br/>
		<p style = "width:600px">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What happened before you started feeling down?</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $before; ?></strong></br></br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;How did this make you feel?</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $feel; ?></strong></br></br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What did you think about yourself after this happened?</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $self_image; ?></strong></br></br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What evidence supports this?</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $supporting_evidence; ?></strong></br></br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;What evidence doesn’t support this?</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $contradictory_evidence; ?></strong></br></br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Is there another possible explanation for why this happened?</br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $another_explanation; ?></strong>
		</p>
		</div>
		<div style="float:left">
		<a href="prior_CBT.php?cmd=next"><img src="Images/newer.jpg" alt="arrow" height="120px" width="120px"></a>
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		</body>
		</html>