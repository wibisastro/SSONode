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
            <h4 align="center" style="color:#999">Login to <?echo $_SESSION['caller'];?></h4>
            <?if ($doc->error && $doc->error!="Blocked") {?>
                <div class="alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">◊</button>
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
            <?if ($cmd != "blocked") {?>
                <form action="<?echo $_SERVER['SCRIPT_NAME'];?>" method="post" role="form">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" maxlength="64" class="form-control" name="email" id="email" placeholder="email">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </span>
                    <input type="password" maxlength="16" class="form-control" name="password" id="password" placeholder="password">
                </div>
                <?if($_GET["ses_error"]){?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-times-circle sign"></i><strong><?echo "Salah kombinasi email atau password";?></strong><?if($data["hidden"]["fail"]){ echo ": Anda punya ".$data["hidden"]["fail"]." kesempatan lagi"; }?>
                </div>
                <?}?>
                <div class="row">
                    <div class="col-xs-12">
                    <a href="spassword.php" id="login-forget-link" class="pull-right">
                      Lupa Password?
                    </a>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div id="captcha-wrapper">
                  <div class="row">
                    <div class="col-xs-6" id="html_element">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary col-xs-12" value="login" name="cmd">Login</button>
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
      </div>
    </div>
  </div>
  
  <div id="login-box-footer">
    <div class="row">
      <div class="col-xs-12">
          <p>
            Belum Punya Akun Gov 2.0? 
            <a href="ssignup.php?client=<?echo $_SERVER["SERVER_NAME"];?>">
              Silahkan Mendaftar!
            </a>
          </p>
          <p>
            Akun Belum Aktif? 
            <a href="ssignup.php?cmd=activation&client=<?echo $_SERVER["SERVER_NAME"];?>">
              Silahkan Aktifkan!
            </a>
          </p>
      </div>
    </div>
  </div>
</div>