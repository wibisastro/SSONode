<div id="nav-col">
  <section id="col-left" class="col-left-nano">
    <div id="col-left-inner" class="col-left-nano-content">
      <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
        <ul class="nav nav-pills nav-stacked">
          <li class="nav-header hidden-sm hidden-xs">
            <i class="fa fa-home"></i> Tools
              <?$menu=$doc->readxml("menu");?>
          </li>
        <?
        if (isset($menu)) {
            foreach ($menu->menu as $menuitem) {
            if (!$menuitem->type) {
            ?>
            <li <?if (basename($_SERVER['SCRIPT_NAME'])==basename($menuitem->url)){echo "class='active'";}?>>
                <a href="<?echo $menuitem->url;?>" target="_top">
                    <i class="fa <?if ($menuitem->icon) {echo $menuitem->icon;} else {echo "fa-file";}?>"></i>
                    <span><?echo $menuitem->caption;?></span>
                </a>
            </li>
            <?}}
        }?>
        </ul>
      </div>
    </div>
  </section>
  <div id="nav-col-submenu"></div>
</div>