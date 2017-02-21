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
$cases=array("guest","login","approved");
$gov2=new gov2model;
$gov2->authorize($cases[0]);
$slogin	= getmodule("slogin");
$ssignup= getmodule("ssignup");
$main=getmodule("spassword");
#------------------------process
switch($_POST['cmd']) {
	case "confirm":
		if ($_POST['confirm_code']) {
            $recaptcha_response=file_get_contents($config->recaptcha->api."?secret=".$config->recaptcha->secretkey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
            $recaptcha_response=json_decode($recaptcha_response);
            if ($recaptcha_response->success) {
                $reset=$main->spassword_lost_confirm($_POST['confirm_code']);
                if ($reset->account_id) {
                    if ($reset->status=="request") {
                        if ($reset->date_period<=24) {
                            $data=$main->spassword_reset_password($reset);
                            $tab="step3";
                        } else {
                            $doc->error="ResetExpired";
                            $tab="step1";
                            $button="reset";
                        }
                    } else {
                        $doc->error="ConfirmedReset";
                        $tab="step1";
                        $button="reset";
                    }
                } else {
                    $doc->error="CodeNotFound";
                    $button="confirm";
                    $tab="step2";
                }
            } else {
                $doc->error=$recaptcha_response->{"error-codes"}[0];
                $button="confirm";
                $tab="step2";
            } 
		} else {
			$doc->error="Incomplete";
		}
        $doc->content("slogin/forgot.php");
	break;
	case "reset":
		if ($_POST['email']) {
			$update=$_POST;
            $recaptcha_response=file_get_contents($config->recaptcha->api."?secret=".$config->recaptcha->secretkey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
            $recaptcha_response=json_decode($recaptcha_response);
            if ($recaptcha_response->success) {
                $data=$main->spassword_lost_check($_POST['email']);
                if ($data->account_id) {
                    if ($data->status!="active") {$doc->error="InactiveAccount";}
                    $main->spassword_reset_request($data);
                    $button="confirm";
                    $doc->content("slogin/forgot.php");
                    $tab="step2";
                } else {
                    $doc->error="EmailNotFound";
                    $tab="step1";
                    $button="reset";
                    $doc->content("slogin/forgot.php");
                }
            } else {
                $doc->error=$recaptcha_response->{"error-codes"}[0];
                $tab="step1";
                $button="reset";
                $doc->content("slogin/forgot.php");
            }
		} else {
            $doc->error="Incomplete";
		}
	break;
	default:
		if ($gov2->error) {
            $_SESSION['ip_ref']=$_SERVER['REMOTE_ADDR'];
            $tab="step1";
            $button="reset";
            $doc->content("slogin/forgot.php");
		} else {header("location: index.php");}
}

if ($doc->error) {unset($ses->error);$doc->error_message();}

#------------------------display
include(viwpath."/slogin/body.php");
?>