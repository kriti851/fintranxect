<div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12 mb30">
    <div class="dashaboard-leftbar">
        <div class="dashboard-sidebar">
            <div class="user-info">
                <a href="<?php echo lender_url('profile'); ?>" class="d-flex">
                    <div class="user-body">
                        <h5><?php echo $this->session->userdata('full_name');  ?></h5>
                        <h5>ID: <span><?php echo $this->session->userdata('file_id');  ?></span></h5>
                        <span><?php echo $this->session->userdata('email');  ?></span>
                    </div>
                </a>
            </div>
            <div class="dashboard-menu">
                <ul>
                    <li class="active"><i class="fas fa-home"></i><a href="<?php echo lender_url('dashboard') ?>">Dashboard</a></li>
                    <li><i class="fas fa-user"></i><a href="<?php echo lender_url('profile'); ?>">Profile</a></li>
                    <li><i class="fas fa-list"></i><a href="<?php echo lender_url('merchant'); ?>">Cases Report</a></li>
                    <li><i class="fas fa-list"></i><a href="#" onclick="GetYourRm()">Your RM</a></li>
                </ul>
                <ul class="delete">
                    <li><i class="fas fa-power-off"></i><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>