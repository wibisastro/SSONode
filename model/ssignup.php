<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/

class ssignup extends slogin {

	function ssignup_insert ($data) {
		global $tbl_account,$config,$mailgun;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
        $data['email']=mysqli_real_escape_string($db_link_id,$data['email']);
        $data['fullname']=mysqli_real_escape_string($db_link_id,$data['fullname']);
        $act_code=sha1($this->ssignup_passgen(6).$data['email']);
		$query = "INSERT INTO $tbl_account VALUES (null,0,'$act_code', '$data[fullname]','','0', '', '$data[email]', '', '', 0, 'pending', NOW(), NOW(),0,NOW(),'','1',0,0,'0','inactive')";
		$result['account_id']=$this->write_db($query, "ssignup_insert", $tbl_account, "account");
	
        include(viwpath."/slogin/mail_activation.php");
//				echo $bodymail;
        $mailgun->sendMessage($config->mailgun->domain, array('from' => 'noreply@cybergl.co.id', 
        'to'      => $data['email'], 
        'bcc'     => 'wibi@cybergl.co.id', 
        'subject' => 'Konfirmasi Akun SSO Node Bappenas', 
        'text'    => $bodymail
        ));
	return $result;
	}

	function ssignup_validate ($email) {
		global $tbl_account;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
        $email=mysqli_real_escape_string($db_link_id,$email);
        $regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$"; 
		if (preg_match('/'.$regex.'/',$email)) {
			$query="SELECT email FROM $tbl_account WHERE email='$email'";
			$owneremail=mysqli_fetch_array($this->read_db($db_name, $query, $db_link_id));
			if ($owneremail[email]) {$error="EmailExist";}
		} else {$error="InvalidEmail";}
	return $error;
	}

	function ssignup_activate ($acc_code) {
		global $tbl_account;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
        if (preg_match('/^[0-9a-f]{40}$/i', $acc_code)) {
            $query="SELECT * FROM $tbl_account WHERE pass='$acc_code'";
            $data=mysqli_fetch_object($this->read_db($db_name, $query,$db_link_id));
            if ($data->account_id) {
                if ($data->status == "pending") {
                    $query="UPDATE $tbl_account SET status='active', last_login=NOW() WHERE account_id='$data->account_id'";
                    $this->write_db($query,"ssignup_activate");
                    $this->ssignup_flush_password($data);
                } else {$error="NotPending";}
            } else {$error="CodeNotFound";}
        } else {$error="InvalidActCode";}
	return $error;
	}

	function ssignup_flush_password ($data) {
		global $tbl_account,$mailgun,$config;
		$newpass=$this->ssignup_passgen(6);	
 //       echo $newpass;
		$pass=$this->slogin_package($data->email,$newpass);
		$query="UPDATE $tbl_account SET pass='$pass', status='active' WHERE account_id='$data->account_id'";
		$this->write_db($query,"ssignup_flush_password");
		include(viwpath."/slogin/mail_resetpwd.php");
	//			echo $bodymail;
        $mailgun->sendMessage($config->mailgun->domain, array('from' => 'noreply@cybergl.co.id', 
        'to'      => $data->email, 
        'bcc'     => 'wibi@cybergl.co.id', 
        'subject' => 'Password Baru Anda', 
        'text'    => $bodymail
        ));
	return $data;
	}
 
	function ssignup_passgen ( $length = 6 ) {
           // consonant sounds
        $cons = array(
            // single consonants. Beware of Q, it's often awkward in words
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M',
            'n', 'p', 'r', 's', 't', 'v', 'w',
            'N', 'P', 'R', 'S', 'T', 'V', 'W',
            '$','!',
            '2','7','8','9',
            // possible combinations excluding those which cannot start a word
            'ng', 'kh', 'ny', 'ch', 'mp', 'mb', 'sy', 'tr','di','be','kr', 'ks',
        );

        // consonant combinations that cannot start a word
        $cons_cant_start = array(
            'kk', 'rb',
            'rp', 'rs',
            'rt','rl', 'rm',
            'rn', 'rw', 
            'rd', 'rg', 'rs', 'rt', 
        );

        // wovels
        $vows = array(
            // single vowels
            'a', 'e', 'i', 'o', 'u', 
            'A', 'E', 'I', 'O', 'U',             
            '1','4','3','@',
            // vowel combinations your language allows
            'oe', 'oo', 'eu', 'eo',
        );

        // start by vowel or consonant ?
        $current = ( mt_rand( 0, 1 ) == '0' ? 'cons' : 'vows' );

        $word = '';

        while( strlen( $word ) < $length ) {

            // After first letter, use all consonant combos
            if( strlen( $word ) == 2 )
                $cons = array_merge( $cons, $cons_cant_start );

             // random sign from either $cons or $vows
            $rnd = ${$current}[ mt_rand( 0, count( ${$current} ) -1 ) ];

            // check if random sign fits in word length
            if( strlen( $word . $rnd ) <= $length ) {
                $word .= $rnd;
                // alternate sounds
                $current = ( $current == 'cons' ? 'vows' : 'cons' );
            }
        }

        if (preg_match('/[a-zA-Z]/', $word) && preg_match('/\d/', $word)) {return $word;} 
        else {return $this->ssignup_passgen($length);} 
    }
}
?>
