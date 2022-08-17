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
                    
                </div>
            </div>
            <?php $this->load->view('dsa/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12 mt-4 text-left">
                            <h3 class="text-left">Personal Info 
                                <div class="float-right">
                                    <h5>
                                        <a href="<?php echo dsa_url('profile/edit'); ?>" class="button viewbutton"><i class="fa fa-edit"></i> Edit Profile</a>
                                        <a href="<?php echo dsa_url('profile/change_password'); ?>" class="button viewbutton"><i class="fa fa-lock"></i> Change Password</a>
                                    </h5>
                                </div>
                            </h3>
                            <div class="information">
                                <h4>Partner Information</h4>
                                <ul>
                                    <li><span>Partner ID:</span> <?php echo $profile->file_id; ?></li>
                                    <li><span>Company Name:</span> <?php echo $profile->company_name; ?></li>
                                    <li><span>Person Name:</span> <?php echo $profile->full_name; ?></li>
                                    <li><span>Mobile no:</span> +91 <?php echo $profile->mobile_number; ?></li>
                                    <li><span>Email:</span> <?php echo $profile->email; ?></li>
                                    <li><span>Website:</span> <?php echo $profile->website; ?></li>
                                    <li><span>Pan/GST no:</span> <?php echo $profile->gst_number; ?></li>
                                    <li><span>Address:</span> <?php echo $profile->address; ?></li>
                                </ul>
                            
                                    <?php
                                    $extension=pathinfo($profile->doc,PATHINFO_EXTENSION);
                                    if($extension=='pdf'){ ?>
                                        <div>
                                            <h3>Documents</h3>
                                            <a href="<?php echo base_url('uploads/dsa-doc/'.$profile->doc); ?>" style="font-size: 100px;" class="text-danger" download><i class="fa fa-file-pdf"></i></a>
                                        </div>
                                    <?php }elseif($extension=='doc'){ ?>
                                        <div>
                                            <h3>Documents</h3>
                                            <a href="<?php echo base_url('uploads/dsa-doc/'.$profile->doc); ?>" style="font-size: 100px;" class="text-primary" download><i class="fa fa-file-word"></i></a>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="photodocument">
                                                <img src="<?php echo base_url('uploads/dsa-doc/'.$profile->doc); ?>" />
                                        </div>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>