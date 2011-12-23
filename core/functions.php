<?php

/**
 *	Set form key to session
 *	@return string Key
 */
function set_session_key()
{
	$key =  uniqid();
	if ( empty( $_SESSION['keys'] ) )
	{
		$_SESSION['keys'] = array( $key => $key);
	}
	else
	{
		$_SESSION['keys'][$key] = $key;
	}
	return $key;
}

/**
 * The function checks correspondence between of at least one key in the session and  
 * key received from the post array. As all data come to the system via POST
 * @return bool  
 */
function check_session_keys()
{
	if ( empty( $_POST ) )
	{
		return true;
	}
	
	if ( empty( $_SESSION['keys'] ) )
	{
		return false;
	}
	else
	{

		if ( ! empty( $_POST['key'] ) && array_key_exists($_POST['key'], $_SESSION['keys']) )
		{
			unset($_SESSION['keys'][$_POST['key']]);
			return true;
		}
		else
		{
			return false;
		}
		
	}
}
	
function is_image( $file_type )
{
	$img_mimes = array('image/x-png', 
							'image/jpg', 
							'image/jpe', 
							'image/jpeg', 
							'image/pjpeg',
							'image/gif',
							'image/jpeg',
							'image/png',
		);
	
	return (in_array($file_type, $img_mimes, TRUE)) ? TRUE : FALSE;
	}
	

	function prep_url($str = '')
	{
		if ($str == 'http://' OR $str == '')
		{
			return '';
		}

		if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
		{
			$str = 'http://'.$str;
		}

		return $str;
	}	


?>
