<?php



	if (session_id() == ""){
		session_start(); // if no active session we start a new one
	}

	/////////////phpinfo(INFO_VARIABLES);


	//////echo $_SESSION['user_logged'];

	require_once "libs/sessCommon.php";
	require_once "libs/appCommon.php";
	require_once "wClass/oMLClass.php";
	require_once "wClass/DBClass.php";
	require_once "wClass/miscClass.php";
	require_once "frmScript/frmMain.php";

	require_once "frmScript/frmConfig.php";
	require_once "frmScript/frmQuery.php";
	
	require_once "linga/lingaQuery.php";
	
	
	$URLParams = frm_mergeGetPost();

	$page_state = frm_pageAccess($URLParams);

	echo " -> frm_pageRequestState[" . $page_state . "]";
	$rObj = frm_pageRequestState($page_state);
	
		echo $rObj->getHead();
		$displayObj = $rObj->getPageDataObjects();
		require $rObj->getPageTemplate();    // $templateP;
		echo $rObj->getEnd();

// dna aug 23	if ("nop" != $rObj->getState() )
// dna aug 23	{
// dna aug 23		require $rObj->getReturnedObj();
// dna aug 23	}

phpinfo();
?>






  

