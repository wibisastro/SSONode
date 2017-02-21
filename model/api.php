<?
/*
Author		: Wibisono Sastrodiwiryo
Date		: 02 Des 2016
Copyleft	: eGov Lab UI
Contact		: wibi@alumni.ui.ac.id
Version		: 0.1.0
- 0.0.2 tambah browse, read, apicall - 23-03-2015
- 0.0.3 tambah session_send - 23-05-2015
- 0.1.0 tambah session_connect - 02-12-2016
*/

class api extends handshake {
    function ssonode_connect () {
		global $config;
		$req=array("cmd"=>"ssonode_connect", "sso_id"=>$_SESSION['sso_id'], "email"=>$_SESSION['email'], "fullname"=>$_SESSION['fullname'], "caller"=>$_SESSION['caller'],"ssokey"=>(string)$config->apikey->public);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall(SSOCONN,$data);
        return json_decode($result,1);
	}
	
    function session_send ($token,$servicepage=0) {
		global $config;
		$req=array("cmd"=>"sessave","token"=>$token,"servicepage"=>$servicepage);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
        if ($_SESSION['webroot']) {$path=$_SESSION['webroot']."/";} else {$path="/";}
	 	$result=$this->apicall("https://".$_SESSION['caller'],$data,$path);
        return $result;
	}
    
    function read ($service_id) {
		global $config;
		$req=array("cmd"=>"read","service_id"=>$service_id);
		$data["req"]=json_encode($req);
		$data["apikey"]=$config->apikey->public;
		$data["signature"]=sha1($config->apikey->public.$data["req"].$config->apikey->secret);
		$result=$this->apicall($config->platform->arch,$data);
	return json_decode($result);
	}

	function apicall ($host,$data,$login=false) {
		while(list($key,$val)=each($data)) {$submit[$key]="$key=$val";}
		$body=implode("&",$submit);

        if ($login) {$interface=$login."gov2login.php";}
        else {$interface="/api.php";}
		$header .= "POST $host"."$interface HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($body) . "\r\n\r\n";
        if (strstr($host,"https")) {$fp = fsockopen ('ssl://'.str_replace("https://","",$host), 443, $errno, $errstr, 30);}
        else {$fp = fsockopen (str_replace("http://","",$host), 80, $errno, $errstr, 30);}
			
//			echo "$host $interface $body";
		if (!$fp) {
			$result="HTTP ERROR: ($errno) $errstr $host/$interface $body";
		} else {
			fputs ($fp, $header . $body);
			while (!feof($fp)) {
				$line = fgets ($fp, 1024);
//				echo $line;
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
		return $result;
	}
}
?>
