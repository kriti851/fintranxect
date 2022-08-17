<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>My Profile</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Profile</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#">
                        <input type="text" placeholder="Enter Keywords" />
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <?php $this->load->view('lender/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12 mt-4 text-left">
                            <h3 class="text-left">Personal Info 
                                <div class="float-right">
                                    <h5>
                                        <a href="<?php echo lender_url('profile/edit'); ?>" class="button viewbutton"><i class="fa fa-edit"></i> Edit Profile</a>
                                        <a href="<?php echo lender_url('profile/change_password'); ?>" class="button viewbutton"><i class="fa fa-lock"></i> Change Password</a>
                                    </h5>
                                </div>
                            </h3>
                            <div class="information">
                                <h4>Lender Information</h4>
                                <ul>
                                    <li><span>Lender Id:</span> <?php echo $profile->file_id ?></li>
                                    <li><span>Company Name:</span> <?php echo $profile->company_name ?></li>
                                    <li><span>Person Name:</span> <?php echo $profile->full_name ?></li>
                                    <li><span>Mobile no:</span> +91 <?php echo $profile->mobile_number ?></li>
                                    <li><span>Email:</span> <?php echo $profile->email ?></li>
                                    <li><span>GST no:</span> <?php echo $profile->gst_number ?></li>
                                    <li><span>Pan no:</span> <?php echo $profile->pan_number ?></li>
                                    <li><span>Address:</span> <?php echo $profile->address ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
