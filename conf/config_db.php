<?
/*
Author		: Wibisono Sastrodiwiryo
Date		: Thursday, November 20, 2008
Contact		: wibi@alumni.ui.ac.id
Version		: 0.1.0
*/

#---------------------------------------cybergl platform tables configuration
    $tbl_apicall        = "apicall";
	$tbl_account   		= "account";
	$tbl_member  		= "member";
	$tbl_privilege 		= "privilege";
	$tbl_case   		= "case";
	$tbl_session   		= "session";
	$tbl_pass_req	    = "pass_request";
	$tbl_pass_his	    = "pass_history";
	$tbl_twostep	    = "twostep";
    $tbl_payment        = "payment";
    $tbl_notif          = "vt_notif";
    $tbl_bio            = "bio";
    $tbl_passsync       = "passsync";
#---------------------------------------database classes

class db_connection {
	function connect_db($db_server="") {
		static $recent_random;
        switch (STAGE) {
            case "build":
                $user="code4sso";
                $pass="";
                $host="localhost";
                $db_name="code4_sso";
            break;
            default:
                $user="root";
                $pass="";
                $host="localhost";
                $db_name="bappeda_sso";       
        }

		switch ($db_server) {
			case "account":
				$db["sys"]["user"]   = $user;
				$db["sys"]["pass"]   = $pass;
				$db["sys"]["host"]   = $host;
				$db_name		         = $db_name;
				$db_link_id=mysqli_connect($db["sys"]["host"], $db["sys"]["user"], $db["sys"]["pass"],$db_name) or die("Unable to connect to SQL server 'account'");	
			break;
			default:
				$db["master"]["user"]	= $user;
				$db["master"]["pass"]	= $pass;
				$db["master"]["host"]	= $host;
				$db_name			        = $db_name;
				$db_link_id=mysqli_connect($db["master"]["host"], $db["master"]["user"], $db[master]["pass"],$db_name) or die("Unable to connect to SQL 'master'");
		}
		$result=array($db_link_id,$db_name,$random);
	return $result;
	}

	function write_db($query,$fname,$table="",$db="master") {
		list($db_link_id,$db_name)=$this->connect_db($db);
		$this->read_db($db_name,$query,$db_link_id) or die("$fname: ($db)".mysqli_error($db_link_id));

		if ($table) {
			$result=mysqli_fetch_object($this->read_db($db_name, "SELECT LAST_INSERT_ID() AS id FROM $table",$db_link_id));
		}
	return $result->id;
	}

	function read_db($db_name, $query, $db_link_id) {
       $result = mysqli_query($db_link_id,$query);
       if (!$result) {
               echo "SQL error:".mysqli_error($db_link_id);
               exit;
       }
       return $result;
   }
}
?>