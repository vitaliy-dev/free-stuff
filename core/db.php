<?php
require 'config_db.php';

$link = mysql_connect($db_config['host'], $db_config['user'], $db_config['password']);
if (! $link ) 
{
    die('Could not connect: ' . mysql_error());
}

if  ( ! mysql_select_db($db_config['database'], $link) )
{
	die('Could not connect: ' . mysql_error());
}

class Db
{
	
	private $link;
	private $rows_affected;
	private $result;
	private $insert_id;
	static	$obj;

	static function getInstance($link = null)
	{
		if ( empty ( self::$obj ) )
		{
			self::$obj = new Db($link);
		}
		else
		{
			return self::$obj;
		}
	}
	
	private function __construct($link = null) 
	{
		if (  is_resource ( $link ) )
		{
			$this->link = $link;
		}
		else
		{
			throw new Exception("No database connect");
		}
	}
	
	
	
	public function __destruct() {
		
		mysql_close($this->link);
		
	}
	
	public function quote($str)
	{
		if( is_null( $str ) )
		{
			return 'NULL';
		}
		elseif( is_array( $str ) )
		{
			$r = '';
			foreach( $str as $elt )
			{
				$r .= $this->quote($elt).',';
			}
			return substr( $r, 0, -1 );
		}
		else
		{
			return "'".$this->escape($str)."'";
		}
	}
	
	public function escape($str)
	{
		return mysql_real_escape_string($str, $this->link);
	}	



	public function query( $query )
	{

		$this->result = @mysql_query( $query, $this->link );

		if( mysql_error($this->link) )
		{
			if( is_resource($this->result) )
			{
				mysql_free_result($this->result);
			}
			
			throw new Exception(mysql_error());
		}

		$query =  strtoupper($query);
		
		if ( strpos( $query, 'INSERT') || strpos( $query, 'DELETE' ) || strpos( $query, 'UPDATE') || strpos( $query, 'REPLACE') )
		{
			$this->insert_id = mysql_insert_id($this->link);
			$this->rows_affected = mysql_affected_rows($this->link);
		}
		else
		{
			$this->num_rows = mysql_num_rows($this->result);
		}
		
	}
	

	public function get_results( $query = NULL)
	{

		if( $query )
		{
			$this->query($query);
		}

		$result = array();

		if( $this->num_rows )
		{
			// so we can get results anytime if need 
			mysql_data_seek($this->result, 0);
			while( $row = mysql_fetch_array($this->result, MYSQL_ASSOC) )
				{
					$result[] = $row;
				}
			
		}
		return $result;
	}	
	
}

$DB = Db::getInstance($link);


?>
