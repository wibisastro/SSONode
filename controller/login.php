<?
/********************************************************************
*	Date		: 22 May 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: Cyber GovLabs. All rights reserved.
*********************************************************************/
require("../conf/config.php");
require("gov2model.php");

$gov2=new gov2model;
$gov2->authorize("guest");

#------------------------init
$doc->content("../controller/gov2view.php");

switch($_GET["cmd"]) {
    case "activate":
        $doc->pagetitle="Gov 2.0 SSO Node Activation";
        $view="activate";
    break;
    case "signup":
        $doc->pagetitle="Gov 2.0 SSO Node Registration";
        $view="signup";
    break;
    default:
        if ($gov2->error) {$doc->pagetitle="Gov 2.0 SSO Node Login";}
        else {$doc->pagetitle="Gov 2.0 SSO Node Profile";}
}

$doc->error_message();

#------------------------display
include(viwpath."/general/body.php");
?>