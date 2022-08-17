<style>
.dropdown-container {
    display: none;
    background-color: transparent;
    padding-left: 30px !important;
    padding-bottom: 0px !important;
}
/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
    padding-right: 0px;
    position: relative;
    top: 6px;
}
.dropdown-btn {
    display: inline-block;
    border: none;
    background: none;
    width: 80%;
    text-align: left;
    cursor: pointer;
    outline: none;
}
.dashboard-sidebar .dashboard-menu ul li:hover a, .dashboard-sidebar .dashboard-menu ul li.active a {
    background-image: none !important;
}

</style>

<div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12 mb30">
    <div class="dashaboard-leftbar">
        <div class="dashboard-sidebar">
            <div class="user-info">
                <a href="#" class="d-flex">
                    <div class="user-body">
                        <h5><?php echo $this->session->userdata('full_name');  ?></h5>
                        <span><?php echo $this->session->userdata('email');  ?></span>
                    </div>
                </a>
            </div>
            <div class="dashboard-menu">
                <ul>
                    <li id="dashboard-li"><i class="fas fa-home"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('dashboard'); ?>`)">Dashboard</a></li>
                    <?php if(MainPermission(2)){ ?>
                    <li id="dsa-li"><i class="fas fa-file-alt"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('dsa'); ?>`)">Partner Report</a></li>
                    <?php } ?>
                    <?php if(MainPermission(3)){ ?>
                    <li id="lender-li"><i class="fas fa-file-alt"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('lender'); ?>`)">Lenders Report</a></li>
                    <?php } ?>
                    <?php if(MainPermission(4)){ 
                         $reportP="";
                         if(SubPermission(1)){
                             $reportP="";
                         }elseif(SubPermission(2)){
                             $reportP="?type=incomplete";
                         }elseif(SubPermission(5)){
                             $reportP="?type=assigned";
                         }
                    ?>
                    <li id="merchant-li"><i class="fas fa-user"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('merchant'.$reportP); ?>`)" >Cases Report</a></li>
                    <?php } ?>
                    <?php if(MainPermission(5)){ ?>
                        <li id="reports-li" class="dropdown"><i class="fas fa-user"></i>
                            <a href="javascript:void(0)" class="dropdown-btn" data-toggle="reports-li">Reports <i class="fa fa-caret-down"></i></a>
                            <ul class="dropdown-container">
                                <li id="report-cases-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('report/merchant'); ?>`)" >Cases Report</a></li>
                                <li id="report-partnerwise-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('dsa'); ?>`)" >Partner Wise Report</a></li>
                                <li id="report-lenderwise-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('lender'); ?>`)">Lender Wise Report</a></li>
                                <li id="report-disbursed-li"><a href="<?php echo admin_url('excel/download_disbursed'); ?>" download>Disbursed Report</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if(MainPermission(6)){ ?>
                    <li id="builder-li"><i class="fas fa-user"></i><a  href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('querybuilder'); ?>`)">Query Builder</a></li>
                    <?php } ?>
                    <?php if(MainPermission(7)){ ?>
                    <li id="profile-li"><i class="fas fa-users"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('profile'); ?>`)" >Profile</a></li>
                    <?php } ?>
                    <!--li id="change-password-li"><i class="fas fa-lock"></i><a href="<?php // echo admin_url('profile/change_password'); ?>">Change Password</a></li-->
                    <?php if(MainPermission(8)){ ?>
                    <?php $logcount=$this->common_model->CountResults('login_log',['is_read'=>0]); ?>
                    <li id="loginlog-li"><i class="fas fa-bell"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('loginlog'); ?>`)" >Log <?php if($logcount>0){ echo '<span class="badge badge-primary">'.$logcount.'</span>'; } ?></a></li>
                    <?php } ?>
                    <?php if(MainPermission(9)){ ?>
                        <?php $casecount=$this->common_model->CountResults('case_log',['is_read'=>0]); ?>
                        <li id="caselog-li"><i class="fas fa-bell"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('log/case'); ?>`)" >Notification <?php if($casecount>0){ echo '<span class="badge badge-primary">'.$casecount.'</span>'; } ?></a></li>
                    <?php } ?>
                    <?php if(MainPermission(10)){ ?>
                    <li id="followup-li"><i class="fas fa-bell"></i><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('followup'); ?>`)" >Follow Up</a></li>
                    <?php } ?>
                    <?php if(MainPermission(11)){ ?>
                    <li id="setting-li" class="dropdown"><i class="fas fa-cog"></i>
					<a href="javascript:void(0)" class="dropdown-btn" data-toggle="dropdown">Setting <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-container">
                            <li id="setting-state-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('setting/state'); ?>`)" >State</a></li>
                            <li id="setting-city-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('setting/city'); ?>`)" >City</a></li>
                            <li id="setting-pincode-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('setting/pincode'); ?>`)">Pincode</a></li>
                             <li id="setting-status-li"><a href="javascript:void(0)" onclick="RedirectPage(`<?php echo admin_url('setting/status'); ?>`)">Incomplete Status</a></li>
                        </ul>
                        
                    </li>
                    <?php } ?>
                    <!-- <li id="dropout-li"><i class="fas fa-users"></i><a href="<?php //echo admin_url('report/dropout'); ?>">Dropout Report</a></li> -->
                </ul>
                <ul class="delete">
                    <li><i class="fas fa-power-off"></i><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}
</script>
