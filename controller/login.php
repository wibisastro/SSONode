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
        $doc->pagetitle="e-Planning Activation";
        $view="activate";
    break;
    case "signup":
        $doc->pagetitle="e-Planning Registration";
        $view="signup";
    break;
    default:
        if ($gov2->error) {$doc->pagetitle="Gov 2.0 Node Login";}
        else {$doc->pagetitle="e-Planning Profile";}
}

$doc->error_message();

#------------------------display
include(viwpath."/general/body.php");
?>