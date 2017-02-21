<?php
/*
Author		: Wibisono Sastrodiwiryo
Date		: 11 Des 2016
Copyright	: e-Gov Lab Univ of Indonesia 
Contact		: wibi@alumni.ui.ac.id
Version		: 0.0.1 -> 23-Nov-06, 13:55  
			: 0.0.2 -> menghilangkan penggunaan 2 table untuk admin dan member
			: 0.2.0 -> pakai facebook connect
			: 0.2.1 -> integrasi facebook connect dan member table, Monday, June 08, 2009
			: 0.2.2 -> ubah privilege agar dapat pakai multi privelege, Tuesday, August 04, 2009
			: 0.2.3 -> ubah privilege agar dapat pakai multi privelege, Tuesday, Monday, December 14, 2009
			: 0.2.4 -> ubah login() untuk bisa dipakai konsep SOA, Saturday, February 27, 2010
			: 0.3.0 -> ubah mysql menjadi mysqli, 22 Mei 2015
            : 0.3.1 -> tambah session regenerate id untuk security
			: 0.3.2 -> tambah two factor authentication untuk security, 9 feb 16
            : 0.3.2 -> tambah fungsi slogin_authenticate_facebook(), 2 mar 16
			: 0.4.0 -> strip facebook untuk e-planning bappenas, 11 des 16
*/
class slogin extends document {
	function slogin() {
	    $this->timeout			= 120; #---seconds
		$this->timeout_session	= 480; #---minutes
	}
	
	function slogin_ssoid_update ($account_id) {
		global $tbl_account;
		$account_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
	    $query="UPDATE $tbl_account SET sso_id=$account_id WHERE account_id=$_SESSION[account_id]";
	    $this->read_db($db_name, $query,$db_link_id);
	return $result;
	}
    	
	function slogin_login ($data) {
        global $tbl_session,$tbl_bio,$config;
        list($db_link_id,$db_name)=$this->connect_db();
        $caller=$_SESSION['caller'];
        $https=$_SESSION['https'];
		session_destroy();
        session_start();
        $_SESSION['caller']=$caller;
        $_SESSION['https']=$https;
        $_SESSION['account_id']=$data['account_id'];
        $_SESSION['twostep']=$data['twostep'];
        $_SESSION['phone']=$data['phone'];
        $_SESSION['sso_id']=$data['sso_id'];
        if ($caller!=$_SERVER['SERVER_NAME']) {
            $_SESSION['fullname']=$data['fullname'];
            $_SESSION['facebook']=$data['facebook'];
            $_SESSION['email']=$data['email'];
        }
        
        session_regenerate_id(true);
		$query		="INSERT INTO $tbl_session VALUES(null,'".session_id()."', $data[account_id], 0,'$caller','$data[fullname]','$data[email]','$data[facebook]',NOW(),NOW(),'init','$_SESSION[photourl]')";
        $this->write_db($query, "slogin_login");
    return session_id();
	}

	function slogin_authorize ($session) {
		global $tbl_session;
		list($db_link_id,$db_name)=$this->connect_db();
        if (preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $session)) {
            $session=mysqli_real_escape_string($db_link_id,$session);
            $query="SELECT session_id,session,account_id,fullname,facebook,email,photourl FROM $tbl_session WHERE session='$session'";
            $result = mysqli_fetch_array($this->read_db($db_name,$query,$db_link_id));
            if ($result['account_id']) {
                $query="SELECT DATE_ADD(NOW(), INTERVAL $this->timeout_session MINUTE)";
                $buffer=$this->read_db($db_name, $query, $db_link_id);
                $timestamp=mysql_result($buffer,0);
                session_regenerate_id(true);
                $query="UPDATE $tbl_session SET time_stamp=NOW(),counter=counter+1 WHERE session_id='$result[session_id]'";
                $this->read_db($db_name, $query,$db_link_id);
            } else {$result['error']="InvalidToken";}
        } else {$result['error']="InvalidToken";}
		
	return $result;
	}

	function slogin_authenticate ($data) {
		global $tbl_account;
		list($db_link_id,$db_name)=$this->connect_db();
        $data['email']=mysqli_real_escape_string($db_link_id,$data['email']);
		$query="SELECT * FROM $tbl_account WHERE email='$data[email]'";
		$valid = mysqli_fetch_array($this->read_db($db_name,$query,$db_link_id));
        if (is_array($valid)) {
            $password=$this->slogin_package($data['email'],$data['password']);
			if ($password == $valid['pass']) {
				if ($valid['status']=="active") {
					$result=$valid;
					#--------------------------update counter and lastlogin
					$query="UPDATE LOW_PRIORITY $tbl_account SET last_login=NOW(), counter=counter+1 WHERE account_id =". $valid['account_id'];
					$this->write_db($query,"slogin_authenticate");
					
				} else {$result['error']="InactiveAccount";}
			} else {$result['error']="WrongPassword";}
		} else{$result['error']="WrongPassword";}
	return $result;
	}

	function slogin_package ($email, $password) {
		return hash("sha256", $this->hash . md5($password));
	}
}
?>