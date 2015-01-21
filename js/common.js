function setInit(){

	// empty

}  // end of setInit()


function login(){
   makeRequest('test/tst_msgHandler.php', resp2Login, 
   				"action=ttloginreq"+"&uname="+"jojo"+
   				"&upw="+"bcm");   
} // end of login()


function resp2Login(text){

	//alert("respLogin response: "+"\n"+text);
		//	$msgResp['user'] = $_REQUEST['uname'];
		//	$msgResp['pwd'] = $_REQUEST['upw'];
		//	$msgResp['response'] = "tryin to handle it:";
		//	$msgResp['currDate'] = date("Y/m/d"); 
		//	$msgResp['goto'] =
  	var the_object = eval("(" + text + ")");
	
	alert(the_object.user + " tried to login at " + the_object['currDate']);
   	///var iStatus = the_object.status;
  ///	var uGoTo = the_object['goto'];   
  	
   ////	window.location.href = uGoTo;

 } // end of respLogin()


function getMsg(){
////	alert("in getMsg");
	login();
 //  makeRequest('msgHandler.php', resp2Login, 
 //  				"action=ttloginreq"+"&uname="+document.getElementById('usr').value+
 //  				"&upw="+document.getElementById('pwd').value);   
} // end of getMsg()


