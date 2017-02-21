<div id="response_bio">
<h3><span>Verify via Facebook</span></h3>
<div class="row">
    <div class="form-group">
        <?
        if (!$bio['bio_id']) {
            $permissions = ['email']; // optional
            //$loginUrl = $fbhelper->getLoginUrl('http://sso.gov2.web.id/sprofile.php?cmd=facebook', $permissions);
            ?>
            <div class="col-lg-6">
                <button type="button" class="btn btn-primary col-xs-12 btn-facebook" onclick="window.parent.location.href='<?//echo $loginUrl;?>'">
                    <i class="fa fa-facebook"></i> facebook
                </button>
            </div>
        <?} else {?>
            <div class="alert alert-success fade in" style="margin: 20px 0;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-check-circle fa-fw fa-lg"></i>
            <strong>Verified!</strong> Akun Anda telah diverifikasi dengan akun Facebook <?echo $bio["name"];?> pada tanggal <?echo $bio["formated_created_date"];?>
            </div>
            <div class="col-lg-6">
                <div class="clearfix">
                    <img class="profile-img center-block" alt="" src="<?echo $bio["photourl"];?>" title="<?echo $bio["name"];?>"/>
                </div>
                <button type="button" class="btn btn-primary col-xs-12 btn-facebook" onclick="window.parent.location.href='<?echo $bio["link"];?>'">
                    <i class="fa fa-facebook"></i> <?echo $bio["name"];?>
                </button>
            </div>
        <?}?>
    </div>
</div>

<h3><span>Full Name</span></h3>
    <?echo $doc->form($_SERVER['SCRIPT_NAME'], $hidden, "","","iframer");?>
    <?if ($bio["bio_id"]) {?>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="fbName">Nama dari Akun Facebook</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="radio" name="name_source" value="facebook" disabled>
                    </span>
                    <input type="text" class="form-control" id="fbName" name="fullname" value="<?echo $bio["name"];?>" disabled>
                </div>
                <span class="help-block">Pilih ini melalui radio button untuk meng<i>update</i> Nama Lengkap dari akun Facebook</span>
            </div>
        </div>
    <?}?>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="bioName">Nama Lengkap yang akan digunakan</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="radio" name="name_source" value="bio" checked disabled>
                </span>
                <input type="text" class="form-control" id="bioName" name="fullname" value="<?echo $data->fullname;?>" placeholder="<?echo $bio["name"];?>" disabled>
            </div>
            <span class="help-block"></span>
        </div>
    </div>
<?if ($_GET["tab"]=="bio") {?>
      <div class="alert alert-success fade in" style="margin: 20px 0;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-check-circle fa-fw fa-lg"></i>
        <strong>Tersimpan!</strong> Informasi Bio telah berhasil diperbaharui
      </div>
    <?}?>
<h3><span>Basic Bio</span></h3>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Jenis Kelamin</label>
            <div class="radio">
                <input type="radio" name="gender" id="optionsRadios1" value="laki-laki" <?if ($data->gender=="laki-laki") {?>checked<?}?> disabled>
                <label for="optionsRadios1">
                    Laki-laki
                </label>
            </div>
            <div class="radio">
                <input type="radio" name="gender" id="optionsRadios2" value="perempuan" <?if ($data->gender=="perempuan") {?>checked<?}?> disabled>
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
                    if ($y!="0") {?>value="<?echo $d;?>/<?echo $m;?>/<?echo $y;?>"<?}?> disabled>
            </div>
            <span class="help-block">ex. 23/07/1973</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group pull-right">
            <button type="submit" class="btn btn-primary col-xs-12" value="editBio" name="cmd">Edit</button>
        </div>
    </div>
    </form>
</div>

