<?php

/**
 *	Set form key to session
 * 
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
		if ( ! empty( $POST['key'] ) && array_key_exists($POST['key'], $_SESSION['keys']))
		{
			unset($_SESSION['keys'][$POST['key']]);
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	
	
}

?>
