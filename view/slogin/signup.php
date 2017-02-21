
<form  action="<?echo $_SERVER['SCRIPT_NAME'];?>" method="post" id="Login" name="Login" role="form" onsubmit="return Validator(this)" class="cssform">
  <div class="main-box-body clearfix">										
        <?if ($tab=="step1") {?>
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
                        <?}?>
                        <p align="center" style="color:#999">Registrasi</p>
                            <!--form class="login-form mt-lg" -->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text" maxlength="32" class="form-control" name="fullname" id="fullname" placeholder="Nama Lengkap Sesuai e-KTP">
                            </div>
                            <div class="input-group <?if ($doc->error) {?>has-error<?}?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="text" maxlength="64" class="form-control" name="email" id="email" placeholder="Alamat email sebagai username">
                            </div>
                            <div id="captcha-wrapper">
                              <div class="row">
                                <div class="col-xs-6" id="html_element">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary col-xs-12" value="<?echo $button?>" name="cmd">Register</button>
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
            if (!theForm.fullname.value)
            {
            alert("Field Nama Lengkap belum diisi");
            theForm.fullname.focus();
            return (false);
          }
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
                        <?}?>
                        <p align="center" style="color:#999">Masukkan Kode Aktifasi yang Anda terima dari email</p>
                            <!--form class="login-form mt-lg" -->
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-key"></i>
                                </span>
                                <input type="text" maxlength="40" class="form-control" name="act_code" id="act_code" placeholder="kode-aktifasi">
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
          if (!theForm.act_code.value)
          {
            alert("Kode Aktifasi belum diisi");
            theForm.act_code.focus();
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
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Berhasil!</strong> 
                        </div>
                        <?}?>
                        <p align="center" style="color:#999">Selamat Bergabung ke Platform Gov 2.0, akun ini dapat digunakan di semua Portal yang menggunakan Gov 2.0 Indonesia sebagai Login System.</p>                       
                            <div class="row">
                              <div class="col-xs-12">
                                <button type="button" class="btn btn-primary col-xs-12" onclick="parent.location.href='http://<?echo $_SESSION["caller"]?>/login.php'" name="cmd">Back to Login Page</button>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
      <?}?>
    </div>
</form>  