<?php
session_start();
require_once 'core/settings.php';
require_once 'core/db.php';
require_once 'core/localization.php';
require_once 'core/user_model.php';
require_once 'core/functions.php';

$DB = Db::getInstance();
$action = 'view_list';

if ( ! empty ( $_REQUEST['action'] ) )
{
	$action = $_REQUEST['action'];
}

$User = new User();

if ( empty ($User->id) && $action != 'login' )
{
	$layout = "admin_login.php";
	$key =  uniqid();
	$error_text = '';
	$_SESSION['login'] = $key;
	$action = '';
}
else
{
	$layout = "admin.php";
	
}

if ( ! check_session_keys() )
{
	
}


switch ($action) {
	
	case 'wrong_key':
		
		break;
	
	
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
			else
			{
				if ( ! empty ($_POST['stay_login']) && $_POST['stay_login'] == 'save' )
				{
					setcookie("name", $User->name,time()+3600);
					setcookie("password", $User->password,time()+3600);
					$_SESSION['name'] = $User->name;
					$_SESSION['password'] = $User->password;
				}
				else
				{
					setcookie("name", $User->name);
					setcookie("password", $User->password);
					$_SESSION['name'] = $User->name;
					$_SESSION['password'] = $User->password;				
				}
				$location = "Location: /administrator.php";
				header($location); /* Redirect browser */
				exit;				
			}
				
		}

		break;

	case 'logout':
		
		setcookie("name", '');
		setcookie("password", '');
		$_SESSION['name'] = '';
		$_SESSION['password'] = '';	

		$location = "Location: /";
		header($location); /* Redirect browser */
		
		break;
	
	case 'view_list':
		
		$offsset = 0;
		
		if ( ! empty( $_GET['start_offset'] ) )
		{
			$offsset = $_GET['start_offset']; 
		}
		
		$query = "SELECT *
					FROM Entries
					LIMIT ". $DB->escape($offsset). " , 20";
		
		$results = $DB->get_results($query);
		
		$content = ' 
		<table class="bordered-table zebra-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>${{title}}</th>
            <th>${{updated}}</th>
			<th>${{remove}}</th>
			<th>${{edit}}</th>
          </tr>
        </thead>
        <tbody>';
		
		foreach ($results as $value) 
		{
			$content .= "<tr><td>{$value['id']}</td><td>{$value['title']}</td><td>". $value['updated'] ."</td>
					<td><a href=\"/administrator.php?action=remove_entry&id=". $value['id'] ."\">". '${{remove}}'."</a></td>
					<td><a href=\"/administrator.php?action=edit_entry&id=". $value['id'] ."\">". '${{edit}}'."</a></td>
					</tr>";
		}
		
		$content .="</tbody></table>";
		
		$layout = "admin.php";
		
		break;

	case 'add_new_entry':
		
		if ( empty ( $_POST['submit'] ) )
		{
			$key =  uniqid();
			$error_text = '';
			$_SESSION['add_new_entry'] = $key;
			$layout = "admin_add_entry.php";
		}
		else
		{
			$title_input = htmlspecialchars($_POST('title_input'));
		}


		
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
