<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb30">
                <div class="card">
                    <div class="card-body">
                        <ul class="bullet bullet-check-circle list-unstyled">
                            <li>Access all information related to your loan</li>
                            <li>View Latest Offers</li>
                            <li>Get a new loan</li>
                            <li>Pay EMI and Overdues</li>
                            <li>Create a service request</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb30">
                <div class="login-box-right">
                    <p>Login with Super Admin</p>
                    <form action="" method="post">
                        <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <span class="text-danger">
                                    <?php if(form_error('username')){ echo form_error('username'); }elseif(!empty($username_error)){ echo $username_error; } ?>
                                </span>
                                <input  name="username" type="text" value="<?php set_value('username'); ?>" placeholder="Email" class="form-control input-md" />
                            </div>
                            <div class="form-group">
                                <span class="text-danger">
                                    <?php if(form_error('password')){ echo form_error('password'); }elseif(!empty($password_error)){ echo $password_error; } ?>
                                </span>
                                <input  name="password" type="password" placeholder="Password" class="form-control input-md" />
                            </div>
                        </div>
                        <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                            <button type="submit" class="btn btn-secondary view-loan-button mt20">LOG IN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
