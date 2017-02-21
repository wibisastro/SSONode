<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/
require("../conf/config.php");
require("gov2model.php");

$cases=array("guest","add","remove","update");
$gov2=new gov2model;
// $gov2->authorize($cases[0]);
$gov2->authorize("member");
#------------------------init
$slogin=getmodule("slogin");
$main=getmodule("account");
$doc->pagetitle="Gov2.0 Member";
#------------------------process

if (!$gov2->error) {  
    if ($_POST) {
    	switch($_POST["cmd"]) {
            case "add":
                if (!$_POST['nama']) {$doc->error="Uncomplete";}
                else {
                    $_POST['account_id']=$gov2->authorized['account_id'];
                    $id=$main->{$pageID."_add"}($_POST);
                    $response=$main->{$pageID."_read"}($id);
                }
                include(viwpath."/scaffold/response.php");
                exit;
              break;
            case "remove":        
                if (!$_POST[$pageID.'_id']) {$doc->error="NoID";}
                else {$main->{$pageID."_remove"}($_POST);}
                include(viwpath."/scaffold/response.php");
                exit;
              break;
            case "changepass": 
                if (!$_POST[$pageID.'_id']) {$doc->error="NoID";}
                else {$main->{$pageID."_changepass"}($_POST);}
                $response=$main->{$pageID."_read"}($_POST[$pageID.'_id']);
                include(viwpath."/scaffold/response.php");
                exit;
              break;
            case "reset": 
                // if (!$_POST[$pageID.'_id']) {$doc->error="NoID";}
                // else {$main->{$pageID."_reset"}($_POST);}
                // $response=$main->{$pageID."_read"}($_POST[$pageID.'_id']);
                // include(viwpath."/scaffold/response.php");
                exit;
              break;
            case "update":
                $main->{$pageID."_update"}($_POST,$_POST[$pageID.'_id']);
                $response=$main->{$pageID."_read"}($_POST[$pageID.'_id']);
                $c=$_POST['no'];
                include(viwpath."/scaffold/response.php");
                exit;
              break; 
            default:
        }
    } else {
    	switch($_GET["cmd"]) {
	        case "identify":
                $_SESSION['servicepage']=$_SERVER['SCRIPT_NAME'];
                header("location: gov2auth.php?".$_SERVER["QUERY_STRING"]);
            break;
            case "edit":        
                if (!$_GET[$pageID.'_id']) {$doc->error="NoID";}
                else {
                    $edit=$main->{$pageID."_read"}($_GET[$pageID."_id"]);
                    $edit->no = $_GET["no"];
                }
                include(viwpath."/scaffold/edit.php");
                exit;
            break;
            default:
                if (!$_SESSION['active_client']) {
                    $scaffold['addbutton']=true;
                    $scaffold['form']='default';
                }
                $data=$main->{$pageID."_browse"}();
                $doc->content("scaffold/browse_noadd.php");
                $doc->content("account/remove_sub.php");

    	}
    }

} elseif ($_GET["cmd"]=="identify") {
    $_SESSION['servicepage']=$_SERVER['SCRIPT_NAME'];
    $_SESSION['landingpage']="gov2auth.php?".$_SERVER["QUERY_STRING"];
    header("location: ".account_url."/slogin.php?servicepage=1&client=".$_SERVER["SERVER_NAME"]);
    exit;
} 
$doc->error_message();

#------------------------display
include(viwpath."/general/body.php");
?>


