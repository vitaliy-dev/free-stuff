<?php

require_once 'Mustache.php';
require_once 'locales/main.php';

$default_locale = "EN";

if ( ! empty ( $_COOKIE['locale'] ) )
{
	$user_locale = $_COOKIE['locale'];
}
else
{
	$user_locale = $default_locale;
}


$lang_class = "Locale_".$user_locale;
$lang_class_default = "Locale_".$default_locale;
if (class_exists($lang_class) )
{
	$Lang = new $lang_class;
}
else
{
	$Lang = new $lang_class_default;
}



?>
