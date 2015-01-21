<?php

/**
* oMLClass.php
* class to set the various parts of the output html or wml ,... 

*/
class outPage
{

	/**
	* @var float The start time, in miliseconds.
	* @access protected
	*/
	//protected $_mt_start;

	/**
	* @var int The number of executed queries.
	* @access protected
	*/

	protected $pageDocType = "";  
	
	protected $pageTitle = ""; 
	protected $pageBodyID = ""; 

	protected $cssFiles = "";
		
	protected $jsFiles = "";
	
	protected $endOPage = ""; 

	protected $pageTemplate = ""; 
	protected $pageDataObjs = "";
	
	//------------------------------------------------------------
	// METHODS
	//------------------------------------------------------------

	//--Public methods--//

	function outPage()
	{
		$this->pageDocType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'; 
		$this->pageDocType .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';

		$this->endOPage = "</body></html>";
		$this->pageTemplate = "linga/huh.php";
		$this->pageDataObjs = "";
		
		$this->cssFiles = array();
		
		$this->jsFiles = array();
		$this->jsFiles[0] = "js/myAjax.js";
		$this->jsFiles[1] = "js/common.js";		
		
	} // end of __construct()





//  <<<<<<<<<<<   SETs    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	/** Method to query the database.
	 * @param $query The query.
	 * @param $debug If true, output the query and the resulting table.
	 * @return The result of the query, to use with fetchNextObject().
	 * @access public
	*/
	public function setHeadTitle($title)
	{
		$this->pageTitle = $title;
	
	} //end of setHeadTitle()

	/** Method to execute a query\n
	* Should be used for INSERT, UPDATE, DELETE...
	* @param $query The query.
	* @param $debug If true, it output the query and the resulting table.
	* @access public
	*/
	public function setBodyID($id)
	{
		$this->pageBodyID = $id;
		
	} // end of setBodyID()


	/** Method to execute a query\n
	* Should be used for INSERT, UPDATE, DELETE...
	* @param $query The query.
	* @param $debug If true, it output the query and the resulting table.
	* @access public
	*/
	public function setPageTemplate($fileHTML_WML)
	{
		$this->pageTemplate = $fileHTML_WML;
		
	} // end of setPageTemplate()

	/** Method to execute a query\n
	* Should be used for INSERT, UPDATE, DELETE...
	* @param $query The query.
	* @param $debug If true, it output the query and the resulting table.
	* @access public
	*/
	public function setPageDataObjects($pageObject)
	{
		$this->pageDataObjs = $pageObject;
		
	} // end of setPageDataObjects()

	public function addBodyOnLoad($jsFunc)
	{
		// TODO
		
	} // end of addBodyOnLoad()

	public function addCSSFile($cssFile)
	{
		// TODO
		array_push($this->cssFiles, $cssFile);
		
	} // end of addCSSFile()

	public function addJSFile($jsFile)
	{
		// TODO
		array_push($this->jsFiles, $jsFile);
		
	} // end of addJSFile()

//  <<<<<<<<<<<   GETs    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>	
	public function getHead()
	{
		$outputP = $this->pageDocType;
		$outputP .= $this->getIncludes();
		$outputP .= $this->getBodyTag();				

		return $outputP;
		
	} // end of getHead()	


	public function getEnd()
	{
		return $endOPage;
		
	} // end of getEnd()	


	public function getPageTemplate()
	{
		return $this->pageTemplate;
		
	} // end of getPageTemplate()


	/** Method to execute a query\n
	* Should be used for INSERT, UPDATE, DELETE...
	* @param $query The query.
	* @param $debug If true, it output the query and the resulting table.
	* @access public
	*/
	public function getPageDataObjects()
	{
		return $this->pageDataObjs;
		
	} // end of getPageDataObjects()



	public function getIncludes()
	{
		$op = '<head>';
		$op .= '<title>'. $this->pageTitle . ' 312' . '</title>';
		$op .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

		// add the css files to the head...
		foreach ($this->cssFiles as $css_file) 
		{
			$op .= '<link rel="stylesheet" href="' . $css_file . '" type="text/css"></>';
		}

		// add the js files to the head...
		foreach ($this->jsFiles as $js_file) 
		{
			$op .= '<script src="' . $js_file . '" type="text/javascript"></script>';
		}
		
		$op .= '</head>';
		
		return $op;
				
	} // end of getIncludes()


	public function getBodyTag()
	{
		$outputP = "<body id='" . $this->pageBodyID ."'>";
		///    TODO ONLOAD >>>>>>>>>>>>>            $outputP = "<body onLoad='setInit()'>";   <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		return $outputP;
				
	} // end of getBodyTag()
	
}  //end of class outPage


?>
