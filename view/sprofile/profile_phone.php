<h3><span>Verify via SMS</span></h3>
<div id="response_phone">
    <?echo $doc->form($_SERVER['SCRIPT_NAME'], $hidden, "","","iframer");?>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="maskedPhone">Phone</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                <input type="text" class="form-control" id="maskedPhone" name="phone" value="<?echo $data->phone;?>" disabled placeholder="08159999999">
            </div>
            <span class="help-block">Kami akan kirim SMS Kode Konfirmasi</span>
        </div>
    </div>    <div class="row">
        <div class="form-group pull-right">
            <button type="submit" class="btn btn-primary col-xs-12" value="editPhone" name="cmd">Edit</button>
        </div>
    </div>
    </form>
</div>

<h3><span>Two-Factor Authentication</span></h3>
<?if ($data->twostep=="inactive") {$disabled="disabled";}?>
<div id="response_twostep">
    <?echo $doc->form($_SERVER['SCRIPT_NAME'], $hidden, "","","iframer");?>
    <div class="form-group">
        <div class="radio">
            <input type="radio" name="twostep" id="twostep1" value="disabled" <?if ($data->twostep=="disabled") {?>checked<?}?> <?echo $disabled;?>>
            <label for="twostep1">
                Disabled
            </label>
        </div>
        <span class="help-block"><i class="icon-ok-sign"></i> Hanya menggunakan username dan password untuk login</span>
    </div>
    <div class="form-group">
        <div class="radio">
            <input type="radio" name="twostep" id="twostep2" value="once" <?if ($data->twostep=="once") {?>checked<?}?> <?echo $disabled;?>>
            <label for="twostep2">
                Once per IP
            </label>
        </div>
        <span class="help-block"><i class="icon-ok-sign"></i> Akan diminta memasukkan kode keamanan yang dikirim ke <i>handphone</i> melalui SMS. Kode diminta sekali untuk setiap ganti nomor IP (biasanya nomor IP berganti ketika pindah komputer/gadget atau restart modem)</span>
    </div>
    <div class="form-group">
        <div class="radio">
            <input type="radio" name="twostep" id="twostep3" value="always" <?if ($data->twostep=="always") {?>checked<?}?> <?echo $disabled;?>>
            <label for="twostep3">
                Always
            </label>
        </div>
        <span class="help-block"><i class="icon-ok-sign"></i> Akan selalu diminta kode keamanan ketika login. Kode keamanan dikirim ke <i>handphone</i> melalui SMS</span>
    </div>
    <?if ($data->twostep!="inactive") {?>
    <div class="row">
        <div class="form-group pull-right">
            <button type="submit" class="btn btn-primary col-xs-12" value="update2FA" name="cmd">Change</button>
        </div>
    </div>
    <?}?>
    </form>
</div>