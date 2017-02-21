<div class="row">
  <div class="col-lg-12">
    <div class="main-box clearfix" id="table_<?echo $pageID;?>">
        <header class="main-box-header clearfix">
            <!-- <h2 class="pull-left">Records (<?echo count($data);?>)</h2> -->

            <div class="filter-block pull-right">
                <div class="form-group pull-left" style="margin-bottom:0px;">
                    <input type="text" id="filter" class="form-control" placeholder="Search...">
                    <i class="fa fa-search search-icon"></i>
                </div>
            </div>
        </header>

        
      <div id="response_alert_<?echo $pageID;?>"></div>
      
      <div class="main-box-body clearfix">        
        <?include(viwpath."/$pageID/table.php");?>
      </div>      
    </div>
  </div>
</div>

<!--modal remove-->
  <div class="modal fade" id="remove<?echo $pageID;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <?include(viwpath."/scaffold/remove.php");?>
  </div>
  <!--end modal-->

  <!--change pass-->
  <div class="modal fade" id="change<?echo $pageID;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <?include(viwpath."/scaffold/change_pass.php");?>
  </div>

  <!--reset pass-->
  <div class="modal fade" id="reset<?echo $pageID;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <?include(viwpath."/scaffold/reset_pass.php");?>
  </div>
  
<!--modal for form-->  
  <?include(viwpath."/$pageID/form.php");?>
</div>