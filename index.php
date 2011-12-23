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

if (! empty ( $URL )  )
{
	$action = 'view_details_front';
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
		$limit = 2;
		$count = 0;
		$pagination = 0;
		$results = array();
		$offsset_pagination = 0;
		

		$query = "SELECT count(id) as count FROM Entries ";

		$count_results = $DB->get_results($query);
		
		if ( ! empty ( $count_results ) )
		{
			$count = $count_results[0]['count'];
			$pagination = (int)($count/$limit);
			if ( $count % $limit == 0 )
			{
				$pagination = $pagination - 1;
				
				if ( $pagination < 0 )
				{
					$pagination = 0;
				}
			}
		}
		
		if ( ! empty( $_GET['start_offset'] ) )
		{
			$offsset_pagination = (int)$_GET['start_offset'];
			
			if ( $offsset_pagination < 0 )
			{
				$offsset_pagination = 0;
			}
			
			if ($offsset_pagination > $pagination )
			{
				$offsset_pagination = $pagination;
			}
			$offsset = $offsset_pagination * $limit; 
		}		
		
		$query = "SELECT e.*, GROUP_CONCAT(DISTINCT t.tag ORDER BY t.tag DESC SEPARATOR ' ') as tags
				FROM Entries as e
				INNER JOIN Entries_tags as entag on(e.id = entag.entry_id)
				INNER JOIN Tags as t on(entag.tag_id = t.id)
				GROUP BY e.id 
				ORDER BY e.id 
				LIMIT ". $DB->escape($offsset). " , $limit";

		$results = $DB->get_results($query);
		
		$layout = "view_list_front.php";
		
		break;
		
	case 'view_details_front':
	case 'add_comment':
		
		$URL = $DB->quote( str_replace('-', ' ', ( trim( $URL ) ) ) );
		
		$query = "SELECT e.*, GROUP_CONCAT(DISTINCT t.tag ORDER BY t.tag DESC SEPARATOR ' ') as tags
				FROM Entries as e
				INNER JOIN Entries_tags as entag on(e.id = entag.entry_id AND e.title = ". $URL .")
				INNER JOIN Tags as t on(entag.tag_id = t.id)
				GROUP BY e.id ";

		$results = $DB->get_results($query);

		if ( ! empty ( $results[0] ) )
		{
			$entry = $results[0];
			
			// form validation
			
			$error_name = '';
			$name_input = '';
			
			$error_email = '';
			$email_input = '';
			
			$error_comment = '';
			$text_comment = '';
			
			if ( ! empty ( $_POST['submit'] ) )
			{	// form validation
				$error = array();
				
				$name_input = htmlspecialchars( $_POST['name_input'] );
				
				$email_input = $_POST['email_input'];
				
				if ( !empty ($email_input) && ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email_input) )
				{
					$error[] = true;
					$email_input = htmlspecialchars($email_input);
					$error_email = "{{not_valid_email}}";
				}
				
				$text_comment = htmlspecialchars( $_POST['comment'] );
				
				if ( empty ( $comment ) )
				{
					$error[] = true;
					$error_comment = "{{empty_comment}}";
				}
				
				if ( empty ($error) )
				{	// insert comment to db
					
					if ( ! empty ( $User->id ) )
					{
						$user_id = $User->id;
					}
					else
					{
						$user_id = 'NULL';
					}
					
					$query = "	INSERT INTO comments(user_id, name, email, entry_id, text)
								VALUES (". $user_id .",". $DB->quote($name_input) .", ". $DB->quote($email_input) .", ". $DB->quote($_POST['id']) .", ". $DB->quote($text_comment) .")";
					$DB->query($query);
					
					$text_comment = '';
					
				}
		
			}
			
			
			$query = "SELECT *
					FROM comments
					WHERE entry_id = {$entry['id']}
					ORDER BY updated ASC";

			$comments = $DB->get_results($query);
			
			$key = set_session_key();
			
			$layout = "singl_entry.php";
		}
		else
		{
			$layout = "404.html";		
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
		
$html_output = ob_get_clean();
//echo $html_output;
$M = new Mustache;
echo $M->render($html_output, $Lang);
?>
