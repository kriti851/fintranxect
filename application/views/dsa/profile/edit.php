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
                    
                </div>
            </div>
            <?php $this->load->view('dsa/layout/sidebar'); ?>
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
                                        <label>Website <span class="text-danger"><?php echo form_error('website'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="text" name="website" placeholder="Website" value="<?php echo $profile->website;  ?>" />
                                    </div>
                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                        <label>Pan/GST No <span class="text-danger"><?php echo form_error('gst_number'); ?></span></label>
                                        <input class="multisteps-form__input form-control" name="gst_number" type="text" placeholder="GST No" value="<?php echo $profile->gst_number;  ?>" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-sm-6">
                                        <label>Address <span class="text-danger"><?php echo form_error('address'); ?></span></label>
                                        <input class="multisteps-form__input form-control" name="address" type="text" placeholder="Address" value="<?php echo $profile->address;  ?>" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-secondary register-button mt20 float-left">SAVE CHANGES </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
