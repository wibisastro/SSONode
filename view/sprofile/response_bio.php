<body onload="loadPage()">
<div id="response_bio">
    <?if ($doc->error) {?>
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong><?echo $doc->error;?></strong> <?echo $doc->txt($doc->error);?>
        </div>
    <?}?>

<h3><span>Full Name</span></h3>
    <?echo $doc->form($_SERVER['SCRIPT_NAME'], $hidden, "ValidatorBio(this)","","iframer");?>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="bioName">Nama Lengkap yang akan digunakan</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="radio" name="name_source" value="bio" checked>
                </span>
                <input type="text" class="form-control" id="bioName" name="fullname" value="<?echo $data->fullname;?>" placeholder="<?echo $bio["name"];?>">
            </div>
            <span class="help-block"></span>
        </div>
    </div> 
<h3><span>Basic Bio</span></h3>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Jenis Kelamin</label>
            <div class="radio">
                <input type="radio" name="gender" id="optionsRadios1" value="laki-laki" <?if ($data->gender=="laki-laki") {?>checked<?}?>>
                <label for="optionsRadios1">
                    Laki-laki
                </label>
            </div>
            <div class="radio">
                <input type="radio" name="gender" id="optionsRadios2" value="perempuan" <?if ($data->gender=="perempuan") {?>checked<?}?>>
                <label for="optionsRadios2">
                    Perempuan
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="maskedDate">Tanggal Lahir</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" name="birthday" class="form-control" id="maskedDate" <?
                    list($y,$m,$d)=explode("-",$data->birthday);
                    if ($y!="0") {?>value="<?echo $d;?>/<?echo $m;?>/<?echo $y;?>"<?}?>>
            </div>
            <span class="help-block">ex. 23/07/1973</span>
        </div>
    </div>     
    <div class="row">
        <div class="form-group pull-right">
            <button type="submit" class="btn btn-primary col-xs-12" value="updateBio" name="cmd">Update</button>
        </div>
    </div>
    </form>
</div>

<script>
    <!--
    function ValidatorBio(theForm) {
      if (!theForm.fullname.value)
      {
        alert("Field Nama Lengkap belum diisi");
        theForm.fullname.focus();
        $("#bioName").addClass('has-warning');
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
	var response=document.getElementById('response_bio').innerHTML;
    parent.document.getElementById('response_bio').innerHTML=response;
    parent.maskedBirthday();
  }
}
-->
</script>
</body>



