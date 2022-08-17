<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Edit Profile</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Edit Profile</a></li>
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
                            <h3 class="text-left">Personal Info</h3>
                            <form action="" method="post">
                                <div class="form-row">
                                    <div class="col-6 col-sm-6">
                                        <label>Full name <span class="text-danger"><?php echo form_error('full_name'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="text" name="full_name" placeholder="Full name" value="<?php echo $profile->full_name;  ?>" />
                                    </div>
                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                        <label>Company name <span class="text-danger"><?php echo form_error('company_name'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="text" name="company_name" placeholder="Company name" value="<?php echo $profile->company_name;  ?>" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-sm-6">
                                        <label>Mobile no <span class="text-danger"></span></label>
                                        <input class="multisteps-form__input form-control" type="text" disabled placeholder="mobile no" value="<?php echo $profile->mobile_number;  ?>" />
                                    </div>
                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                        <label>Email Address <span class="text-danger"><?php echo form_error('email'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="text" name="email" placeholder="Email" value="<?php echo $profile->email;  ?>" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-sm-6">
                                        <label>Pan Number <span class="text-danger"><?php echo form_error('pan_number'); ?></span></label>
                                        <input class="multisteps-form__input form-control" name="pan_number" type="text" placeholder="Pan No" value="<?php echo $profile->pan_number;  ?>" />
                                    </div>
                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                        <label>GST No <span class="text-danger"><?php echo form_error('gst_number'); ?></span></label>
                                        <input class="multisteps-form__input form-control" name="gst_number" type="text" placeholder="GST No" value="<?php echo $profile->gst_number;  ?>" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-sm-12">
                                        <label>Address <span class="text-danger"><?php echo form_error('address'); ?></span></label>
                                        <input class="multisteps-form__input form-control" name="address" type="text" placeholder="Address" value="<?php echo $profile->address;  ?>" />
                                    </div>
                                   
                                </div>
                                <button type="submit" class="btn btn-secondary register-button mt20 float-left">Submit </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
