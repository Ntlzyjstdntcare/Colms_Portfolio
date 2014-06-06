<?php
//Start session. Needed if we are to use session variables
session_start();
//Connect to the database
include"../storescripts/connect_to_mysql.php";
//If the manager session variable is not set in the log in page...
if(!isset($_SESSION["manager"]))
{
    //...send the user back to try and log in again
    header("location: admin_login.php");
	exit();
}

//If the above condition is not met (the session variable is set), check that this user is actually in the database
//Assign the three session variables that we set in the log-in page to local variables
$managerID= $_SESSION["id"];
$manager= $_SESSION["manager"];
$password= $_SESSION["password"];

//Select all records from database table which match our user's details (with max 1 result returned)
$sql=mysql_query("SELECT * FROM users WHERE id='$managerID' AND username='$manager' AND password='$password' AND admin='true' LIMIT 1");
//Count the number of rows returned
$existCount=mysql_num_rows($sql);
//If no rows are returned...
if($existCount==0)
{
    //...give the user the following message and don't execute the rest of the page
    echo "".$manager.$managerID.$password."Your login session data is not on record in the database.";
    exit();
}	
?>

<?php
//If the admin is logged in...
if(isset($SESSION["manager"]))
{
    //...set this variable thusly for later display
    $admin_var = '<?php include_once("template_header.php");?>';
//Otherwise...	
} else
{
    //...set it thusly   
    $admin_var = '<?php include_once("no_login_template_header.php");?>';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Store Admin Area</title>
		<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen"/>			
	<head>
	
	<body>
	    <div align="center" id="mainWrapper">
		<!--Insert header html-->
		<?php include_once("template_header.php");?>
		<div id="pageContent"><br/>
		<!-- this is the variable which we defined above-->
		<?php echo $admin_var; ?>
		<div align="left" style="margin-left:24px;">
		<h2>Hello <?php echo $manager; ?>. What would you like to do today?</h2>
		<!--Link to inventory management page-->
		<p><a href="inventory_list.php">Manage Inventory</a><br/>
		</p>
		</div>
		<br/>
		<br/>
		<br/>
		</div>
		<!--Insert footer html-->
		<?php include_once("admin_footer.php");?>
		</div>
	</body>
</html>