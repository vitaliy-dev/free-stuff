<?php
include_once 'core/settings.php';
include_once 'core/db.php';
include_once 'core/localization.php';
include_once 'core/user_model.php';

ob_start();

$DB = Db::getInstance();

$User = new User();

if ( empty ( $URL ) )
{
	// take all posts
	$content = "All posts";
}
else
{
	// db query
	$content = $URL;
}

$layout = "main.php";
if ( ! file_exists( 'layouts/'.$layout ) )
{
	require_once '404.html';
}
else
{
	require_once 'layouts/'.$layout;
}

$html_output = ob_get_clean();

		

?>
