<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/

class spassword extends ssignup {
	function spassword_lost_check($email) {
		global $tbl_account;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
        $email=mysqli_real_escape_string($db_link_id,$email);
		$query="SELECT * FROM $tbl_account WHERE email='$email'";
		$result=mysqli_fetch_object($this->read_db($db_name, $query,$db_link_id));
	return $result;
	}

	function spassword_lost_confirm($code=0) {
		global $tbl_pass_req;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
		$resetnum=base_convert($code, 36, 10);
		$unix=substr($resetnum,-10);
		$len=strlen($resetnum);
		$id=substr($resetnum,0,$len-10);
		//$sqltime=date('Y-m-d H:i:s',$unix);
		$query="SELECT *, HOUR(SEC_TO_TIME(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(date))) AS date_period FROM $tbl_pass_req WHERE date=FROM_UNIXTIME($unix) AND pass_request_id=$id";
		//echo $resetnum."-".$unix."=".$id,"<br>",$query;
		$result=mysqli_fetch_object($this->read_db($db_name, $query,$db_link_id));
		return $result;
	}

	function spassword_reset_request($data) {
		global $tbl_pass_req,$mailgun,$config;
		$time=time();
		$query="INSERT INTO $tbl_pass_req VALUES (null, $data->account_id, '$data->email', 'request', FROM_UNIXTIME($time, '%Y-%m-%d %H:%i:%s'))";
		$id=$this->write_db($query,"spassword_reset_request",$tbl_pass_req);
		$idtime=$id.$time;
		$code=base_convert($idtime, 10, 36);
		include(viwpath."/slogin/mail_resetpwd_req.php");

		$req_ip = "\n\n------------------------\nClient IP: ".$_SESSION['ip_ref'];	
 //       echo $bodymail;
        //echo "REQ-IP di modell rest req=".$ip; //$id,"-".$time,$bodymail;
        $mailgun->sendMessage($config->mailgun->domain, array('from' => 'noreply@cybergl.co.id', 
        'to'      => $data->email, 
        'subject' => 'Permintaan Reset Password Gov 2.0', 
        'text'    => $bodymail
        ));

        $mailgun->sendMessage($config->mailgun->domain, array('from' => 'noreply@cybergl.co.id', 
        'to'      => 'wibi@cybergl.co.id', 
        'subject' => 'Permintaan Reset Password Gov 2.0 (copy)', 
        'text'    => $bodymail.$req_ip
        ));
	return $id;
	}
/*
	function get_request ($account_id){
		global $tbl_pass_req;
		$query="SELECT FROM $tbl_reset";
		$id=$this->write_db($query,"reset_password",$tbl_pass_req, "account");
		include(viwpath."/slogin/mail_resetpwd_req.php");
		//echo $bodymail;
		mail($data->email,"Permintaan Reset Password",$bodymail,"From: ".webmaster."\nReplyTo: ".webmaster."\nBcc: ".webmaster."\n"); 
	return $id;
	}
*/
	function spassword_reset_password ($reset) {
		global $tbl_account,$tbl_pass_req,$mailgun,$config;
		list($db_link_id,$db_name, $db_server)=$this->connect_db("account");
		$query="SELECT * FROM $tbl_account WHERE account_id='$reset->account_id'";
		$data=mysqli_fetch_object($this->read_db($db_name, $query,$db_link_id));

		$newpass=$this->ssignup_passgen(6);
		$pass=$this->slogin_package($reset->email,$newpass);		
	//	$this->spassword_history_log($reset->account_id,$reset->email,$pass);
		
		$query="UPDATE $tbl_account SET pass='$pass' WHERE account_id='$reset->account_id'";
		$this->write_db($query,"reset_password:account",$tbl_account,"account");

		$query="UPDATE $tbl_pass_req SET status='confirmed' WHERE pass_request_id='$reset->pass_request_id'";
//		echo $query;
		$this->write_db($query,"spassword_reset_password");
		include(viwpath."/slogin/mail_resetpwd.php");
//		echo $bodymail;
        $mailgun->sendMessage($config->mailgun->domain, array('from' => 'noreply@cybergl.co.id', 
        'to'      => $data->email, 
        'bcc'     => 'wibi@cybergl.co.id', 
        'subject' => 'Password Anda Telah Berhasil Direset', 
        'text'    => $bodymail
        ));
        $this->spassword_reset_password_cloud($newpass,$reset->account_id);
	return $data;
	}
    
	function spassword_reset_password_cloud ($pass,$account_id) {
        global $config,$mailgun;
        #-----init
        foreach($config->storage as $storage) {
            foreach($storage->client as $client) if ($client==$_SESSION['caller']) {$client=true;}
            if ($storage->domain==$_SESSION['caller'] || $client) {
                $admin['username']=$storage->username;
                $admin['password']=$storage->password;
                $admin['url']=$storage->url;
                $admin['quota']=$storage->quota;
            }
            unset($client);
        } 
//        print_r($admin);
        
        $url=$admin['url'].'/users';
        $fields = array(
            'key' => 'password',
            'value' => $pass
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."/usr".$account_id);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $admin['username'].":".$admin['password']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen(http_build_query($fields)))); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
//        echo $output;
        return simplexml_load_string($output);        
    }
    /*
	function spassword_history_log($account_id=0,$email,$new_passwd){
		global $tbl_passhistory,$ses;		
		$account      = $this->get_account($email);				
		$new_passwd  = $this->get_encrypt_passwd($email,$new_passwd);				
		$query ="INSERT INTO $tbl_passhistory VALUES(null,'$account_id','$new_passwd','$account->pass',NOW(''))";
		$this->write_db($query, "insert", $tbl_oldpass,"account");		
	}
    */
}
?>