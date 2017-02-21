  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeForm_<?echo $pageID;?>"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="form_header">Add New Data</h4>
      </div>
      <form action="<?echo $_SERVER['SCRIPT_NAME'];?>" method="post" role="form" id="validation-form" target="iframer" data-parsley-validate>
        <input type="hidden" name="<?echo $pageID;?>_id" value="<?echo $edit->{$pageID.'_id'}?>" id="form_<?echo $pageID;?>_id">
        <input type="hidden" name="no" id="<?echo $pageID;?>_no">
        <input type="hidden" name="parent" value="<?echo $_GET['parent'];?>" id="form_parent">
      <div class="modal-body"> 
        <div class="form-group">
            <label for="form_type">Type</label>
            <select class="form-control" name='type' id='form_type'>
                <?$types=array("directory","service");?>
                <?while (list($key,$val)=each($types)) {?>
                <option value="<?echo $val;?>"><?echo $val;?></option>
                <?}?>
            </select>
        </div> 
        <div class="form-group">
          <label for="icon">Icon</label>
          <input type="text" name="icon" class="form-control" id="form_icon" value="">
        </div> 
        <div class="form-group">
            <label for="form_status">Status</label>
            <select class="form-control" name='status' id='form_status'>
                <?$statuses=array("pending","active","suspended");?>
                <?while (list($key,$val)=each($statuses)) {?>
                <option value="<?echo $val;?>"><?echo $val;?></option>
                <?}?>
            </select>
        </div> 
        <div class="form-group">
          <label for="caption">Service Name</label>
          <input type="text" name="caption" class="form-control" id="form_caption" value="">
        </div> 
        <div class="form-group">
          <label for="link">Service URL</label>
          <input type="text" name="link" class="form-control" id="form_link" value="">
        </div> 
        <div class="form-group">
          <label for="v_order">Order</label>
          <input type="text" name="v_order" class="form-control" id="form_v_order" value="">
        </div> 
        <div class="form-group">
          <label for="apikey">API Key</label>
          <input type="text" name="apikey" class="form-control" id="form_apikey" value="">
        </div> 
        <div class="form-group">
          <label for="parent">Parent</label>
          <input type="text" name="parent" class="form-control" id="form_parent" value="">
        </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="form_reset" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" value="add" name="cmd" id="button_<?echo $pageID;?>">Submit</button>
      </div>
      </form>
    </div>
  </div>