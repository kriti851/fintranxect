<div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12 mb30">
    <div class="dashaboard-leftbar">
        <div class="dashboard-sidebar">
            <div class="user-info">
                <a href="<?php echo dsa_url('profile'); ?>" class="d-flex">
                    <div class="user-body">
                        <h5><?php echo $this->session->userdata('full_name');  ?></h5>
                        <h5>ID: <span><?php echo $this->session->userdata('file_id');  ?></span></h5>
                        <span><?php echo $this->session->userdata('email');  ?></span>
                    </div>
                </a>
            </div>
            <div class="dashboard-menu">
                <ul>
                    <li class="active"><i class="fas fa-home"></i><a onclick="RedirectPage(`<?php echo dsa_url('dashboard'); ?>`)" href="javascript:void(0)">Dashboard</a></li>
                    <!-- <li><i class="fas fa-home"></i><a href="<?php //echo dsa_url('dashboard/new'); ?>">New Dashboard</a></li> -->
                    <?php if(MainPermission(7)){ ?>
                    <li><i class="fas fa-link"></i><a href="#" onclick="show_link()">Public Cases URL</a></li>
                    <?php } ?>
                    <?php if(MainPermission(4)){ ?>
                    <li><i class="fas fa-user"></i><a onclick="RedirectPage(`<?php echo dsa_url('profile'); ?>`)" href="javascript:void(0)">Profile</a></li>
                    <?php } ?>
                    <?php if(MainPermission(2)){ 
                        $query="";
                        if(!SubPermission(1)){
                            $query='?type=incomplete';
                        }
                    ?>
                    <li><i class="fas fa-list"></i><a onclick="RedirectPage(`<?php echo dsa_url('merchant'.$query); ?>`)" href="javascript:void(0)" >Cases</a></li>
                    <?php } ?>
                    <?php if(MainPermission(5)){ ?>
                    <li><i class="fas fa-list"></i><a onclick="RedirectPage(`<?php echo dsa_url('report/merchant'); ?>`)" href="javascript:void(0)" >Report</a></li>
                    <?php } ?>
                    <?php if($this->session->userdata('user_type')=='DSA'){ ?>
                    <li><i class="fas fa-users"></i><a onclick="RedirectPage(`<?php echo dsa_url('users'); ?>`)" href="javascript:void(0)" >Users</a></li>
                    <?php } ?>
                    <?php if(MainPermission(8)){ ?>
                    <li><i class="fas fa-list"></i><a href="#" onclick="GetYourRm()">Your RM</a></li>
                    <?php } ?>
                    <?php if(MainPermission(6)){ ?>
                    <li><i class="fas fa-key"></i><a onclick="RedirectPage(`<?php echo dsa_url('api'); ?>`)" href="javascript:void(0)" >Api</a></li>
                    <?php } ?>
                </ul>
                <ul class="delete">
                    <li><i class="fas fa-power-off"></i><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                    <!--li><i class="fas fa-trash-alt"></i><a href="#">Delete Profile</a></li-->
                </ul>
                <!-- Modal -->
            </div>
        </div>
    </div>
</div>
<script>
function show_link(){
    $('#OpenOtpModel').modal('show');
}
</script>