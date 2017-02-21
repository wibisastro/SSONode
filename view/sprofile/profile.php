<div class="row" id="user-profile">
    <div class="col-lg-3 col-md-4 col-sm-4">
      <div class="main-box clearfix">
        <header class="main-box-header clearfix">
          <h2><?echo $data->fullname;?></h2>
        </header>    
        <div class="main-box-body clearfix">      
          <img src="<?if (!$bio["bio_id"]) {echo "images/user.png";} else {echo $bio["photourl"];}?>" alt="" width="100px" height="100px" class="profile-img center-block" />      
          <div class="profile-label">
            <span class="label label-danger"><?echo strtoupper($data->status);?></span>
          </div>
            <?
            $star=0;
         if ($data->star_email>0) $star++;
         if ($data->star_phone>0) $star++;
         if ($data->star_facebook>0) $star++;
         if ($data->star_payment>0) $star++;
         if ($data->star_ektp>0) $star++;            
            ?>
          <div class="profile-stars">
            <i class="fa fa-star<?if ($star<1) {echo "-o";}?>"></i>
            <i class="fa fa-star<?if ($star<2) {echo "-o";}?>"></i>
            <i class="fa fa-star<?if ($star<3) {echo "-o";}?>"></i>
            <i class="fa fa-star<?if ($star<4) {echo "-o";}?>"></i>
            <i class="fa fa-star<?if ($star<5) {echo "-o";}?>"></i>
            <span>User Level</span>
          </div>
          <div class="profile-details">
            <ul class="fa-ul">
              <li><i class="fa-li fa fa-truck"></i>Joined: <span><?echo $data->formated_date_inserted;?></span></li>
              <li><i class="fa-li fa fa-tasks"></i>Lastlogin: <span><?echo $data->formated_last_login;?></span></li>
              <li><i class="fa-li fa fa-comment"></i>Counter: <span><?echo $data->counter;?></span></li>
            </ul>
          </div>      
        </div> 
      </div>
    </div>

<div class="col-lg-9 col-md-8 col-sm-8">
<div class="main-box">
    <div class="main-box clearfix" style="min-height: 700px;">
        <div class="tabs-wrapper tabs-no-header">
            <ul class="nav nav-tabs">
                <li<?if (!$tab || $tab=="account") {?> class="active"<?}?>><a href="#tab-account" data-toggle="tab" onclick="if ('parentIFrame' in window) window.parentIFrame.size('max');">Account</a></li>
                <li<?if ($tab=="bio") {?> class="active"<?}?>><a href="#tab-bio" data-toggle="tab" onclick="if ('parentIFrame' in window) window.parentIFrame.size('max');">Bio</a></li>
                <li<?if ($tab=="phone") {?> class="active"<?}?>><a href="#tab-phone" data-toggle="tab" onclick="if ('parentIFrame' in window) window.parentIFrame.size('max');">Phone</a></li>
			<?/*?>
                <li<?if ($tab=="ektp") {?> class="active"<?}?>><a href="#tab-ektp" data-toggle="tab" onclick="if ('parentIFrame' in window) window.parentIFrame.size('max');">eKTP</a></li>
                <li<?if ($tab=="pay") {?> class="active"<?}?>><a href="#tab-pay" data-toggle="tab" onclick="if ('parentIFrame' in window) window.parentIFrame.size('max');">Pay</a></li>
                <?*/?>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade<?if (!$tab || $tab=="account") {?> in active<?}?>" id="tab-account">
                    <div id="response_alert_account"></div>
                    <?include(viwpath."/sprofile/profile_account.php");?>
                </div>
                <div class="tab-pane fade<?if ($tab=="bio") {?> in active<?}?>" id="tab-bio">
                    <div id="response_alert_bio"></div>
                    <div id="response_bio_form">
                    <?include(viwpath."/sprofile/profile_bio.php");?>
                    </div>
                </div>
                <div class="tab-pane fade<?if ($tab=="phone") {?> in active<?}?>" id="tab-phone">
                    <div id="response_alert_phone"></div>
                    <div id="response_phone_form">
                    <?include(viwpath."/sprofile/profile_phone.php");?>
                    </div>
                </div>
<?/*?>
                <div class="tab-pane fade<?if ($tab=="ektp") {?> in active<?}?>" id="tab-ektp">
                    <div id="response_alert_ektp"></div>
                    <?include(viwpath."/sprofile/profile_ektp.php");?>
                </div>
                <div class="tab-pane fade<?if ($tab=="pay") {?> in active<?}?>" id="tab-pay">
                    <div id="response_alert_pay"></div>
                    <?include(viwpath."/sprofile/profile_pay.php");?>
                </div>
                <?*/?>
            </div>
        </div>	
    </div>
</div>
</div>
</div>