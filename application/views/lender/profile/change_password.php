<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Change Password</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Change Password</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    
                </div>
            </div>
            <?php $this->load->view('lender/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12 mt-4 text-left">
                            <h3 class="text-left">Change Password</h3>
                            <form action="" method="post">
                                <div class="form-row">
                                    <div class="col-6 col-sm-6">
                                        <label>Old Password<span class="text-danger"><?php echo form_error('old_password'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="password" name="old_password" title="Old Passowrd" value="<?php echo set_value('old_password'); ?>" placeholder="Old Password"  />
                                    </div>
                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                        <label>New Password <span class="text-danger"><?php echo form_error('new_password'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="password" name="new_password" title="New Password"  value="<?php echo set_value('new_password'); ?>" placeholder="New Password" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                        <label>Confirm Password <span class="text-danger"><?php echo form_error('confirm_password'); ?></span></label>
                                        <input class="multisteps-form__input form-control" type="password" name="confirm_password" title="Confirm Password"  value="<?php echo set_value('confirm_password'); ?>" placeholder="Confirm Password"  />
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
