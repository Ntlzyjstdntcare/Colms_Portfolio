<!--The user is sent to this page when they attempt to  -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Your Cart</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
    <h2 align="center">The amount you have selected exceeds the amount of the item in stock.</h2> <br/> 
	<a href="cart.php" alt="cart" style="font-size: 20px">Please select a lower amount.</a><br/><br/><br/>
  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>