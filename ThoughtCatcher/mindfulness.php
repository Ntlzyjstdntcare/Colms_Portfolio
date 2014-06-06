<?php
session_start();

$name = $_SESSION['name'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>CBT Page</title>
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
		<p><strong>Take three deep, cleansing breaths, allowing your muscles to relax further with each breath out.</strong></p>
		</br>
		<div>
		<form action="confirmation.php" method="POST">
		<p><strong>Spend a few minutes paying attention to any physical sensations you feel. 
		Where do you feel pain?  Where do you feel cold? </br>Where do you feel warm?  Type in some physical sensations you feel.</strong></p>
		<textarea name="physical" rows="4" cols="100" maxlength="800"></textarea>
	    <br/>
		<p><strong>Spend a few minutes listening to your thoughts.  Invite your thoughts in,
		positive or negative, like welcome guests.  </br>Type in some thoughts that occur to you.</strong></p>
		<textarea name="some_thoughts" rows="4" cols="100" maxlength="800"></textarea>
		<br/>
		<p><strong>Spend a few minutes paying attention to your emotions.  
		Whether or not there is a reason for your emotions, they deserve your attention.  </br>Listen to them and ask what they can teach you.  
		Type in some of your emotions.</strong></p>
		<textarea name="emotions" rows="4" cols="100" maxlength="800"></textarea>
		<br/>
		<br/>
	    <input type="submit" value="Enter" style="font-size:20px;"/>
		<br/>
		<br/>
	    </form>
		</div>
		</body>
		</html>