<?php

// call session_start() to create a session. 
//session_start();  


//include_once("hl_config.php");
require_once "../libs/JSON.php";
//require_once "logger.php";
//require_once "fileManager.php";
//require_once "general.php";
//require_once ( "text/text.php");

//////////phpinfo(INFO_VARIABLES);
////phpinfo();
$json = new Services_JSON();

$msgResp = array('status'=> 'err', 
               'response' => 'Unable to process request',
               'action'=> 'standard',
               'stuff'=> null);



if ( isset($_REQUEST['action'])  ){
	switch ($_REQUEST['action']){
			
		case "ttloginreq":
			$msgResp['user'] = $_REQUEST['uname'];
			$msgResp['pwd'] = $_REQUEST['upw'];
			$msgResp['response'] = "tryin to handle it:";
			$msgResp['currDate'] = date("Y/m/d"); 
			$msgResp['goto'] = HLBASEURL.$nr_session_handlers[$nr_session[1][0]];
			break;

		default:
			$msgResp['response'] =  'action not recognized' ;
			$msgResp['action'] =  null ;
			break;
	}  //end of switch
}else{
	$msgResp['response'] =  'request has no action' ;
	$msgResp['action'] =  null ;
    
}


//convert php object to json 
$output = $json->encode($msgResp);

print($output);// echo $output;

  

?>

