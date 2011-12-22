<?php

ob_start();
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
	$error_text = '';
	$key = set_session_key();
	$action = '';
}
else
{
	$layout = "admin.php";
}

if ( ! check_session_keys() )
{	// if session doesn't contain a correct key, show error message 
	$action = 'wrong_key';
}


switch ($action) {
	
	case 'wrong_key':
		$content = '{{error_session_key}}';
		$layout = "key.php";
		break;
	
	
	case 'login':
		
			$User = new User();
			if ( empty ($User->id ) )
			{
				$layout = "admin_login.php";
				$error_text = '{{not_correct_login}}';
				$key = set_session_key();
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


		break;

	case 'logout':
		
		setcookie("name", '');
		setcookie("password", '');
		$_SESSION['name'] = '';
		$_SESSION['password'] = '';
		if ( ! empty ( $_SESSION['keys'] ) )
		{
			unset( $_SESSION['keys'] );
		}
		

		$location = "Location: /administrator.php";
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
            <th>{{title}}</th>
            <th>{{updated}}</th>
			<th>{{remove}}</th>
			<th>{{edit}}</th>
          </tr>
        </thead>
        <tbody>';
		
		foreach ($results as $value) 
		{
			$content .= "<tr><td>{$value['id']}</td><td>{$value['title']}</td><td>". $value['updated'] ."</td>
					<td><a href=\"/administrator.php?action=remove_entry&id=". $value['id'] ."\">". '{{remove}}'."</a></td>
					<td><a href=\"/administrator.php?action=edit_entry&id=". $value['id'] ."\">". '{{edit}}'."</a></td>
					</tr>";
		}
		
		$content .="</tbody></table>";
		
		$layout = "admin.php";
		
		break;
	
	case 'edit_entry':
	case 'add_new_entry':

		$error = array();
		$old_id = false;
	
		$title_input = '';
		$error_title = '';
		
		$error_description = '';
		$text_description = '';
			
		$error_tags = '';
		$text_tags = '';
			
		$error_file_input = '';

		if ( ! empty ( $_REQUEST['id'] ) )
		{
			$id = (int)$_REQUEST['id'];
			$query = "SELECT e.*, GROUP_CONCAT(DISTINCT t.tag ORDER BY t.tag DESC SEPARATOR ', ') as tags
						FROM Entries as e
						INNER JOIN Entries_tags as entag on(e.id = entag.entry_id AND e.id = ".$DB->quote($id).")
						INNER JOIN Tags as t on(entag.tag_id = t.id)
						GROUP BY e.id ";
		
			$results = $DB->get_results($query);
			
			if ( ! empty ( $results ) )
			{
				$old_id = $results[0]['id'];
				$title_input = $results[0]['title'];
				$old_image = $results[0]['image'];
				$text_description = $results[0]['description'];
				$text_tags = $results[0]['tags'];
			}
		}
		
		
		if ( empty ( $_POST['submit'] ) )
		{	// display the form 
			$key = set_session_key();
			$layout = "admin_add_entry.php";
		}
		else
		{
			$title_input = $_POST['title_input'];
			
			if ( empty( $title_input ) ||  preg_match("/([^\s-a-z0-9_])/i", $title_input ) )
			{	// validate title, it should not contain nothing else except letters, numbers, space and underlines
				$error[] = true;
				$error_title = '{{error_title}}';
			}
			else 
			{	// check if title is unique in DB. 
					$query = "
					SELECT id
					FROM Entries
					WHERE title ='" .$DB->escape($title_input) ."' 
					LIMIT 1";
		
					$results = $DB->get_results($query);
					
					if ( ! empty ( $results ) && $old_id != $results[0]['id'] )
					{
						$error[] = true;
						$error_title = '{{error_title_not_unique}}';
					}
			}

			$title_input = htmlspecialchars( $title_input );
			
			$text_description = $_POST['description'];
			
			if ( empty( $text_description ) ) 
			{	// check Description field, it cannot be empty.
				$error[] = true;
				$error_description = '{{error_description_empty}}';
				
			}
			else
			{	
				$text_description = strip_tags($text_description);
			}
			

			$text_tags = $_POST['tags_input'];
			$text_tags_original = $_POST['tags_input'];
			
			
			if ( preg_match("/([^\s-a-z,])/i", $text_tags ) )
			{	// validate entered tags; tag field can contain only letters, spaces, dashes and commas
				$error[] = true;
				$error_tags = '{{error_tags}}';
				
			}
			
			$text_tags = htmlspecialchars( $text_tags );

			
			if (  ! empty ( $_FILES['file_input']['error'] )  )
			{	// check if the file is loaded correctly
				$error_file_input = '{{$error_file_upload}}';
				if ( empty ( $old_id ) )
				{
					$error = true;
				}
			}
			else
			{
				if ( ! is_image( $_FILES['file_input']['type'] ) )
				{	// check if the file is an image or not
					$error_file_input = '{{error_file_no_image}}';
					if ( empty ( $old_id ) )
					{
						$error = true;
					}
				}
			}
			
			//$error = true;
			if ( ! empty ( $error ) )
			{
				$layout = "admin_add_entry.php";
				$key = set_session_key();
			}
			else
			{	// insert to db
				
				if (  empty ($old_id) )
				{
					$new_filename = substr(md5(uniqid(rand(), true)), 0, rand(7, 13));
					$filename_old = basename($_FILES['file_input']['name']);
					$result = array ();
					
					if ( preg_match("/\.(.*?)$/",$filename_old,$result) )
					{	// get file extantion
						$new_filename = $new_filename.$result[0];	
					}
					
					if(copy($_FILES['file_input']['tmp_name'],"img/".$new_filename))
					{
						$query = "
							INSERT INTO
							Entries (title, image, description) 
							VALUES('".$DB->escape(htmlspecialchars_decode($title_input)) ."', '".$DB->escape($new_filename)."', '". $DB->escape($text_description) ."' );
						";
		
						$DB->query($query);
						
						$entry_id = $DB->insert_id();
						
						$text_tags_original = trim($text_tags_original);
						
						if (! empty ( $text_tags_original ) )
						{
							$tags = explode(',', $text_tags_original);
							if ( ! empty ($tags) )
							{
								$insert_string = '';
								$select_string = '';
								
								$tags = array_unique($tags);
								
								foreach ($tags as $tag)
								{
									$tag = $DB->escape(trim($tag));
									
									if ($insert_string == '')
									{
										$insert_string .= "('$tag')";
									}
									else
									{
										$insert_string .= ", ('$tag')";
									}
									
									if ( $select_string == '' )
									{
										$select_string .= "('$tag'";
									}
									else
									{
										$select_string .= ", '$tag'";
									}
									
								}
								
								$select_string .= ')';
								
								$query = "
								INSERT IGNORE INTO Tags( tag ) 
								VALUES".$insert_string;
							
								$DB->query($query);
								
								$query = "
								INSERT INTO Entries_tags( entry_id, tag_id )
									SELECT $entry_id, id
									FROM Tags
									WHERE tag in $select_string";

								$DB->query($query);

							}
							
						}
						
						$location = "Location: /administrator.php";
						header($location); /* Redirect browser */
						
					}
					else
					{
						$layout = "admin_add_entry.php";
						$key = set_session_key();
						$error_file_input = '{{error_file_no_copy}}';
					}
				}
				else
				{	// update entry
					if ( empty ( $error_file_input ) )
					{
						
						$new_filename = substr(md5(uniqid(rand(), true)), 0, rand(7, 13));
						$filename_old = basename($_FILES['file_input']['name']);
						$result = array ();

						if ( preg_match("/\.(.*?)$/",$filename_old,$result) )
						{	// get file ext
							$new_filename = $new_filename.$result[0];	
						}

						if( copy($_FILES['file_input']['tmp_name'],"img/".$new_filename))
						{
							@unlink("img/".$old_image);
							$old_image = $new_filename;						
						}
					}
					
					$query = "
							UPDATE Entries 
							SET	title= ".$DB->quote(htmlspecialchars_decode($title_input)) .", 
								image= ".$DB->quote($old_image) .", 
								description = ".$DB->quote($text_description)."
							WHERE id = ". $DB->quote($old_id);
		
						$DB->query($query);
						
						$query = "DELETE FROM Entries_tags
						WHERE entry_id =". $DB->quote($old_id);
						$DB->query($query);		
						
						$text_tags_original = trim($text_tags_original);
						
						if (! empty ( $text_tags_original ) )
						{
							$tags = explode(',', $text_tags_original);
							if ( ! empty ($tags) )
							{
								$insert_string = '';
								$select_string = '';
								
								$tags = array_unique($tags);
								
								foreach ($tags as $tag)
								{
									$tag = $DB->escape(trim($tag));
									
									if ($insert_string == '')
									{
										$insert_string .= "('$tag')";
									}
									else
									{
										$insert_string .= ", ('$tag')";
									}
									
									if ( $select_string == '' )
									{
										$select_string .= "('$tag'";
									}
									else
									{
										$select_string .= ", '$tag'";
									}
									
								}
								
								$select_string .= ')';
								
								$query = "
								INSERT IGNORE INTO Tags( tag ) 
								VALUES".$insert_string;
							
								$DB->query($query);
								
								$query = "
								INSERT INTO Entries_tags( entry_id, tag_id )
									SELECT ". $DB->quote($old_id). " , id
									FROM Tags
									WHERE tag in $select_string";

								$DB->query($query);

							}
							
						}
						
						$location = "Location: /administrator.php";
						header($location); /* Redirect browser */
					
				}
			}					
		}
		break;		
	
	case 'remove_entry':
		if ( ! empty ( $_GET['id'] ) )
		{
			$id = $DB->quote( $_GET['id'] );
			
			$query = "SELECT image FROM Entries
						WHERE id =".$id;
			
			$results = $DB->get_results($query);
			
			if ( ! empty ( $results ) )
			{
				$entry_file = $results[0]['image'];

				@unlink("img/".$entry_file);
				
				$query = "DELETE FROM comments
							WHERE entry_id =".$id;
				$DB->query($query);

				$query = "DELETE FROM Entries_tags
				WHERE entry_id =".$id;
				$DB->query($query);				

				$query = "DELETE FROM Entries
				WHERE id =".$id;
				$DB->query($query);				
			}
		}
		
		$location = "Location: /administrator.php";
		header($location); /* Redirect browser */
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
echo $html_output;
//$M = new Mustache;
//echo $M->render($html_output, $Lang);
?>
