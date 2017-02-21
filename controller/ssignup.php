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
$main=getmodule("ssignup");
#------------------------process
switch($_POST["cmd"]) {
    case "Signup":
        $data=$_POST;
        $data['email']=strtolower($_POST['email']);
        $data['fullname']=strip_tags($_POST['fullname']);
/*       
        $recaptcha_response=file_get_contents($config->recaptcha->api."?secret=".$config->recaptcha->secretkey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $recaptcha_response=json_decode($recaptcha_response);
        if ($recaptcha_response->success) {$doc->error=$main->ssignup_validate($_POST['email']);}
        else {$doc->error=$recaptcha_response->{"error-codes"}[0];}     
*/
		$doc->error=$main->ssignup_validate($_POST['email']); #<--- comment jika pake google captcha
        if ($doc->error) {
            $button="Signup";
            $doc->content("slogin/signup.php");
            $tab="step1";
        } else {
            $result=$main->ssignup_insert($data);
            $doc->content("slogin/signup.php");
            $tab="step2";
            $button="Activate";
        }          
    break;
    case "Activate":
        if ($_POST['act_code']) {
            $doc->error=$main->ssignup_activate($_POST['act_code']);
            $tab="step3";
            if ($doc->error) {
                $button="Activate";
                $tab="step2";
            } else {$tab="step3";}
        } else {
            $doc->error="Uncomplete";
        }
        $doc->content("slogin/signup.php");
    break;
    default:
        switch($_GET["cmd"]) {
            case "cloudusername":
                /*
               $data=$main->ssignup_cloudusername('14');
                foreach($config->storage as $storage) {
                    foreach($storage->client as $client) if ($client==$_SESSION['caller']) {$client=true;}
                    if ($storage->domain==$_SESSION['caller'] || $client) {
                        $admin['username']=$storage->username;
                        $admin['password']=$storage->password;
                        $admin['url']=$storage->url;
                        $admin['quota']=$storage->quota;
                    }
                    unset($client);
                }
            //    print_r($admin);
                $data->account_id="test";
                if (is_array($admin)) $main->ssignup_cloud_add($data,"test123",$admin);
*/
                exit;
            break;
            case "activation":
                if (!$_SESSION['caller']) $_SESSION['caller']=$_GET['client'];
                $doc->content("slogin/signup.php");
                $tab="step2";
                $button="Activate";         
            break;
            case "activate":
                if ($_GET['act_code']) {
                    $doc->error=$main->ssignup_activate($_GET['act_code']);
                    $tab="step3";
                    if ($doc->error) {
                        $button="Activate";
                        $tab="step2";
                    } else {$tab="step3";}
                } else {
                    $doc->error="Uncomplete";
                }
                if (!$_SESSION['caller']) $_SESSION['caller']=$_GET['client'];
                $doc->content("slogin/signup.php");
            break;
            default:
                if ($gov2->error) {
                    if ($_GET['client']) {
                        $_SESSION['apikey']=$_GET['apikey'];
                        $_SESSION['caller']=$_GET['client'];
                        $_SESSION['req_ip']=$_SERVER['REMOTE_ADDR'];
                        $tab="step1";
                        $button="Signup";
                        if ($_SESSION["signup_error"]) {
                            $doc->error=$_SESSION["signup_error"];
                            unset($_SESSION["signup_error"]);
                        }
                        $doc->content("slogin/signup.php");
                    } else {header("location: index.php");}
                } else {header("location: index.php");}
        }
}


$doc->error_message();

#------------------------display
include(viwpath."/slogin/body.php");
?>