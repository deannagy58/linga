<?php
//  **************************************************************
//
//
// *****************************************************************




/**********************************************************
function    : pageAccess
description : xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

***********************************************************/
function frm_pageAccess($urlParams)
{
	switch ( validateSession() ){
		case "NOSESSION":
			if (isset($urlParams['formname']) )
			{
				if ( (getAttr('formname')) && (getAttr('formname') == "initial") )
				{
					$page_state = "LOGGINGIN";
				}
				else
				{
					$page_state = "LOGIN";
				}
			}
			else
			{
					$page_state = "LOGIN";			
			}
			break;


		case "SESSIONTIMEDOUT":
			$page_state = "LOGOUT";
			break;

		case "OKSESSION":
			$page_state = "OKSESSION";
			break;

		default:
			//
			//  NEED SOME KIND OF AN ERROR PAGE ?????
			//
			$page_state = "LOGGINGIN";
	}	

	return $page_state;

} // end of pageAccess()


/**********************************************************
function    : validateUser
description : ????????????????????????????????
***********************************************************/
function frm_validateUser($dbObj, $clnUsr, $clnPw)
{
	global $frm_sqlQuery;
	$actionResponse = new functionResponse();

	$sql = $frm_sqlQuery['VALIDATEUSER']['querystring'];
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
			$actionResponse->setState("success");
			$actionResponse->setMessage("user: " .$clnUsr. " logged in");
			
			$moreInfo = array(
								'name'=> $line->myname,
								'role'=> $line->role,
								'userid'=> $line->siteAccId
							  );
			$actionResponse->setReturnedObj( $moreInfo );
		}
		else
		{
			// no match 
			///////echo "validateUser  user not found, FAILED\n<br />". $dbObj->getLastError();
			$actionResponse->setState("fail");
			$actionResponse->setMessage("user: " .$clnUsr. " not found.");
		}

	}
	else
	{
		/////////echo "<br />validateUser  query error: ". $dbObj->getLastError();	
		$actionResponse->setState("fail");
		$actionResponse->setMessage("query error: " . $dbObj->getLastError() );	
	}


	return $actionResponse;
	
} // end of frm_validateUser()




/**********************************************************
function    : frm_pageRequestState
description : xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

***********************************************************/
function frm_pageRequestState($pageReqState)
{
	
	switch ($pageReqState)
	{
		case "LOGGINGIN":
				require_once "linga/brian.php";
			//	require_once "linga/lingaQuery.php";
				
				$cleanUsrName = scrubInputString(getAttr('uname'));
				$cleanPassword = scrubInputString(getAttr('pw'));
	/////	echo " prs QRY: [" . $frm_sqlQuery['VALIDATEUSER']['querystring'] . "]";
				$db = new Database();
				$db->connect();
				$responseObj = frm_validateUser($db, $cleanUsrName, $cleanPassword);
				$db->close(); 
		/////		print_r($responseObj);
				
				if ($responseObj->isStateSuccess() )
				{
					$retObj = $responseObj->getReturnedObj();
					$sessVars = array(
									'USER'=> $retObj['name'],
									'USERID'=> $retObj['userid'],
									'TRANSLATE'=> "lang_en",
									'USRROLE'=> $retObj['role']
								);

								
					frm_createSess($sessVars);

					$rObj = brianHome();
	
				}
				else
				{
					session_destroy();
					// *****    get the failure reason
					$outputCode =  "linga/login.php";	
				}
				
				break;


		case "LOGIN":
				require_once "linga/brian.php";
				$rObj = buildLingaPage();
				$rObj->setPageTemplate("linga/login.php");
				break;

		case "OKSESSION":
					require_once "linga/brian.php";
					require_once "linga/lingaQuery.php";
					$subcommand = scrubInputString(getAttr('subCmd'));
					echo "frMain: OKSESSION: [" . $subcommand . "]<br />";
					$db = new Database();
					$db->connect();				
					switch ($subcommand){
						case "select_translate2":
							$new_lang = getAttr('langSelector');
							frm_setSess("TRANSLATE", $new_lang );  // set new language to translate
							$rObj = brianHome();
	
							break;

						case "addnew":
							echo "frMain sub: OKSESSION: [" . $subcommand . "]<br />";
							$rObj = buildLingaPage();
							$rObj->setPageTemplate("linga/lingaAddWA.php");
							
							break;



						case "edit":
							$rObj = buildLingaPage();
							$rObj->setPageTemplate("linga/lingaAddEditWA.php");
							$rec = getAttr('param1');
							$rObj->setPageDataObjects( getALanguagerecord($db, 1, getSess("TRANSLATE"), $rec) );
							
							break;

						case "delete":
							//$rObj = buildLingaPage();
							//$rObj->setPageTemplate("linga/lingaAddEditWA.php");
							$rec = getAttr('param1');
							echo "rec 2 delete: " . $rec . "  ";
						//	$rObj->setPageDataObjects( getALanguagerecord($db, 1, getSess("TRANSLATE"), $rec) );
							$rObj = brianHome();
							break;

						case "save":
							$newCleanText = scrubInputString(getAttr('latedText'));
							echo " 2 this: " . $newCleanText;

							$recordUpdate = updateText($db, 1, getSess("TRANSLATE"), getAttr('param1'), $newCleanText);
						
							$rObj = brianHome();
							
							break;

						case "saveadd":
							$newCleanLabel = scrubInputString(getAttr('txtlabel'));
							$newCleanDesc = scrubInputString(getAttr('descr'));
							$newCleanTheText = scrubInputString(getAttr('latedText'));

							$recordUpdate = addText($db, 1, getSess("TRANSLATE"), $newCleanLabel, $newCleanDesc, $newCleanTheText);
							
							$rObj = brianHome();
							
							
							break;



						case "logout":
							session_destroy();
						////	$outputCode =  "linga/login.php";
							$rObj = buildLingaPage();
							$rObj->setPageTemplate("linga/login.php");
							
							break;



						case "list":
							$rObj = brianHome();
							break;
						
					default:
					
				}	
					
	//phpinfo(INFO_VARIABLES);

	//exit();								
					$db->close();

			// should check whether page exists!!!!!
					

			break;

		case "SESSIONTIMEDOUT":
			// remove   $rObj = new functionResponse();
			// remove    $rObj->setState("init");
			$extension = "-B";
			$outputCode =  "testPhaseOut/siteHTML" . $extension . ".php";
			break;

		default:
		//
		//  NEED SOME KIND OF AN ERROR PAGE ?????
		//

		
			$outputCode =  "testPhaseOut/siteHTML-B.php";
	}	
	
	return $rObj;
	
} // end of frm_pageRequestState()

?>




  

