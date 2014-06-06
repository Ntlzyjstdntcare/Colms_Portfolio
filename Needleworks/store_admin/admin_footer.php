<?php

if (isset($_SESSION['manager']))
{
    $admin = "";
} else
{
    $admin = "<a href='http://localhost/E-Commerce/store_admin/admin_login.php'>Admin</a>";
}

?>

<!--This is the footer that appears on all our pages -->
<div id="pageFooter" style="border: 1px solid black">
Copyright: <i>Colm Ginty Amy McCulloch Cliodhna NiBhroin Ciara McDonnell</i><br/>
<?php echo $admin; ?>
</div>