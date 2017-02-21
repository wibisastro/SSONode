<h3><span>Verify via Email</span></h3>
<div class="form-group">
    <label for="email">Email</label>
    <input class="form-control" id="email" type="text" placeholder="<?echo $data->email;?>" disabled>
</div>

<h3><span>Change Password</span></h3>
    <div id="responsePass">
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
                        <input type="submit" class="btn btn-primary" name="cmd" value="Change">
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
<h3><span>Password Sync Authorization Request</span></h3>
<div class="row">
    <div class="col-xs-12">
        <?if (!is_array($passsync_req)) {?>
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-info-circle fa-fw fa-lg"></i>
                <strong>NoRequest</strong> Tidak Ada Permintaan Otorisasi   
            </div>
        <?} else {
            foreach($config->storage as $storage) {
                if ($storage->domain==$passsync_req['domain']) {
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12" id="request_<?echo $passsync_req['passsync_id'];?>">
                    <div id="request_<?echo $passsync_req['passsync_id'];?>_response"></div>
                    <?echo $doc->form($_SERVER['SCRIPT_NAME'], array("passsync_id"=>$passsync_req['passsync_id']), "ValidatorAuthReq_".$passsync_req['passsync_id']."(this);","","iframer");?>
                    <?include(viwpath."/passsync/app_".$passsync_req['app'].".php");?>
                    </form>
                <script>
                <!--
                    function ValidatorAuthReq_<?echo $passsync_req['passsync_id'];?>(theForm) {
                      if (!theForm.password_<?echo $passsync_req['passsync_id'];?>.value)
                      {
                        alert("Field Password belum diisi");
                        theForm.password_<?echo $passsync_req['passsync_id'];?>.focus();
                        $("#password_<?echo $passsync_req['passsync_id'];?>_box").addClass('has-warning');
                        return (false);
                      }
                    }
                    -->
                </script>
                </div>
            <?}}
        }?>
    </div>
</div>

<h3><span>Account access-control XML</span></h3>
        <pre><textarea class="form-control" disabled rows="15">
<member>
    <account_id><?echo $data->account_id;?></account_id>
    <status><?echo $data->status;?></status>
    <fullname><?echo $data->fullname;?></fullname>
    <facebook><?echo $data->facebook;?></facebook>
    <privilege controller="/restricted.php">
        <case>baca</case>
    </privilege>
</member></textarea></pre>
