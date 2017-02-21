<div class="main-box clearfix" style="min-height: 820px;">
<form  action="<?echo $_SERVER['SCRIPT_NAME'];?>" method="post" id="Login" name="Login" onsubmit="return Validator(this)" class="cssform">
  <div class="main-box-body clearfix">										
      <div class="row">
        <?if ($tab=="step1") {?>
            <div id="login-box">
              <div id="login-box-holder">
                <div class="row">
                  <div class="col-xs-12">
                    <header id="login-header">
                      <div id="login-logo">
                        <!-- <img src="images/slogo.png" alt=""/> -->
                      </div>            
                    </header>
                    <div id="login-box-inner" class="with-heading">
                        <?if($doc->error){?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-times-circle sign"></i><strong><?echo $doc->error;?></strong> 
                            <?echo $doc->txt($doc->error);?>
                        </div>
                        <?}?>
                        <p align="center" style="color:#999">Reset Password</p>
                            <!--form class="login-form mt-lg" -->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text" maxlength="32" class="form-control" name="email" id="email" placeholder="email">
                            </div>
                            <div id="captcha-wrapper">
                              <div class="row">
                                <div class="col-xs-6" id="html_element">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary col-xs-12" value="<?echo $button?>" name="cmd">Submit</button>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        <script>
        <!--
        function Validator(theForm) {
          if (!theForm.email.value)
          {
            alert("Field Email belum diisi");
            theForm.email.focus();
            return (false);
          }
          return (true);
        }
        -->
        </script>
        <?}?>
    

         <?if ($tab=="step2") {?>     
          <div id="login-box">
              <div id="login-box-holder">
                <div class="row">
                  <div class="col-xs-12">
                    <header id="login-header">
                      <div id="login-logo">
                        <img src="images/slogo.png" alt=""/>
                      </div>            
                    </header>
                    <div id="login-box-inner" class="with-heading">
                        <?if($doc->error){?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-times-circle sign"></i><strong><?echo $doc->error;?></strong> 
                                <?echo $doc->txt($doc->error);?>
                            </div>
                        <?} else {?>
                            <div class="alert alert-success fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">◊</button>
                                <i class="fa fa-check-circle fa-fw fa-lg"></i>
                                <strong>Terkirim!</strong> Permintaan reset password sudah dikirim ke <b><?echo $_POST['email'];?></b>. Silahkan catat ID Reset Password pada email tersebut dan kembali ke sini untuk Konfirmasi.
                            </div>
                        <?}?>
                            <h4>Konfirmasi Reset Password</h4>
                            <p align="center" style="color:#999">Silahkan masukkan nomor ID Permintaan Reset Passwod pada form di bawah ini kemudian klik tombol Submit</p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-key"></i>
                                </span>
                                <input type="text" maxlength="16" class="form-control" name="confirm_code" id="confirm_code" placeholder="confirm_code">
                            </div>
                            <div id="captcha-wrapper">
                              <div class="row">
                                <div class="col-xs-6" id="html_element">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary col-xs-12" value="<?echo $button?>" name="cmd">Submit</button>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
        <script>
        <!--
        function Validator(theForm) {
          if (!theForm.confirm_code.value)
          {
            alert("Kode Konfirmasi belum diisi");
            theForm.confirm_code.focus();
            return (false);
          }
          return (true);
        }
        -->
        </script>
        <?}?>

        <?if ($tab=="step3") {?>      
          <div id="login-box">
              <div id="login-box-holder">
                <div class="row">
                  <div class="col-xs-12">
                    <header id="login-header">
                      <div id="login-logo">
                        <img src="images/slogo.png" alt=""/>
                      </div>            
                    </header>
                    <div id="login-box-inner" class="with-heading">
                        <?if($doc->error){?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-times-circle sign"></i><strong><?echo $doc->error;?></strong> 
                                <?echo $doc->txt($doc->error);?>
                            </div>
                        <?} else {?>
                            <div class="alert alert-success fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">◊</button>
                                <i class="fa fa-check-circle fa-fw fa-lg"></i>
                                <strong>Berhasil!</strong> Password baru sudah dikirim. Silahkan Login dengan menggunkana Password Anda yang baru.
                            </div>
                        <?}?>
                            <div class="row">
                              <div class="col-xs-12">
                                <button type="button" class="btn btn-primary col-xs-12" onclick="location.href='slogin.php?client=<?echo $_SESSION["caller"]?>'" name="cmd">Back to Login Page</button>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
          
        <?}?>
        </div>
    </div>
    </div>      
</form>  
</div>