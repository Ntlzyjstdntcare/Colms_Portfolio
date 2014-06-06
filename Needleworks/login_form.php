<?php
//If the user has enetered details for username and password...
if (isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
	$password = md5($_POST['password']);
	//...first check that they're not empty
	if(!empty($username) || !empty($password))
	{
		//If they are not empty, see if the details belong to a user 
		$query = "SELECT id FROM users WHERE username = '".mysql_real_escape_string($username)."' AND password = '".mysql_real_escape_string($password)."' AND admin='false'";
		if ($sql = mysql_query($query))
		{
		    $num_rows = mysql_num_rows($sql);
			//If not...
			if ($num_rows == 0)
			{
			    //...echo this message
				echo 'Invalid username/password combination.';
			//If the user is in the database, send them to the homepage and create session ids with their details
			} else if ($num_rows == 1)
			{
				$user_id = mysql_result($sql, 0, 'id');
				$_SESSION['user_id'] = $user_id;
				$_SESSION['username'] = $username;
				$query=mysql_query("UPDATE users SET last_log_date=now() WHERE id='$user_id'");
				
				header("Location: index.php");
			}
		}
	//If the user pressed enter without entering details, echo this message
	} else
	{
	    echo 'You must supply a username and password.';
		
	}
}

    
?>
<!--This is the login form that appears at the top of the header-->
<div style="color: #000;">
<form action="<?php echo $current_file; ?>" method="POST">
Username: <input type="text" name="username">
Password: <input type="password" name="password">
<input type="submit" value="Log In">
</form>
</div>

