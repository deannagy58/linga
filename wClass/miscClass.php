<?php

/**
* miscClass.php
* a file that has misc classes defined 

*/
class functionResponse
{

	protected $state;  // 4 states: init, fail, success, nop (no operation to do)
	protected $message; 
	protected $returnedObj; 
   

	//------------------------------------------------------------
	// METHODS
	//------------------------------------------------------------

	//--Public methods--//

	function functionResponse()
	{
		$this->state = 'init'; 
		$this->message = '';
		$this->returnedObj = null;
		
	} // end of __construct()


//  <<<<<<<<<<<   SETs    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	/** Method to query the database.
	 * @param $query The query.
	 * @param $debug If true, output the query and the resulting table.
	 * @return The result of the query, to use with fetchNextObject().
	 * @access public
	*/
	public function setState($aState)
	{
		$this->state = $aState;
	
	} //end of setState()

	/** Method to execute a query\n
	* Should be used for INSERT, UPDATE, DELETE...
	* @param $query The query.
	* @param $debug If true, it output the query and the resulting table.
	* @access public
	*/
	public function setMessage($aMsg)
	{
		$this->message = $aMsg;
		
	} // end of setMessage()


	public function setReturnedObj($anObj)
	{
		$this->returnedObj = $anObj;
		
	} // end of setReturnedObj()

	public function setResponse($aState, $aMsg, $anObj)
	{
		$this->state = $aState;
		$this->message = $aMsg;
		$this->returnedObj = $anObj;
		
	} // end of setResponse()


//  <<<<<<<<<<<   GETs    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>	
	public function getState()
	{
		return $this->state;
		
	} // end of getState()	


	public function getMessage()
	{
		return $this->message;
		
	} // end of getMessage()	


	public function getReturnedObj()
	{
		return $this->returnedObj;
		
	} // end of getReturnedObj()

//  <<<<<<<<<<<   MISCs    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

	public function isStateSuccess()
	{
		return ($this->state == "success") ? true : false;
		
	} // end of getState()	

	
}  //end of class functionResponse


?>
