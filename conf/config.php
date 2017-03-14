<?
/********************************************************************
*	Date		: 07 May 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: eGov Lab UI 
*********************************************************************/
while (list($key,$val)=each($_GET)) {
    $val=strip_tags($val);
    if (preg_match('/[^a-zA-Z0-9_.\-]/', $val)) {header("location: hackattemptdetected.php");exit;} 
    else {$_GET[$key]=$val;}
}

$_GET['error']=isset($_GET['error']) ? $_GET['error'] : '';

switch ($_GET['error']) {
    case "all":error_reporting(E_ALL);break;
    case "warning":error_reporting(E_ALL & ~E_NOTICE);break;
    default:error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);break;
}

#-----instalation helper, must be shut off upon success
ini_set("display_errors", 1);

#---------------------------------------path configuration

switch ($_SERVER["SERVER_NAME"]) {
    case "sso.code4.gov2.web.id":
        define("dirpath",str_replace("/controller","",$_SERVER["DOCUMENT_ROOT"]));
        define("PATH_VENDOR","/var/www");
        define("STAGE","build");
    break;
    default:
        define("dirpath",$_SERVER["DOCUMENT_ROOT"]."/sso");
        define("PATH_VENDOR","../../../vendor");
        define("STAGE","dev");
}

define("conpath",dirpath."/controller"); #----- controller path
#---------------------------------------you can move this to improve security
define("cnfpath",dirpath."/conf"); #----- controller path
define("modpath",dirpath."/model"); #----- model path
define("viwpath",dirpath."/view"); #----- view path
define("xmlpath",dirpath."/xml"); #----- xml doc path

#---------------------------------------module recruiter
#-----do not change this

function getmodule ($name) {
    if (file_exists(modpath."/$name.php")) {require modpath."/$name.php";$result=new $name;} 
    else {echo "Module $name is not exist...";}
return $result;
}

#---------------------------------------initialization
#-----general client config

require(cnfpath."/config_db.php");
$doc	= getmodule("document");
if (STAGE!="prod") {$config = simplexml_load_file(xmlpath."/config.xml");}
else {$config = simplexml_load_file(xmlpath."/config_prod.xml");}
$pageID = str_replace(".php","",basename($_SERVER['SCRIPT_NAME']));
getmodule("handshake");
$api	= getmodule("api");

#-----specific client config


#-----plugin config
require PATH_VENDOR.'/mailgun/vendor/autoload.php';
use Mailgun\Mailgun;
$mailgun = new Mailgun($config->mailgun->apikey);
?>