<?
/********************************************************************
*	Module		: CyberGL Logout Interface
*	Date		: 26 Mei 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: Cyber GovLabs. All rights reserved. 
*********************************************************************/
require("../conf/config.php"); 
require("gov2model.php");
#------------------------init
$gov2=new gov2model;
$gov2->authorize('guest');
if (!$_SESSION['logout']) {$_SESSION['logout']=$_GET['client'];}
if (!$gov2->error) {
    if (is_array($_SESSION['client'])) {
        while (list($key,$val)=each($_SESSION['client'])) {
            unset($_SESSION['client'][$key]);
            if ($_GET['client']==$_SERVER['SERVER_NAME'] && $_SERVER['SERVER_NAME']!=$key) {
                session_destroy();
                header("Location: http://".$_SERVER['SERVER_NAME']."/slogin.php?client=".$key);
            } else {
                header("Location: http://".$key."/gov2login.php?cmd=logout");
            }
            exit;
        }
    }
    session_destroy();
}
Header("location: http://".$_SESSION['logout']);
?>