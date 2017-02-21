<footer id="footer-bar" class="row">
    <div id="footer-copyright" class="col-xs-12">
        <div class="pull-left">
    <?if ($data->link) {?>
      <a href="http://<?echo parse_url($data->link, PHP_URL_HOST);?>" target="_top">
        <i class="fa fa-home"></i> <?echo $_SERVER['SERVER_NAME'];?> 
          <i class="fa fa-exchange" id="cloud_connector"></i> 
          <?echo parse_url($data->link, PHP_URL_HOST);?> <i class="fa fa-cloud"></i>
      </a>
    <?} else {?>
      <a class="" href="http://<?echo $_SERVER['SERVER_NAME'];?>" target="_top">
        <i class="fa fa-home"></i> <?echo $_SERVER['SERVER_NAME'];?>
      </a>
    <?}?>
        </div>
        <div class="pull-right">           
            &nbsp;
        </div>
    </div>
</footer>