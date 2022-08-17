<style>
.card { margin-bottom: 15px;}
.card-body { padding: 20px;padding-bottom: 0px;}
.login-sub-heading { margin-bottom: 0px;}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb30">
                <p class="login-sub-heading">Personal Loans</p>
                <div class="card">
                    <div class="card-body">
                        <ul class="bullet bullet-check-circle list-unstyled">
                            <li>No Collateral/Security Required. Personal loans don&#39;t need you to provide any collateral such as a house or car to avail a personal loan.</li>
                            <li>Flexible End Use.</li>
                            <li>Flexible Tenure.</li>
                            <li>Minimal Documentation.</li>
                            <li>Quick Disbursal.</li>
							<li>Flexible Loan Amount.</li>

                        </ul>
                    </div>
                </div>
				
				
				<p class="login-sub-heading">Business Loans</p>
                <div class="card">
                    <div class="card-body">
                        <ul class="bullet bullet-check-circle list-unstyled">
						     <li>Unsecured Business Loans/ No Collateral Required</li>
                            <li>Minimum KYC</li>
							<li>Furnishes your Working Capital Requirement, Manage operational cost, growth &amp; expansion of
Business</li>
							
							
                        </ul>
                    </div>
                </div>
				
				
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb30">
                <div class="login-box-right">
                    <!--<a href="#" class="fb btn"><i class="fab fa-facebook socoail-fn"></i> Login with Facebook</a>
                    <a href="#" class="google btn"><i class="fab fa-google-plus socoail-fn"></i> Login with Google+</a>-->
                    <h4>Partner OR Lender</h4>
                    <p>Login with Mobile Number</p>
                    <form action="" method="post">
                        <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <span  class="text-danger"><?php if(form_error('mobile_number')){ echo form_error('mobile_number'); }elseif(!empty($mobile_number_error)){ echo $mobile_number_error; } ?></span>
                                <input id="mobile_number" mxalength="10" name="mobile_number" type="text" placeholder="Mobile Number" value="<?php echo set_value('mobile_number'); ?>" class="form-control input-md" required="" />
                            </div>
                            <div class="form-group">
                                <span  class="text-danger"><?php if(form_error('password')){ echo form_error('password'); }elseif(!empty($password_error)){ echo $password_error; } ?></span>
                                <input id="password" name="password" type="password" value="<?php echo set_value('password'); ?>" placeholder="Password" class="form-control input-md" required="" />
                            </div>
                        </div>
                       <p class="mt20 forgotpasswordbtm"><a href="#" data-toggle="modal" data-target="#frgotpassword">Forgot Password</a></p>
                        <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                            <button type="submit" class="btn btn-secondary view-loan-button mt20">SIGN IN </button>
                        </div>
                    </form>
                    <p class="mt20">Don't have account? <a href="<?php echo site_url('registration'); ?>">Register</a></p>

                    <p class="mt20">By logging in, you agree to the following Credit report <a href="">Terms of Use</a> and <a href="">Terms of Use</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="frgotpassword" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Forgot Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="forgot-password">
                <div class="col-12 col-sm-12">
                    <span class="text-danger" id="mobile_number_error"></span>
                    <input class="multisteps-form__input form-control" id="mobile_phone" type="text" placeholder="Enter Mobile Number" />
                </div>
            </div>

            <div class="modal-footer">
			    <div class="col-sm-12 text-center" id="forgot-button">
                    <button type="button" onclick="SendOtp()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
