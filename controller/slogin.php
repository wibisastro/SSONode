<?php
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/

require("../conf/config.php"); 
require("gov2model.php");
#------------------------init
$cases=array("guest","login","approved");
$gov2=new gov2model;
$gov2->authorize($cases[0]);
$slogin	= getmodule("slogin");

#------------------------process
if ($_POST) {
    switch ($_POST['cmd']) {
        case "login":
			if ($_POST['email'] && $_POST['password']) { #<----- untuk bypass google captcha
/*
#---uncomment untuk pake google captcha - start
            if ($_POST['email'] && $_POST['password'] && $_POST['g-recaptcha-response']) {
                $recaptcha_response=file_get_contents($config->recaptcha->api."?secret=".$config->recaptcha->secretkey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
                $recaptcha_response=json_decode($recaptcha_response);
                if ($recaptcha_response->success) {
#---uncomment untuk pake google captcha - end
*/
					$authenticated=$slogin->slogin_authenticate($_POST);
                    if ($authenticated['error']) {$doc->error=$authenticated['error'];}
                    else {
                        $token=$slogin->slogin_login($authenticated);
                        $_SESSION['client'][$_SESSION['caller']]=time();
                        echo $api->session_send($token);
				        exit;                                
                    }
/*
#---uncomment untuk pake google captcha - start
                } else {
                    $doc->error=$recaptcha_response->{"error-codes"}[0];
                }
            } else {
                $doc->error="Incomplete";
#---uncomment untuk pake google captcha - end
*/
            }
            $doc->content("slogin/login.php");
        break;
        default:
            
    }
} else {
    switch ($_GET['cmd']) {
        case "connect":
			if ($_SESSION['account_id']) {
				$data=$api->ssonode_connect();
				if ($_SESSION['sso_id']==0) {$slogin->slogin_ssoid_update($data["account_id"]);}
				header("Location: ".SSOCONN."/slogin.php?cmd=connect_ssonode&session=".$data["session_connect"]."&ssokey=".$config->apikey->public);	
				exit;
			} else {
				header("Location: ".SSONODE."/slogin.php?cmd=request&client=".$_GET["caller"]);	
				exit;
			}
		break;
        case "authorize":
            if ($_GET["token"]) {
                $data=$slogin->slogin_authorize($_GET["token"]);
                if ($_GET["token"]==$data['session']) {
					$data['ssokey']=str_replace("[","",$config->apikey->public);
                    echo json_encode($data);
                    exit;
                } else {$gov2->error=$data['error'];}
            } else {$gov2->error="NoID";}
            echo json_encode($gov2);
            exit;
        break;
        default:
            if ($_GET["client"]) {
                $_SESSION['caller']=$_GET["client"];
                $_SESSION['webroot']=$_GET["webroot"];
                $_SESSION['https']=$_GET["secure"];
                if ($_SESSION['account_id']) {
                	$result=$api->session_send(session_id(),$_GET['servicepage']);
                    $_SESSION['client'][$_SESSION['caller']]=time();
                    echo $result;
                    exit;
                } else {$doc->content("slogin/login.php");}
            } else {header("location: index.php");}
    }
}

$doc->error_message();

#------------------------view
include(viwpath."/slogin/body.php");
?>
