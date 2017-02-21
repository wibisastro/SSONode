<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/
require("../conf/config.php");
require("gov2model.php");

#------------------------init
$cases=array("public");
$gov2=new gov2model;
$gov2->authorize($cases[0]);
$slogin=getmodule("slogin");
$ssignup=getmodule("ssignup");
$spassword=getmodule("spassword");
$main=getmodule("sprofile");
$passsync=getmodule("passsync");
#------------------------process

if ($_POST) {
  if ($_POST["cmd"]=="auth") {
	  echo $api->apicall_response($_POST);
	  exit;
  } else {
	  $apicall_id=$api->apicall_auth($_POST);
	  $valid=$api->apicall_read($apicall_id);
	  if ($valid->status=="closed") {
		  $data=json_decode(stripslashes($_POST["req"]),1);
		  while(list($key,$val)=each($data)) {${"$key"}=$val;}
	  } else {$cmd="fail";}
  }
  $response["cmd"]=$cmd;
  switch($cmd) {
	case "passsync_add":
		if ($account_id) {
            $data['apikey']=$_POST["apikey"];
            $profile=$main->sprofile_read($data['account_id']);
			$response=$passsync->passsync_add($data,$profile);
		} else {
            $response["status"]="error";
            $response["message"]="NoID";
        }
	break; 
	case "sprofile_read":
		if ($account_id) {
			$response=$main->sprofile_read($account_id);
		} else {
            $response["status"]="error";
            $response["message"]="NoID";
        }
	break;  
	case "fail":
        $response["status"]="fail";
        $response["message"]=$valid->status;
	break; 
	default:
      $response["status"]="fail";
      $response["message"]="nocase";
  }
} else {
    $response["cmd"]=$_GET['cmd'];
	switch($_GET['cmd']){
        case "read":
            if ($_GET['nav_id']) {
                $response=$nav->read($_GET['nav_id']);
            } else {
                $response["status"]="error";
                $response["message"]="NoID";
            }
        break;  
        case "xml":
            $filename=$_GET["file"];
            $data=file_get_contents(xmlpath."/".$filename.".xml");
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Content-Type: text/xml');
            echo $data;
        exit;
        break;
        default:
	}
}

#--------view
$response["comm"]="ok";
json_encode($response);
?>