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
$slogin	    = getmodule("slogin");
$ssignup    = getmodule("ssignup");
$spassword  = getmodule("spassword");
$main   = getmodule("sprofile");

#------------------------process
unset($gov2->error);
if (!$gov2->error) {
    switch($_POST['cmd']) {
        case "Enable":
            if ($_POST['passsync_id']) {
                $data=$main->sprofile_read($_SESSION['account_id']);
                if ($data->pass==$slogin->slogin_package($data->email, $_POST['password_'.$_POST['passsync_id']])) {
                    $passsync_req=$passsync->passsync_read();
                    foreach($config->storage as $storage) {
                        if ($storage->domain==$passsync_req['domain']) {$storage_server=$storage;}
                    }
                    $storage=$storage_server;
                    $passsync->passsync_update($_POST['passsync_id'],'enabled');
                    $spassword->spassword_reset_password_cloud($_POST['password_'.$_POST['passsync_id']],$_SESSION['account_id']);
                } else {
                    $doc->error="UnmatchedPassword";
                }
            } else {
                $doc->error="NoID";
            }
            include(viwpath."/passsync/response.php");
            exit;
		break;
        case "updateBio":
            $data=$main->sprofile_read($_SESSION['account_id']);
            $bio=$main->sprofile_read_bio("facebook");
            if ($_POST['name_source']) {
                $doc->error=$main->sprofile_update_fullname($_POST);
                include(viwpath."/sprofile/response_bio_done.php");
            } else {
                $doc->error="Incomplete";
                include(viwpath."/sprofile/response_bio.php");
            }
            exit;
        break;
        case "updatePhone":
            if ($_POST['phone']) {
                $data=$main->sprofile_read($_SESSION['account_id']);
                if(!preg_match('/[0-9]/', $_POST['phone'])) {
                    $doc->error="InvalidValue";
                    include(viwpath."/sprofile/response_phone.php");
                } else {
                    $doc->error=$main->sprofile_update_phone($_POST['phone']);
                    $data=$main->sprofile_read($_SESSION['account_id']);
                    include(viwpath."/sprofile/response_2fa.php");
                } 
            } else {
                $doc->error="Incomplete";
                include(viwpath."/sprofile/response_phone.php");
            }
            exit;
        break;
        case "editPhone":
            $data=$main->sprofile_read($_SESSION['account_id']);
            include(viwpath."/sprofile/response_phone.php");
            exit;
        break;
        case "editBio":
            $bio=$main->sprofile_read_bio("facebook");
            $data=$main->sprofile_read($_SESSION['account_id']);
            include(viwpath."/sprofile/response_bio.php");
            exit;
        break;
        case "Change":
            if ($_POST['password'] && $_POST['pass1'] && $_POST['pass2']) {
                $data=$main->sprofile_read($_SESSION['account_id']);
                if ($data->pass==$slogin->slogin_package($data->email, $_POST['password'])) {
 //                   $new_passwd_status = $main->sprofile_newpass_validate($member->email,$password,$pass1);			
                    if(strlen($_POST['pass1']) < 8 || !preg_match('/[a-zA-Z]/', $_POST['pass1']) || !preg_match('/\d/', $_POST['pass1']) || $new_passwd_status=="TRUE") {
                        if ($new_passwd_status=="TRUE") {  
                            $doc->error="InvalidPass1";
                        } elseif(strlen($_POST['pass1']) < 8){
                            $doc->error="InvalidPass2";	
                        } else { 
                            $doc->error="InvalidPass3";
                        }
                    } else {
           //             $main->insert_passwd_history($member->member_id,$member->email,$pass1); 
                        $_POST['email']=$data->email;
                        $doc->error=$main->sprofile_update_pass($_POST);	
                        #---------------catatan: mestinya ada error message seperti di atas 
                    }                
                } else {
                    $doc->error="WrongPassword";
                }
            } else {
                $doc->error="Uncomplete";
            }
            $button="change";
            include(viwpath."/sprofile/response_pass.php");
            exit;
        break;
        default:
            switch($_GET["cmd"]) {
                default:
                    if ($_SESSION['fullname']) {
                        $data=$main->sprofile_read($_SESSION['account_id']);
                        $bio=$main->sprofile_read_bio("facebook");
                        $doc->content("sprofile/profile.php");
                        $tab=$_GET['tab'];
                    } else {
                        header("location: slogin.php?client=".$_GET['client']);
                    }       
            }
    }
} else {
    header("location: slogin.php?client=".$_GET['client']);
}

if ($doc->error) {unset($gov2->error);$doc->error_message();}

#------------------------display
include(viwpath."/sprofile/body.php");
?>
