        <table class="table filter_<?echo $pageID;?> footable toggle-circle-filled" data-page-size="12" data-filter="#filter" data-filter-text-only="false">
          <thead>
            <tr>
              <th data-type="numeric">No.</th>
              <th data-sort-ignore="true">AccountID</th>
              <th data-sort-ignore="true">Nama</th>
              <th data-sort-ignore="true">email</th>
              <th data-sort-ignore="true">status</th>
              <?if (!$_SESSION['active_client']) {?>
              <th data-sort-ignore="true"></th>
                <?} else {?>
              <th data-sort-ignore="true"></th>
                <?}?>
            </tr>
          </thead>
          <tbody id="append_<?echo $pageID;?>">
            <?
             $c=0;
             if (sizeof($data) > 0) {
              while (list($key, $val)=each($data)) {
            ?>
            <tr id="row_<?echo $pageID;?>_<?echo $val->{$pageID."_id"};?>">
            <?include(viwpath."/$pageID/row.php");?>
            </tr>
            <?$c++;}}?>
          </tbody>
        </table>
        <ul class="pagination pull-right hide-if-no-paging"></ul>
        <!--<div class="pull-left">
            <a href="http://<?echo $_SERVER['SERVER_NAME'];?>/api.php?cmd=kegiatankl&parent=<?echo $_GET["parent"]+0;?>" target="_blank">
             <i class="fa fa-cubes"></i> http://<?echo $_SERVER['SERVER_NAME'];?>/api.php?cmd=kegiatankl&parent=<?echo $_GET["parent"]+0;?>      
            </a>
        </div> -->
<script>
function return_get(key) {
    if ('parentIFrame' in window) window.parentIFrame.sendMessage('get_key,'+key);
    return false;
}
</script>