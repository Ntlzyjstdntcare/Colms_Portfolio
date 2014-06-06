<?php

session_start();
$name = $_SESSION['name'];
//session_destroy();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Confirmation Page</title>
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen"/>			
	    <head>
	
	    <body>
		<!--<?php echo 'id is ' . $id . ', I hope it prints.';?>-->
		<p style="font-size: 40px"><strong> <?php echo $name;?></strong></p>
		<p>Date: <?php  echo date("l, j M Y"); ?> <br/><br/><br/></p>
		<div style="position:absolute; top:10px;  LEFT:300px;">
		<a href="logger.php"><img src="Images/thought_icon_inactive.png" alt="Thought Icon" width="120" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:450px;">
		<a href="graph.php"><img src="Images/mood_icon_inactive.jpg" alt="Mood Icon" width="120" height="120"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:1050px;">
		<a href="exit.php"><img src="Images/exit.jpg" alt="Exit Icon" width="100" height="100"></a>
		</div>
		<div style="position:absolute; top:10px;  LEFT:600px;">
		<a href="CBT.php"><img src="Images/Diary.png" alt="Diary Icon" width="100" height="120"></a>
		</div>
		<br/>
		<br/>
		<br/>
		<div>
		<p align="center"><strong>Thank you for sharing your thoughts and feelings. This is a positive step for your mental health.<br/><br/>
		Here is a list of helpful resources that we encourage you to investigate: </p></br>
		<p align="center">
		    <a href"https://turn2me.org/">https://turn2me.org/</a></br>
			<a href"http://www.samaritans.org/">http://www.samaritans.org/</a></br>
			<a href"http://www.aware.ie/">http://www.aware.ie/</a></br>
			<a href"http://www.pieta.ie/">http://www.pieta.ie/</a></br>
		</p></br>
        <p align="center">You may return to the thoughts page if you would like to view your previously logged thoughts, by clicking on the thoughtbubble above.<br/><br/>
		Otherwise you may exit ThoughtCatcher by clicking on the exit button in the top-right of the page.</p></strong>
		</div>	
		</body>
		</html>