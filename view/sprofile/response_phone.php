<body onload="loadPage()">
<div id="response_phone">
    <?if (!$doc->error && !$val_msg) {?>
      <div class="alert alert-success fade in" style="margin: 20px 0;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-check-circle fa-fw fa-lg"></i>
        <strong>Tersimpan!</strong> Kami akan kirim SMS Kode Konfirmasi setelah klik Update
      </div>
    <?} else {?>
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong><?echo $doc->error;?></strong> <?echo $doc->txt($doc->error);?>
        </div>
    <?}?>
<?echo $doc->form($_SERVER['SCRIPT_NAME'], $hidden, "ValidatorPhone(this);","","iframer");?>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="maskedPhone">Phone</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                <input type="text" class="form-control" id="maskedPhone" name="phone" placeholder="08159999999" value="<?echo $data->phone;?>">
            </div>
            <span class="help-block">Masukkan hanya angka, tanpa tanda baca atau spasi</span>
        </div>
    </div>    <div class="row">
        <div class="form-group pull-right">
            <button type="submit" class="btn btn-success col-xs-12" value="updatePhone" name="cmd">Update</button>
        </div>
    </div>

<script>
    <!--
    function ValidatorPhone(theForm) {
      if (!theForm.phone.value)
      {
        alert("Field Phone belum diisi");
        theForm.phone.focus();
        $("#maskedPhone").addClass('has-warning');
        return (false);
      }
      return (true);
    }
    -->
</script>
</form>
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
function loadPage() {
  if (window == parent) return;
  else {
	var response=document.getElementById('response_phone').innerHTML;
    parent.document.getElementById('response_phone').innerHTML=response;
  }
}
-->
</script>
</body>



