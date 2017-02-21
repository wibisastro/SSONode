<?
class handshake extends db_connection {
#---------------- handsake
	function apicall_auth($data) {
		global $config, $tbl_apicall;

		$query ="INSERT INTO $tbl_apicall VALUES(null,'open', NOW(''), '".$config->apikey->public."','$data[apikey]','$data[req]')";
		$auth["apicall_id"]=$this->write_db($query,"authenticate_apicall", $tbl_apicall);
		$auth["server_apikey"]=$config->apikey->public;
		$auth["apikey"]=$data['apikey'];
		$auth["signature"]=$data['signature'];
		$auth["req"]=$data['req'];
		$auth["cmd"]="auth";

		while(list($key,$val)=each($auth)) {$submit[$key]="$key=".stripslashes($val);}
		$body=implode("&",$submit);

		$header .= "POST ".$config->platform->apikey."/api.php HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($body) . "\r\n\r\n";
        $fp = fsockopen ('ssl://'.str_replace("https://","",$config->platform->apikey), 443, $errno, $errstr, 30);

		if (!$fp) {
			$result="HTTP ERROR";
   //         echo $config->platform->apikey.$errstr;
		} else {
			fputs ($fp, $header . $body);
			while (!feof($fp)) {
				$line = fgets ($fp, 1024);
 //               echo $line;
				if (strcmp($line, "\r\n") == 0) {
					// read the header
					$headerdone = true;
				} elseif ($headerdone) {
					// header has been read. now read the contents
					$res .= $line;
				}
			}
			fclose ($fp);
			$result=$res;
		}
		if ($result=="Error") {
			$query="UPDATE $tbl_apicall SET status='error' WHERE apicall_id = ".$auth["apicall_id"];
	//		echo $query;
			$this->write_db($query, "apicall_auth");
		} else {
			$result=$auth["apicall_id"];
		}
	return $result;
	}
   
	function apicall_response($data) {
		global $tbl_apicall;
		$valid=$this->apicall_read($data["apicall_id"]);
		if (!$valid->apicall_id) {
			$query="INSERT INTO $tbl_apicall VALUES(null,'ilegal', NOW(''), '$data[server_apikey]','$data[apikey]', '".stripslashes($data[req])."')";
			$this->write_db($query,"apicall_auth: insert");
			$result="ilegal";
		} else {
			$query="UPDATE $tbl_apicall SET status='$data[status]' WHERE apicall_id='$valid->apicall_id'";
			$this->write_db($query,"apicall_response");
			$result="ok";
		}
	return $result;
	}	

	function apicall_read($apicall_id) {
		global $tbl_apicall;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT apicall_id,status FROM $tbl_apicall WHERE apicall_id='$apicall_id'";
        $daftar = $this->read_db($db_name, $query,$db_link_id);
		$result= mysqli_fetch_object($daftar);
	return $result;
	}
}
?>