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
            <h4 align="center" style="color:#999">Two-Factor Authentication for <?echo $_SESSION['caller'];?></h4>
            <?if ($cmd != "blocked") {?>
                <form action="<?echo $_SERVER['SCRIPT_NAME'];?>" method="post" role="form">
                <?if ($doc->error && $doc->error!="Blocked") {?>
                    <div class="alert alert-danger fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                        <strong><?echo $doc->error;?></strong> <?echo $doc->txt($doc->error);?>    
                    </div>
                <?} elseif ($doc->error=="Blocked") {?>
                    <div class="alert alert-danger fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">◊</button>
                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                        <strong>Terblokir</strong> <?$datetime = new DateTime($data[hidden][attemp_time]);?>
                            Akun ini terblok karena 3 kali salah password pada: <?echo $datetime->format('d-M-Y H:i:s');?>. Silakan tunggu selama <?echo $data[hidden][wait_m];?> menit <?echo $data[hidden][wait_s];?> detik untuk dapat login kembali.
                    </div>
                <?}?>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" maxlength="64" class="form-control" name="fullname" id="fullname" placeholder="<?echo $_SESSION['fullname'];?>" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </span>
                    <input type="text" maxlength="6" class="form-control" name="code2fa" id="code2fa" placeholder="2FA Code">
                </div>
                <?if($_GET["ses_error"]){?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-times-circle sign"></i><strong><?echo "Salah kombinasi email atau password";?></strong><?if($data["hidden"]["fail"]){ echo ": Anda punya ".$data["hidden"]["fail"]." kesempatan lagi"; }?>
                </div>
                <?}?>
                <div id="captcha-wrapper">
                  <div class="row">
                    <div class="col-xs-6" id="html_element">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary col-xs-12" value="verify" name="cmd">Verify</button>
                  </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p class="pull-right" style="padding-top:20px">
                            Bukan <?echo $_SESSION['fullname'];?>? Tak Terima SMS? 
                        <a href="slogout.php?client=<?echo $_SERVER['SERVER_NAME'];?>" id="login-logout-link">
                          Logout!
                        </a>
                        </p>
                    </div>
                </div>
            <?} else {?>
            <div class="row">
              <div class="col-xs-12">
                <h3>Akun Anda diblok</h3>
                <p class="widget-login-info">
                  Silakan menunggu selama..
                </p>
              </div>
            </div>
          <?}?>
            </div>
          </form>
        </div>
          <div id="login-box-footer">
            <div class="row">
              <div class="col-xs-12">
                  Kode ini valid selama <span id="getting-started"></span>
              </div>
            </div>
          </div>        
      </div>
    </div>
  </div>
</div>

