<?php

/**
* Database.class.php
* A PHP class to access MySQL database with convenient methods
* in an object oriented way, and with a powerful debug system.
* Modified from http://slaout.linux62.org/.
* Original author Sébastien Laoût
* @version 1.0
* @author Marc-Andre Caron
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*/
class Database
{

	protected $_default_debug = false;

	/**
	* @var float The start time, in miliseconds.
	* @access protected
	*/
	protected $_mt_start;

	/**
	* @var int The number of executed queries.
	* @access protected
	*/
	protected $_nb_queries;

	/**
	* @var array The last result ressource of a query.
	* @access protected
	*/

	// USER MODIFIABLE DATABASE SETTINGS // 
    
	private $dbHost = 'localhost'; 
	private $dbUser = 'root'; 
	private $dbPwd = 'rfvijn'; 
	private $database = 'siteTemplate'; 
   
	private $_connection; //  = NULL; 
	private $dbConnState;
	protected $errorNo = 0; 
	protected $_last_error = "";
	
	private $_last_result = "";
   

	//------------------------------------------------------------
	// METHODS
	//------------------------------------------------------------

	//--Public methods--//

	public function connect()
	{

		// the @ suppresses errors
		$_connection = @mysql_connect($this->dbHost, $this->dbUser, $this->dbPwd); 
		if(!$_connection) 
		{
			$this->_last_error = "Unable to connect to DBMS: " . mysql_error(); 
			$this->dbConnState = false; 
		}	 
		else
		{			
			$this->dbConnState = true; 
			$this->_connection = $_connection; 
			$db = mysql_select_db($this->database, $this->_connection); 
			if($db == FALSE) 
			{ 
				$this->_last_error = "Unable to select DB: " . mysql_error(); 
				$this->dbConnState = false;
 			} 
		} 

	} // end of __construct()

	/** Method to query the database.
	 * @param $query The query.
	 * @param $debug If true, output the query and the resulting table.
	 * @return The result of the query, to use with fetchNextObject().
	 * @access public
	*/
	public function query($query, $debug = -1)
	{

		$result = mysql_query($query, $this->_connection); 

		if (!$result)
		{
			$this->_last_error = "Invalid query: " . mysql_error() . "\n";	
			$this->_last_result = false;	
		}
		else
		{
			$this->_last_result = $result;
		}

		return $this->_last_result;
	
	} //end of query()

	/** Method to execute a query\n
	* Should be used for INSERT, UPDATE, DELETE...
	* @param $query The query.
	* @param $debug If true, it output the query and the resulting table.
	* @access public
	*/
	public function execute($query)
	{
		if (!$this->_connection)
		{
			$this->_last_error = "Execution failed, no DB connection: " . mysql_error() . "\n";	
			$this->_last_result = FALSE;	
			return FALSE;			
		}
		$result = mysql_query($query, $this->_connection); 
		if ($result)
		{
			// use mysql_affected_rows() to find out how many rows were affected by a DELETE, INSERT, REPLACE, or UPDATE statement.
			return mysql_affected_rows($this->_connection);
		}
		else
		{
			$this->_last_error = "Execution failed: " . mysql_error() . "\n";	
			$this->_last_result = FALSE;	
			return FALSE;		
		}

	} // end of execute()


	/** Method for mysql_fetch_object().
	 * @param $result The ressource returned by query(). If NULL, the last result returned by query() will be used.
	 * @return An object representing a data row.
	 * @access public
	 */
	public function fetchNextObject($result = NULL)
	{
		if ($result == NULL)
		{
			$result = $this->_last_result;
		}
		// Use mysql_num_rows() to find out how many rows were returned for a SELECT statement
		if ($result == NULL || mysql_num_rows($result) < 1)
		{
			return NULL;
		}
		else
		{
			return mysql_fetch_object($result);
		}
	
	} // end of fetchNextObject()


	/** Method to get the id of the very last inserted row.
	* @return The id of the very last inserted row (in any table).
	* @access public
	*/
	public function lastInsertedId()
	{
		return mysql_insert_id($this->_connection);
	}

	/** Method to close the connection with the database server.\n
	* It's usually unneeded since PHP do it automatically at script end.
	* @access public
	*/
	public function close()
	{
		mysql_close($this->_connection);
	}



	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX Get the result of the query as an object. The query should return a unique row.\n
      * Note: no need to add "LIMIT 1" at the end of your query because
      * the method will add that (for optimisation purpose).
      * @param $query The query.
      * @param $debug If true, it output the query and the resulting row.
      * @return An object representing a data row (or NULL if result is empty).
      */
    function queryUniqueObject($query)
    {
      $query = "$query LIMIT 1";

		$result = mysql_query($query, $this->_connection); 
		if (!$result)
		{
			$this->_last_error = "Invalid query: " . mysql_error() . "\n";	
			$this->_last_result = false;	
		}
		else
		{
			$this->_last_result = $result;
		}

		return $this->_last_result;
		
    } // end of queryUniqueObject()





	// Here is a simple named binding function for queries that makes SQL more readable:
	// $sql = "SELECT * FROM users WHERE user = :user AND password = :password";
	// bind($sql, array('user' => $user, 'password' => $password));
	function bind(&$sql, $vals)
	{
		foreach ($vals as $name => $val)
		{
			$sql = str_replace(":$name", "'" . mysql_real_escape_string($val) . "'", $sql);
		}
	}  // end od bind()












	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXethod to get the number of queries executed from the begin of this object.
	* @return The number of queries executed on the database server since the
	* creation of this object.
	* @access public
	*/
	public function getDBState()
	{
		return ($this->dbConnState);
	}


	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXethod to get the number of queries executed from the begin of this object.
	* @return The number of queries executed on the database server since the
	* creation of this object.
	* @access public
	*/
	public function getLastError()
	{
		return ($this->_last_error);
	}

	/** XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXethod to get the number of queries executed from the begin of this object.
	* @return The number of queries executed on the database server since the
	* creation of this object.
	* @access public
	*/
	public function getLastResult()
	{
		return ($this->_last_result);
	}

	//--Protected methods--//



	/** Go back to the first element of the result line.
	* @param $result The resssource returned by a query() function.
	* @access protected
	*/

	protected function resetFetch($result)
	{
		if (mysql_num_rows($result) > 0) mysql_data_seek($result, 0);
	}
	
	
	
	    /** Get the number of rows of a query.
      * @param $result The ressource returned by query(). If NULL, the last result returned by query() will be used.
      * @return The number of rows of the query (0 or more).
      */
    function numRows($result = NULL)
    {
      if ($result == NULL)
        return mysql_num_rows($this->lastResult);
      else
        return mysql_num_rows($result);
    }
	
	
	
	
}  //end of class Database


?>
