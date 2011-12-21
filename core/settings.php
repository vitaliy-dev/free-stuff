<?php
$settings = array();
$settings['secret_key'] = "23432";

if (! empty ($_SERVER['REDIRECT_URL']))
{
	$URL = substr($_SERVER['REDIRECT_URL'], 1);
}
else
{
	$URL = '';
}


?>
