<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/
require("../conf/config.php");
require("gov2model.php");

$cases=array("public");
$gov2=new gov2model;

$gov2->authorize($cases[0]);

#------------------------init
$doc->pagetitle="Admin";

switch($_GET["cmd"]) {
	case "pass":
        $slogin    = getmodule("slogin");
        $ssignup    = getmodule("ssignup");
    	echo $ssignup->ssignup_passgen(6);
        exit;
    break;
	case "set":
    	$_SESSION[$_GET['session']]=$_GET['val'];
    break;
    default:
    if($gov2->authorized["account_id"]){
        $doc->content("general/index.php");
    }
}
$doc->error_message();

#------------------------view
include(viwpath."/general/body.php");
?>