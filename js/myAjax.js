






var http_request = false;

var row = 1;

var barcode;

var callback;  /// = displayLocation;


function makeRequest(url, handler, params) 

{



  callback = handler;

  http_request = false;



  if (window.XMLHttpRequest) { // Mozilla, Safari,...

    http_request = new XMLHttpRequest();

    if (http_request.overrideMimeType) {

      http_request.overrideMimeType('text/xml');

    }

  } else if (window.ActiveXObject) { // IE
    alert("makeRequest: IE");

    try {

      http_request = new ActiveXObject("Msxml2.XMLHTTP");

    } catch (e) {

      try {

        http_request = new ActiveXObject("Microsoft.XMLHTTP");

      } catch (e) {}

    }

  }



  if (!http_request){

    alert('Giving up :( Cannot create an XMLHTTP instance');

    return false;

  }



  http_request.onreadystatechange = checkState;

  // make request
//////////////////////////////////////////////         alert("makeRequest: "+url+"\n"+params);

  http_request.open('GET', url+'?'+params, true);

  http_request.send(null);



  return false;



}



// process request results

function checkState(){

  if (http_request.readyState == 4){

    if (http_request.status == 200){

      callback(http_request.responseText); // displayLocation(http_request.responseText);

    } else {

      alert('Bad Request: '+http_request.status);

    }

  }

}







