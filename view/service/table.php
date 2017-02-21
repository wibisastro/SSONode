        <div class="row"><?echo $main->history_path($main->history);?></div>
        <table class="table filter_<?echo $pageID;?> footable toggle-circle-filled" data-page-size="12" data-filter="#filter" data-filter-text-only="false">
          <thead>
            <tr>
              <th data-type="numeric">No.</th>
              <th data-type="numeric" data-hide="phone">Parent</th>
              <th data-type="numeric">ID</th>
              <th data-sort-ignore="true">Name</th>
              <th data-hide="phone" data-sort-ignore="true">URL</th>            
              <th data-hide="all" data-sort-ignore="true">API Key</th>        
              <th class="text-center" data-sort-ignore="true">Status<br />
                 <select class="filter-status" id="filter_status">
                    <option></option>
                    <option value="status_pending">pending</option>
                    <option value="status_active">active</option>
                    <option value="status_suspended">suspended</option>
                  </select>
              </th>         
              <th data-hide="phone,tablet">Date</th>    
              <th data-hide="phone">v_order</th>
            </tr>
          </thead>
          <tbody id="append_<?echo $pageID;?>">
            <?
             $c=1;
             if (sizeof($data) > 0) {
              while (list($key, $val)=each($data)) {
            ?>
            <tr id="row_<?echo $pageID;?>_<?echo $val->{$pageID."_id"};?>">
            <?include(viwpath."/$pageID/row.php");?>
            </tr>
            <?$c++;}}?>
          </tbody>
        </table>
