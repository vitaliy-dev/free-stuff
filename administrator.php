<?php
session_start();
include_once 'core/settings.php';
include_once 'core/db.php';
include_once 'core/localization.php';
include_once 'core/user_model.php';

//		$_COOKIE["name"] = "alex";
//		$_COOKIE["password"] = "ece94adbd2b8512504319ea60f8468b2";

$action = '';

if ( ! empty ( $_POST['action'] ) )
{
	$action = $_POST['action'];
}

$User = new User();
//$URL;
if ( empty ($User->id) && $action != 'login' )
{
	$layout = "admin_login.php";
	$key =  uniqid();
	$error_text = '';
	
	$_SESSION['login'] = $key;
}
else
{
	$layout = "admin.php";
}

$action = '';

if ( ! empty ( $_POST['action'] ) )
{
	$action = $_POST['action'];
}

switch ($action) {
	case 'login':
		
		if ($_SESSION['login'] !=  $_POST['key'])
		{
			$layout = "key.php";
		}
		else
		{
			$User = new User();
			if ( empty ($User->id ) )
			{
				$layout = "admin_login.php";
				$key =  uniqid();
				$error_text = 'Not correct user name or password';
				$_SESSION['login'] = $key;
			}
				
		}

		break;

	case 'logout':

		break;
	

	default:
		break;
}













if ( ! file_exists( 'layouts/'.$layout ) )
{
	require_once '404.html';
}
else
{
	require_once 'layouts/'.$layout;
}
		

?>
