<?php

ob_start();
session_start();

require_once 'core/settings.php';
require_once 'core/db.php';
require_once 'core/localization.php';
require_once 'core/user_model.php';
require_once 'core/functions.php';

$DB = Db::getInstance();
$action = 'view_list_front';



if ( ! empty ( $_REQUEST['action'] ) )
{
	$action = $_REQUEST['action'];
}

if (! empty ( $URL ) )
{
	$action = $_REQUEST['action'];
}

//$User = new User();

if ( ! check_session_keys() )
{	// if session doesn't contain a correct key, show error message 
	$action = 'wrong_key';
}

switch ($action) {
	
	case 'wrong_key':
		$content = '{{error_session_key}}';
		$layout = "key_front.php";
		break;
	

	case 'view_list_front':
		
		$offsset = 0;
		
		if ( ! empty( $_GET['start_offset'] ) )
		{
			$offsset = $_GET['start_offset']; 
		}
		
		$query = "SELECT e.*, GROUP_CONCAT(DISTINCT t.tag ORDER BY t.tag DESC SEPARATOR ' ') as tags
				FROM Entries as e
				INNER JOIN Entries_tags as entag on(e.id = entag.entry_id)
				INNER JOIN Tags as t on(entag.tag_id = t.id)
				GROUP BY e.id 
				ORDER BY e.id 
				LIMIT ". $DB->escape($offsset). " , 20";

		$results = $DB->get_results($query);
		
		$layout = "view_list_front.php";
		
		break;
		
	case 'view_details_front':
		
		$offsset = 0;
		
		if ( ! empty( $_GET['start_offset'] ) )
		{
			$offsset = $_GET['start_offset']; 
		}
		
		$query = "SELECT *
					FROM Entries
					LIMIT ". $DB->escape($offsset). " , 20";
		
		$results = $DB->get_results($query);
		
		$layout = "view_list.php";
		
		break;		
	
	case 'add_comment':


	
}



if ( ! file_exists( 'layouts/'.$layout ) )
{
	require_once '404.html';
}
else
{
	require_once 'layouts/'.$layout;
}
		
$html_output = ob_get_clean();
echo $html_output;
//$M = new Mustache;
//echo $M->render($html_output, $Lang);
?>
