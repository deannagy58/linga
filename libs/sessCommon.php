<?php
//  **************************************************************
//
//
// *****************************************************************

//$URLParams = array();


/**********************************************************
function    : getSess
description : Ensure Value isset
***********************************************************/
function getSess($_name)
{
	return (isset ($_SESSION[$_name]) ? $_SESSION[$_name] : NULL);
}

/* *********************************************************
function    : getSess
description : Ensure Value isset
*********************************************************** /
function setSess($_name, $_value)
{
	return $_SESSION[$_name] = $_value;
}
 */






/**********************************************************
function    : frm_setSess
description : Ensure Value isset
***********************************************************/
function frm_setSess($_name, $_value)
{
	$_SESSION[$_name] = $_value;
	return;
	
} // end of frm_setSess()


/**********************************************************
function    : validateSession ()
description : this function determines if the session is still valid, user, idle?.

***********************************************************/
function validateSession() {

	$sessionValid = true;  // assume session is valid by default  

	// if (!(getSess("USERID")) ) {
	if (null == getSess("USERID") ) {  	
		$sessionValid = "NOSESSION";
	}
	else
	{
		// session exists, now other checks...
		// check for idle too long....
		$lastUserEvent = getSess("USEREVENT");
		$nowUserEvent = time();
		if (($nowUserEvent - $lastUserEvent) > 1000 ){
			$sessionValid = "SESSIONTIMEDOUT";
			//remove variables in the session, then destroy it
			session_unset();
			session_destroy();
		}else{
			frm_setSess("USEREVENT", time() );  // current server date time
			$sessionValid = "OKSESSION";
		}
    }
	
	return $sessionValid;
}

/* *********************************************************
function    : createSess
description : Ensure Value isset
*********************************************************** /
function createSess($_uid, $_name)
{
	setSess("USEREVENT", time() );  // current server date time
	setSess("USER", $_name );  // current server date time
	setSess("USERID", $_uid );  // current server date time	
	
} // end of createSess()

*/





/**********************************************************
function    : frm_createSess
description : Ensure Value isset
***********************************************************/
function frm_createSess($_sessionVarList)
{
	frm_setSess("USEREVENT", time() );  // current server date time
	foreach ( $_sessionVarList as $key=>$val ){
		frm_setSess($key, $val );
	}
	///////////setSess("USER", $_name );  // current server date time
	///////////setSess("USERID", $_uid );  // current server date time	
	
} // end of frm_createSess()

/**********************************************************
function    : mergeGetPost
description : It copies all incoming POST and GET variables to an associative array called $attributes.

***********************************************************/
function frm_mergeGetPost()
{
	//global $URLParams;
	//if(!isset($URLParams) || !is_array($URLParams)) {
		//$URLParams = array();
		$URLParams = array_merge($_POST, $_GET); // GET overwrites POST
	//}
	return $URLParams;
	
} // end of mergeGetPost()

/**********************************************************
function    : getAttr
description : Ensure Value isset, Returns the vars value if var  exists and has value other than NULL, FALSE otherwise. 
***********************************************************/
function getAttr($_name, $_value=false)
{
	global $URLParams;	
	//echo " getAttr->" . $URLParams[$_name] . "]";
	return isset ($URLParams[$_name]) ? $URLParams[$_name] : $_value;
  
} // end of getAttr()






?>




  

