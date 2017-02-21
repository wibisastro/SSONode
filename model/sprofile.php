<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/

class sprofile extends spassword {
    
	function sprofile_update_fullname ($data) {
		global $tbl_account,$mailgun;
        list($db_link_id,$db_name, $db_server)=$this->connect_db();
        $data['fullname']=mysqli_real_escape_string($db_link_id,$data['fullname']);
        $data['birthday']=mysqli_real_escape_string($db_link_id,$data['birthday']);
        $data['gender']=mysqli_real_escape_string($db_link_id,$data['gender']);
        list($d,$m,$y)=explode("/",$data['birthday']);
        $birthday="$y-$m-$d";
		$query="UPDATE $tbl_account SET fullname='$data[fullname]', birthday='$birthday', gender='$data[gender]', last_modify=NOW() WHERE account_id=".$_SESSION['account_id'];
		$this->write_db($query, "sprofile_update_fullname");
    return $error;
	}
    
	function sprofile_read_bio ($source) {
		global $tbl_bio;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
		$query ="SELECT $tbl_bio.*,
		DATE_FORMAT($tbl_bio.birthday, '%e %b %Y') AS formated_birthday,
		DATE_FORMAT($tbl_bio.created_date, '%e %b %Y, %H:%i:%s') AS formated_created_date
		FROM $tbl_bio 
		WHERE $tbl_bio.account_id='".$_SESSION['account_id']."' AND source='$source' AND status='active'";
		$result=mysqli_fetch_array($this->read_db($db_name,$query,$db_link_id));
	return $result;
	}
    
	function sprofile_update_bio ($data) {
		global $tbl_account,$twilio,$tbl_bio;
		$query="UPDATE $tbl_account SET facebook='$data[id]', star_facebook=NOW(), last_modify=NOW() WHERE account_id=".$_SESSION['account_id'];
		$this->write_db($query, "sprofile_update_bio");
        list($MM,$DD,$YYYY)=explode("/",$data['birthday']);
        $YYYY+=0;$DD+=0;$MM+=0;
        $birthday="$YYYY-$MM-$DD";
        if ($data['gender']=="male") {$gender="laki-laki";} else {$gender="perempuan";}
        $query ="INSERT INTO $tbl_bio VALUES(null, ".$_SESSION['account_id'].", '$data[id]', 'facebook', '$data[link]', '$data[name]', '$gender', '$birthday', '', '$data[timezone]', '', '', '".$data['picture']['data']['url']."', 'active',NOW())";
        $this->write_db($query, "sprofile_update_phone");
        
        try {
            /*
            $message = $twilio->account->messages->create(array(
                "From" => "+18478654192",
                "To" => "+62".$phone,
                "Body" => "Kode 2FA Gov 2.0: $code2fa",
            ));
            */
        } catch (Services_Twilio_RestException $e) {
            $error=$e->getMessage();
        }
    return $error;
	}
    
	function sprofile_update_phone ($data) {
		global $tbl_account,$twilio,$tbl_twostep;
		$query="UPDATE $tbl_account SET phone='$data', twostep='inactive' WHERE account_id=".$_SESSION['account_id'];
		$this->write_db($query, "sprofile_update_phone");
        if (substr($data,0,1)=="0") {$phone=substr($data,1,strlen($data)-1);}

        $code2fa = mt_rand(100000, 999999);
        $query ="INSERT INTO $tbl_twostep VALUES(null, ".$_SESSION['account_id'].", $code2fa,NOW(),NOW(), 'issued', '".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_X_FORWARDED_FOR']."','".session_id()."')";
        $this->write_db($query, "sprofile_update_phone");
        
    return $error;
	}
    
	function sprofile_read ($account_id) {
		global $tbl_account;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
        $account_id+=0;
		$query ="SELECT $tbl_account.*,
		DATE_FORMAT($tbl_account.last_login, '%e %b %Y, %H:%i:%s') AS formated_last_login,
		DATE_FORMAT($tbl_account.date_inserted, '%e %b %Y') AS formated_date_inserted
		FROM $tbl_account 
		WHERE $tbl_account.account_id=$account_id";
		$result=mysqli_fetch_object($this->read_db($db_name,$query,$db_link_id));
	return $result;
	}
    /*
	function sprofile_update ($data,$old_pass="") {
		global $tbl_account,$ses;
		if ($data[status]) {$status="status='$data[status]',";}
		if (!$old_pass || $old_pass == $data[pass]) {$pass="";}
		else {$pass="pass='".$ses->package($data[email],$data[pass])."', ";}
		$query="UPDATE $tbl_account SET $status $pass firstname='$data[firstname]', phonenumber='$data[phonenumber]',nik='$data[nik]'";
		$query.="WHERE account_id='$data[account_id]'";
		$this->write_db($query, "update", $tbl_account, "account");
		$this->update_supporter($data["firstname"],$data["account_id"]);
	}

	function sprofile_newpass_validate ($email,$curr_passwd="",$new_passwd){	
		global $tbl_oldpass,$ses;		
		$account     = $this->get_account($email);
		$new_passwd = $this->get_encrypt_passwd($email,$new_passwd);
		$oldpass    = $this->cek_old_passwd($account->account_id,$new_passwd); //print_r($oldpass);
				
		return $oldpass;		
	}
*/
	function sprofile_update_pass ($data) { 
		global $tbl_account;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
		if ($data["pass1"] == $data["pass2"]) {
			$query="SELECT * FROM $tbl_account WHERE account_id='$_SESSION[account_id]'";
			$valid = mysqli_fetch_object($this->read_db($db_name,$query,$db_link_id));
			if ($valid->pass != $this->slogin_package($valid->email,$data["password"])) {$error="InvalidVerify";} 
            else {
				$pass=$this->slogin_package($valid->email,$data["pass1"]);
				$query="UPDATE $tbl_account SET pass='$pass' WHERE account_id='$_SESSION[account_id]'";
				$this->write_db($query,"update_pass");
                $this->spassword_reset_password_cloud($data["pass1"],$_SESSION["account_id"]);
			}
		} else {$error="InvalidVerify";}
	return $error;
	}
	

}
?>
