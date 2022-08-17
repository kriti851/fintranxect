<div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12 mb30">
    <div class="dashaboard-leftbar">
        <div class="dashboard-sidebar">
            <div class="user-info">
                <a href="profile.html" class="d-flex">
                    <!--div class="thumb">
                        <img src="<?php echo base_url('assets/img/testimonial-img-2.jpg'); ?>" class="img-fluid" alt="" />
                    </div-->
                    <div class="user-body">
                        <h5><?php echo $this->session->userdata('full_name');  ?></h5>
                        <span><?php echo $this->session->userdata('email');  ?></span>
                    </div>
                </a>
            </div>
            <div class="dashboard-menu">
                <ul>
                    <li class="active"><i class="fas fa-home"></i><a href="#">Dashboard</a></li>
                    <li><i class="fas fa-user"></i><a href="<?php echo merchant_url('profile'); ?>">Profile</a></li>
                    <!--li><i class="fas fa-edit"></i><a href="#">link 4</a></li>
                    <li><i class="fas fa-heart"></i><a href="#">link 5</a></li-->
                </ul>
                <ul class="delete">
                    <li><i class="fas fa-power-off"></i><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                    <li><i class="fas fa-trash-alt"></i><a href="#">Delete Profile</a></li>
                </ul>
                <!-- Modal -->
            </div>
        </div>
    </div>
</div>