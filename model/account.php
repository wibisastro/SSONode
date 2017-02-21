<?
/********************************************************************
*	Date		: 17 Nov 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: eGov Lab UI 
********************************************************************/

class account extends slogin {
	
    function account_browse() {
    	global $tbl_account;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT * FROM $tbl_account order by account_id";
		$daftar = $this->read_db($db_name, $query,$db_link_id) or die("browse: ".mysqli_error($db_link_id));
        $c=0;
		while ($buffer = mysqli_fetch_object($daftar)) {$result[$c]=$buffer;$c++;}
	return $result;
	}

    function account_read ($account_id) {
		global $tbl_account;
        $account_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT * FROM $tbl_account WHERE account_id=$account_id";
		$buffer=$this->read_db($db_name, $query,$db_link_id) or die("account_read: ".mysqli_error($db_link_id));
		$result=mysqli_fetch_object($buffer);
	return $result;
	}

    function account_add($data) {
	    global $tbl_account;
	    $data["account_id"]+=0;
	    $data["parent"]+=0;
	    if (!$_SESSION['active_client']){
	    	$domain=$_SERVER["SERVER_NAME"];
	    	$portal=$this->check_kementerian($_SERVER["SERVER_NAME"]);
	    } else {
	    	$domain=$_SESSION['active_client'];
	    	$portal=$this->check_kementerian($_SESSION['active_client']);
	    }  
	    $query ="INSERT INTO $tbl_account VALUES(null, $data[parent], '$data[level]', '$data[status]','$data[nama]','$domain',$portal->kementerian_id, 0, $data[account_id])";
	    
	    $id=$this->write_db($query,"account_add",$tbl_account);
	      return $id;
	}

	function account_remove($data) {    
	    global $tbl_account;
	    $data[account_id]+=0;
	    $query ="DELETE FROM $tbl_account WHERE account_id=$data[account_id]";
	    //echo $query;
	    $this->write_db($query,"account_del");
	}  

	function account_update($data,$account_id) {    
	    global $tbl_account;
	    $account_id+=0;
	    $query ="UPDATE $tbl_account SET status='$data[status]'
	    WHERE account_id=$account_id";
	    $this->write_db($query,"account_update");
	  }

	function account_history ($account_id) {
		global $tbl_account;
        static $c;
		$account_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT account_id,parent,nama FROM $tbl_account WHERE account_id=$account_id";
		//echo $query;
		$buffer=mysqli_fetch_object($this->read_db($db_name,$query,$db_link_id));
        $c++;
		$this->history[$c]=$buffer;
		if ($buffer->parent>0){$this->account_history($buffer->parent);}
	}

	function account_history_path ($data) {
		global $doc;
		krsort($data);
		$result="<div class=\"navpath\">&nbsp;<a href=\"".$_SERVER[SCRIPT_NAME]."\">KEGIATAN KL</a> <i class=\"fa fa-angle-double-right\"></i> ";
        $c=1;
		while (list($key,$val)=each($data)) {
			if ($val->account_id && $c < sizeof($data)) {$result.=$doc->lnk($_SERVER['SCRIPT_NAME']."?parent=$val->account_id",$val->nama)." <i class=\"fa fa-angle-double-right\"></i> ";}
            else {$result.=$val->nama;}
            $c++;
		}
		$result.="</div>";
	return $result;
	}
    
  	function account_confirm_delete ($account_id) {
		global $tbl_account;
      	$account_id+=0;
		list($db_link_id,$db_name)=$this->connect_db();
		$query="SELECT account_id AS upper FROM $tbl_account WHERE parent=$account_id";
		$result = mysqli_fetch_object($this->read_db($db_name, $query,$db_link_id));
	return $result; 
	}

	function account_changepass ($data) { 
		global $tbl_account;
		list($db_link_id,$db_name, $db_server)=$this->connect_db();
		$query="SELECT * FROM $tbl_account WHERE account_id='$data[account_id]'";
		$valid = mysqli_fetch_object($this->read_db($db_name,$query,$db_link_id));

		$pass=$this->slogin_package($valid->email,$data["password"]);
		$query="UPDATE $tbl_account SET pass='$pass' WHERE account_id='$data[account_id]'";
//		echo $query;
		$this->write_db($query,"update_pass");
	return $error;
	}
}
?>