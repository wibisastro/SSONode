<body onload="loadPage()">
<div id="responsePass">
    <?if (!$doc->error && !$val_msg) {?>
      <div class="alert alert-success fade in" style="margin: 20px 0;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-check-circle fa-fw fa-lg"></i>
        <strong>Berhasil!</strong> Password baru Anda telah diubah, mohon logout untuk login kembali dengan password yang baru.
      </div>
    <?} else {?>
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong><?echo $doc->error;?></strong> <?echo $doc->txt($doc->error);?><br />Perhatikan petunjuk warna merah pada field penyebab error. 
        </div>
    <?}?>

                    <?echo $doc->form($_SERVER['SCRIPT_NAME'], $hidden, "Validator(this);","","iframer");?>
                        <div class="row" id="login-box-inner">
                            <div class="input-group <?if ($doc->error=="WrongPassword") {?>has-error<?}?>" id="pass0box">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <input type="password" maxlength="16" class="form-control" name="password" id="password" placeholder="Password Lama">
                            </div>
                            &nbsp;
                            <div class="input-group" id="pass1box">
                                <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt"></i>
                                </span>
                                <input type="password" maxlength="16" class="form-control" name="pass1" id="pass1" placeholder="<?if (!$val_msg) {?>Ketik Password Baru<?} else {echo $val_msg;}?>">
                            </div>
                            &nbsp;
                            <div class="input-group" id="pass2box">
                                <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt"></i>
                                </span>
                                <input type="password" maxlength="16" class="form-control" name="pass2" id="pass2" placeholder="Ketik Ulang Password Baru">
                            </div>

                            <div class="form-group pull-right">
                                           &nbsp;
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="submit" class="btn btn-success" name="cmd" value="<?echo $button;?>">
                                </div>
                            </div>
                        </div>
                        <script>
                            <!--
                            function Validator(theForm) {
                              if (!theForm.password.value)
                              {
                                alert("Field Password belum diisi");
                                theForm.password.focus();
                                $("#pass0box").addClass('has-warning');
                                return (false);
                              }
                              if (theForm.pass1.value != theForm.pass2.value)
                              {
                                alert("Password Baru dan Password Ketik Ulang tidak sama. Ketik yang sama!");
                                theForm.pass2.focus();
                                $("#pass1box").addClass('has-warning');
                                $("#pass2box").addClass('has-warning');
                                return (false);
                              }
                              return (true);
                            }
                            -->
                        </script>
                    </form>
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
function loadPage() {
  if (window == parent) return;
  else {
	var responsePass=document.getElementById('responsePass').innerHTML;
    parent.document.getElementById('responsePass').innerHTML=responsePass;
  }
}
-->
</script>
</body>



