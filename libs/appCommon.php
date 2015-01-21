<?php
//  **************************************************************
//
//
// *****************************************************************



/**********************************************************
function    : scrubInputString
description : XxxXxxxxxxxxxxxxxXXXXXxxxxXXXxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx. 
***********************************************************/
function scrubInputString($_name)
{
	$cleanedVar = $_name;	

	return $cleanedVar;
  
} // end of scrubInputString()




/**********************************************************
function    : validateUser
description : ????????????????????????????????
*********************************************************** /
function validateUser($dbObj, $clnUsr, $clnPw)
{
		// the following example to get a single row
		// determine if a user/password combo valid
	$actionResponse = new functionResponse();
	
	$sql = "SELECT * FROM siteAccount WHERE myname = :user AND mypasswd = :password";
	$dbObj->bind($sql, array('user' => $clnUsr, 'password' => $clnPw));
	$result = $dbObj->queryUniqueObject($sql);

	if ($result)
	{
		$numRows = $dbObj->numRows($result);
	//	echo "num rows: " . $numRows;
		if ($numRows > 0)
		{
			// found a match...
			$line = $dbObj->fetchNextObject();
			///echo "\nvalidateUser<br />" .$line->siteAccId . " -- " . $line->mynickname;
			$actionResponse->setState("success");
			$actionResponse->setMessage("user: " .$clnUsr. " logged in");
			$actionResponse->role = $line->role;
			$actionResponse->userid = $line->siteAccId;
		}
		else
		{
			// no match 
			//echo "validateUser  user not found, FAILED\n<br />". $dbObj->getLastError();
			$actionResponse->setState("fail");
			$actionResponse->setMessage("user: " .$clnUsr. " not found.");
		}

	}
	else
	{
		///echo "<br />validateUser  query error: ". $dbObj->getLastError();	
		$actionResponse->setState("fail");
		$actionResponse->setMessage("query error: " . $dbObj->getLastError() );	
	}


	return $actionResponse;
	
} // validateUser()
*/


?>




  

