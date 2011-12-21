<?php
include_once 'core/settings.php';
include_once 'core/db.php';
include_once 'core/localization.php';
include_once 'core/user_model.php';

		$_COOKIE["name"] = "alex";
		$_COOKIE["password"] = "ece94adbd2b8512504319ea60f8468b2";

$User = new User();
//$URL;
if ( empty ($User->id) )
{
	$layout = "admin_login.php";
	$key =  uniqid();
}
else
{
	$layout = "admin.php";
}


$layout = "admin.php";
if ( ! file_exists( 'layouts/'.$layout ) )
{
	require_once '404.html';
}
else
{
	require_once 'layouts/'.$layout;
}
		

?>
