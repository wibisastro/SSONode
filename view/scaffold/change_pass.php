    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeChange_<?echo $pageID;?>"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <form class="form-horizontal" action="<?echo $_SERVER['SCRIPT_NAME'];?>" method="post" role="form" id="validation-form" target="iframer" data-parsley-validate>
        <input type="hidden" name="<?echo $pageID;?>_id" value="" id="change_<?echo $pageID;?>_id" />
        <div class="modal-body">          
          Change password of this user:<br/>
          <h5 id="change_item"></h5>  

          <div class="form-group">
            <label for="password" class="col-md-2 control-label">Password</label>
            <div class="col-md-10">
              <input required type="text" name="password" class="form-control" id="form_password" value="">
            </div> 
          </div> 

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" value="changepass" name="cmd">Save</button>
        </div>
        </form>
      </div>
    </div>