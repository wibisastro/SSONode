<?if (!$_SESSION['active_client'] || ($_SESSION['active_client'] && basename($_SERVER['SCRIPT_NAME'])=='cloud.php')) {$fullpage=true;}?>
<!DOCTYPE html>
<html lang="en">
<?include (viwpath."/general/header.php");?>
<body class="theme-whbl <?if ($fullpage) {?>fixed-footer fixed-header<?}?>">
<iframe id="iframer" name="iframer" src="" frameborder="1" style="display:<?if ($_GET['debug']) {echo "inline";} else {echo "none";}?>" width="300" height="200"></iframe>
  <div id="theme-wrapper">
  <?if ($fullpage) include (viwpath."/general/topbar.php");?>
    <div id="page-wrapper" class="container">
      <div class="row">
      <?if ($fullpage) include (viwpath."/general/sidebar.php");?>
          <!--content-->
          <div id="content-wrapper">
            <div class="row">
              <div class="col-lg-12">
                <?
                if (is_array($doc->content) && !$doc->error)  {
                    if (!$_SESSION['active_client']) include(viwpath."/general/titlebar.php");
                    while (list($key,$val)=each($doc->content)) {
                        if ($val && file_exists($val)) {include($val);}
                        else {echo $val;}
                    }
                } elseif (!$doc->error  && !$doc->content) {?>
                    <header class="main-box-header clearfix">
                        <h1>Under Development</h1>
                    </header> 
                <?} elseif (!$doc->error && $doc->content) {?>
                    <h1>Var Dump Page</h1>
                    <div class="main-box clearfix">
                        <header class="main-box-header clearfix">
                            <h1><?echo strip_tags($cmd);?></h1>
                        </header>
                        <div class="main-box-body clearfix">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?echo $doc->content;?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?} else {?>
                    <h1>Error</h1>
                    <div class="main-box clearfix">
                        <header class="main-box-header clearfix">
                            <h1><?echo $doc->error;?></h1>
                        </header>
                        <div class="main-box-body clearfix">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?echo $doc->error_message;?>
                                    <p>
                                        <a href="index.php">Back to Home</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}?>
              </div>
            </div>		
          </div> 
        <?if ($fullpage) include (viwpath."/general/bottombar.php");?>
  		</div>
	</div>
  </div>
    <?include (viwpath."/general/footer.php");?>
</body>
</html>