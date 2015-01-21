<?php
//  **************************************************************
//
//
// *****************************************************************

//	require "linga/lingaQuery.php";


/**********************************************************
function    : brianMain
description : Ensure Value isset
***********************************************************/
function brianHome()
{
	global $linga_sqlQuery;
	
//	echo "list XXXX qry [" . $linga_sqlQuery['LISTLANGUAGETEXT']['querystring'] ."]";

	
	$lingaPage = buildLingaPage();
	$oData = array();
	
	$dbConn = new Database();
	$dbConn->connect();
	if ($dbConn->getDBState())
	{
		$oData['uid'] = buildUserIdentifier(getSess("USER"), getSess("USRROLE"));
		$oData['nav'] = createLingaNavBar(getSess("USRROLE"));
		$oData['lang2Tr'] = buildLanguage2Translate(getSess("TRANSLATE"));
		$selectText = getlanguageSpecificText($dbConn, 1, getSess("TRANSLATE"));
		$oData['txtRecs'] = buildTextTable($selectText, (getSess("USRROLE") == "developer")? true : false );
 
		$dbConn->close();
		
		
		$lingaPage->setPageDataObjects($oData);
	}
	else
	{
		echo "<br />hey dean dbase error: " , $dbConn->getLastError();
	}

	return $lingaPage;

} // end of brianHome()



/**********************************************************
function    : brianMain
description : Ensure Value isset
***********************************************************/
function buildLingaPage()
{

	$thePage = new outPage();
	$thePage->setHeadTitle("july 29 928");
	$thePage->setBodyID("55");
	$thePage->addCSSFile("linga/lingaWorkArea.css");
	$thePage->addJSFile("linga/lingaWorkArea.js");
	$thePage->setPageTemplate("linga/lingaWorkArea.php"); 		

	return $thePage;

} // end of buildLingaPage()



/**********************************************************
function    : brianMsgHandler
description : Ensure Value isset
***********************************************************/
function brianMsgHandler()
{
	$aResponse = new functionResponse();
	$aResponse->setState("nop");
	
	// Open the base (construct the object):
	$myPage = new outPage();
	$myPage->setHeadTitle("july 29 928");
	$myPage->setBodyID("55");
	$myPage->addCSSFile("linga/lingaWorkArea.css");
	$myPage->addJSFile("linga/lingaWorkArea.js");
		
	$dbConn = new Database();
	$dbConn->connect();
	if ($dbConn->getDBState())
	{
					/*  move to brianMain.... */
					$uid = buildUserIdentifier(getSess("USER"), getSess("USRROLE"));
					$nav = createLingaNavBar(getSess("USRROLE"));
					$lang2Tr = buildLanguage2Translate(getSess("TRANSLATE"));
					$selectText = getlanguageSpecificText($dbConn, 1, getSess("TRANSLATE"));
					$txtRecs = buildTextTable($selectText, (getSess("USRROLE") == "developer")? true : false );
					$outputCode = "linga/lingaWorkArea.php";   
					/* end of moved    */		
		
		
		

	$dbConn->close();
	echo $myPage->getHead();


	require $outputCode;

	echo $myPage->getEnd();
	}
	else
	{
		echo "<br />hey dean dbase error: " , $dbConn->getLastError();
	}

	return $aResponse;

} // end of brianMsgHandler()







/**********************************************************
function    : createLingaNavBar
description : Ensure Value isset
***********************************************************/
function createLingaNavBar($_role)
{

	
	$navBar = '<b>';
	if ($_role != "guest")
	{
		if ( $_role == "developer")
		{
			$navBar .= '<A HREF="javascript:submitCmdForm(\'addnew\', 0)">'.  'add' .'</a>' . ' | ' ;
			// $navBar .= '<a href="siteApp?state=main">' .  'add' .'</a>' . ' | ' ;
			//$navBar .= '<a href="siteApp?state=naggzilla">' .  'edit' .'</a>' . ' | ' ;
			//$navBar .= '<a href="siteApp?state=test_msg&cmd=lst">' .  'delete' .'</a>' . ' | ' ;
		}
	
		$navBar .= '<a href="siteApp?state=profile">' .  'publish' .'</a>' .'</a></b>';
	}

	return $navBar;

}  // end of createLingaNavBar()


/**********************************************************
function    : createLingaNavBar
description : Ensure Value isset
***********************************************************/
function buildUserIdentifier($_usrname, $_role)
{
	return $_usrname . " (". $_role . ")";
	
}  // end of buildUserIdentifier()

/**********************************************************
function    : getlanguageSpecificText
description : cvbncgncvb ghj fgj fgjfgjfgj fgjfgj 
***********************************************************/
function getlanguageSpecificText($dbConn, $project, $language)
{
	global $linga_sqlQuery;
	$actionResponse = new functionResponse();
	
	if ($dbConn->getDBState())
	{
		$text_records = array();
		$rec_count = 0;
		// Commonly, you can copy/paste this code for one query at a time:
		//
		//   * * * * ** * * * * ** * * * * * *     CHANGE TO USE BIND FUNC * ** ** * * ** * * * * * * 
		//
//		$sql = "SELECT text_id, text_text FROM linguini where text_project = :project and text_language = :language ";
		$sql = $linga_sqlQuery['getTexts']['querystring'];
		$dbConn->bind($sql, array('project' => $project, 'language' => $language));
// echo "list qry [" . $linga_sqlQuery['LISTLANGUAGETEXT']['querystring'] ."]";
	///	$result = $dbConn->query("SELECT text_id, text_text FROM linguini where text_project = :project and text_language = :language ");
		$result = $dbConn->query($sql);

		if ($result)
		{
			while ($row = $dbConn->fetchNextObject()) {
				
			//	echo "result: " . $rec_count . " == " .$row->text_id;
				$text_records[$rec_count] = array('recId'=> $row->text_id,
													'text'=> $row->text_text
													);
				$rec_count++;									
			}
		//	print_r($text_records);
		//	echo "WTF";
		}
		else
		{
			echo "NO DATA";
			return "no data"; ////////////echo "<br />query  error: " , $db->getLastError();	
		}
	}
	else
	{
		return "<br />query  error: " . $db->getLastError();
	}
	

	return $text_records;
	
}  // end of getlanguageSpecificText()



/**********************************************************
function    : getlanguageSpecificText
description : cvbncgncvb ghj fgj fgjfgjfgj fgjfgj 
***********************************************************/
function getALanguagerecord($dbConn, $project, $language, $recId)
{
	global $linga_sqlQuery;
	
	$actionResponse = new functionResponse();
	if ($dbConn->getDBState())
	{	
	
		$sql = $linga_sqlQuery['getAText']['querystring'];
		$dbConn->bind($sql, array('project' => $project, 'language' => $language, 'rec_id' => $recId));
		$result = $dbConn->queryUniqueObject($sql);

		if ($result)
		{
			$numRows = $dbConn->numRows($result);
			if ($numRows == 1)
			{
				// found a match...
				$line = $dbConn->fetchNextObject();
				//echo "\ngetALanguagerecord<br />" .print_r($line);
				$actionResponse->setState("hooray");
				$actionResponse->text_record = array('recDescr'=> $line->text_description,
													'recText'=> $line->text_text,
													'recId'=> $recId
													);
			//	echo "\ngetALanguagerecord<br />" .print_r($actionResponse);
			}
			else
			{
				// no or more than 1 match 
				//echo "validateUser  user not found, FAILED\n<br />". $dbObj->getLastError();
				$actionResponse->setState("fail");
				$actionResponse->setMessage("user: " .$clnUsr. " not found.");
			}

		}
		else
		{
			///echo "<br />validateUser  query error: ". $dbObj->getLastError();	
			$actionResponse->setState("fail");
			$actionResponse->setMessage("query error: " . $dbConn->getLastError() );	
		}
	}
	else
	{
		// db state error
	}

	return $actionResponse;

}  // end of getALanguagerecord()



////////////////////////////
/**********************************************************
function    : getlanguageSpecificText
description : cvbncgncvb ghj fgj fgjfgjfgj fgjfgj 
***********************************************************/
function addText($dbConn, $project, $language, $newlabel, $newDesc, $newtext)
{
	global $supported_languages;
	global $linga_sqlQuery;
	
	
	$actionResponse = new functionResponse();
	
	mysql_query("SET AUTOCOMMIT=0");
	mysql_query("START TRANSACTION");

	if ($dbConn->getDBState())
	{	

		$sql_A = $linga_sqlQuery['addText-A']['querystring'];
		$sql_B = $linga_sqlQuery['addText-B']['querystring'];		
		$dbConn->bind($sql_A, array( 'project' => $project, 'language' => $language, 'label' => $newlabel, 'desc' => $newDesc, 'text' => $newtext));

		$result = $dbConn->execute($sql_A);

		if ($result)
		{
				$actionResponse->setState("success");
				$parentId = mysql_insert_id();

				$sql = $linga_sqlQuery['addText-C']['querystring'];
				$dbConn->bind($sql, array( 'p_id' => $parentId));

				$result = $dbConn->execute($sql);				
				if ($result)
				{
					$sqlII = "";
					$doneOne = false;
					$actionResponse->setState("success");
					foreach( $supported_languages as $key => $value)
					{
						if ($key != "lang_en")
						{
							if ($doneOne)
							{
								$sqlII .= ", ";
							}
							$foreignText = $key . " - TO DO - " . $newtext;
							$sqlII .= " ($parentId, $project, '$key', '$newDesc', '$newlabel', '$foreignText')";
							$doneOne = true;
						}
					}
					
				
					$sql = $sql_B . $sqlII;
					$result = $dbConn->execute($sql);

					if ($result)
					{
						$actionResponse->setState("success");
					}
					else
					{
						$actionResponse->setState("fail");
						$actionResponse->setMessage("update failed: ");					
						
					}				
				}
				else
				{
					$actionResponse->setState("fail");
					$actionResponse->setMessage("update failed: ");					
				}

		}
		else
		{
				$actionResponse->setState("fail");
				$actionResponse->setMessage("update failed: ");
		}

	}
	else
	{
		// db state error
	}

	if ("success" == $actionResponse->getState() )
	{
		mysql_query("COMMIT"); 	
	}
	else
	{
		mysql_query("ROLLBACK");	
	}
	
	return $actionResponse;

}  // end of addText()


////////////////////////////
/**********************************************************
function    : getlanguageSpecificText
description : cvbncgncvb ghj fgj fgjfgjfgj fgjfgj 
***********************************************************/
function updateText($dbConn, $project, $language, $recId, $newText)
{
	global $linga_sqlQuery;
	
	$actionResponse = new functionResponse();
	if ($dbConn->getDBState())
	{	
		$sql = $linga_sqlQuery['updateText']['querystring'];
		$dbConn->bind($sql, array('newTranslation'=>$newText, 'project' => $project, 'language' => $language, 'rec_id' => $recId));

		$result = $dbConn->execute($sql);

		if ($result)
		{
				$actionResponse->setState("success");
		}
		else
		{
				$actionResponse->setState("fail");
				$actionResponse->setMessage("update failed: ");
		}

	}
	else
	{
		// db state error
	}

	return $actionResponse;

}  // end of updateText()


//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
/**********************************************************
function    : deleterecord
description : TODO??????
***********************************************************/
function deleterecord($dbConn, $project, $recId)
{
	$actionResponse = new functionResponse();
	if ($dbConn->getDBState())
	{	
	//	echo " get a rec :[".$project."} [". $language."} [". $recId."] [". $newText;
		
		$sql = "DELETE FROM linguini where text_id = :rec_id ";
		$dbConn->bind($sql, array('newTranslation'=>$newText, 'project' => $project, 'language' => $language, 'rec_id' => $recId));
	///	echo " qry: [" . $sql ."]";
		$result = $dbConn->execute($sql);

		if ($result)
		{
				$actionResponse->setState("success");
		}
		else
		{
				$actionResponse->setState("fail");
				$actionResponse->setMessage("update failed: ");
		}

	}
	else
	{
		// db state error
	}

	return $actionResponse;

}  // end of deleterecord()






/**********************************************************
function    : buildTextTable
description : ghlsdlkghlsdjghlsdjhlgkjhsldkjhgljksdhglkjhsdlkghlsdkjhgljk h
* 
* good article:    http://www.htmlcodetutorial.com/tables/index_famsupp_147.html  
***********************************************************/
function buildTextTable($textList, $includeDelete=false)
{
	$txtTbl = '<table width="600px"  BORDER=0 CELLPADDING=3 CELLSPACING=1  RULES=ROWS FRAME=HSIDES>';
	if ($includeDelete)
	{
		$txtTbl .= '<COL WIDTH="50px"><COL WIDTH="50px"><COL WIDTH="495px">';
		$txtTbl .= '<tr BGCOLOR="#D3D3D3">';
		$txtTbl .=  '<th align="left"></th>';
		$txtTbl .= '<th align="right"></th>';
		$txtTbl .= '<th align="left">text</th>';
		$txtTbl .= '</tr>';
	}
	else
	{
		$txtTbl .= '<COL WIDTH="50px"><COL WIDTH="545px">';
		$txtTbl .= '<tr BGCOLOR="#D3D3D3">';
		$txtTbl .=  '<th align="left"></th>';
		$txtTbl .= '<th align="left">text</th>';
		$txtTbl .= '</tr>';
	}

	for ($idx=0; $idx < sizeof($textList); $idx++)
	{
		$txtTbl .= '<tr>';
		$txtTbl .= '<td align="left">' . '<A HREF="javascript:submitCmdForm(\'edit\', '. $textList[$idx]['recId'].' )">edit</A> </td>';
		if ($includeDelete)
		{
			$txtTbl .= '<td align="left">' . '<A HREF="javascript:submitCmdForm(\'delete\', '. $textList[$idx]['recId'].' )">delete</A> </td>';
		}
		$txtTbl .= '<td align="left">' . $textList[$idx]['text'] .'</td>';
		$txtTbl .= '</tr>';
	}

	$txtTbl .= '</table>';
	
	return $txtTbl;

}  // end of buildTextTable()


/**********************************************************
function    : builbuildLanguage2TranslatedTextTable
description : ghlsdlkghlsdjghlsdjhlgkjhsldkjhgljksdhglkjhsdlkghlsdkjhgljk h
* 
* good article:    http://www.htmlcodetutorial.com/tables/index_famsupp_147.html  
***********************************************************/
function buildLanguage2Translate($selectedLang)
{
	global $supported_languages;
	
	$lang2Trans = '<form name=translate2Form action="index.php" method=POST>';
	$lang2Trans .= '<input type="hidden" name="subCmd" value="select_translate2" />';
	$lang2Trans .= '<select name=langSelector size=1 onChange="translate2Form.submit();">';

	foreach( $supported_languages as $value => $name)
	{
		$selected = ($selectedLang == $value)? " selected " : " ";
		$lang2Trans .= '<option value="' . $value . '"' . $selected . '>' . $name .'</option>';
	}
	
	$lang2Trans .= '</select>';
	$lang2Trans .= '</form>';

	return $lang2Trans;
	
} // end of buildLanguage2Translate()
?>




  

