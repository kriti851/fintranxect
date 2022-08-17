<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

<style>
.loan-form h5 {
    font-size: 16px;
    font-weight: 900;
}
.navbar {
    padding: 0px;
    box-shadow: 0px 1px 9px #c3c3c3;
}
.loan-apply {    
    padding: 180px 0;
    background-color: #f9f9f9;
    min-height: 550px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    margin-top: -100px;
}
.display-5 {
    font-size: 36px;
    line-height: 58px;
}
.feature-table {
    display: -ms-flexbox;
    display: flex;
    width: 100%;
    margin-top: 20px;
}
.feature-table .feature-cell {
    -ms-flex: 1;
    flex: 1;
    width: 50%;
}
.feature-table .feature-cell .fetaure-cell-table {
    display: table;
    width: 100%;
}
.feature-table .feature-cell .fetaure-cell-table .fetaure-cell-table-cell:first-child {
    width: 60px;
    text-align: center;
}
.feature-table .feature-cell .fetaure-cell-table .fetaure-cell-table-cell {
    display: table-cell;
    vertical-align: middle;
}
.feature-table .feature-cell .fetaure-cell-table .fetaure-cell-table-cell .feature-circle {
    background-color: #f4f6f8;
    width: 60px;
    height: 60px;
    border-radius: 100px;
    padding: 5px;
    color: #007bff;
    font-size: 22px;
    text-align: center;
    margin-right: 15px;
}

.feature-table .feature-cell .fetaure-cell-table .fetaure-cell-table-cell h2 {
    font-size: 12px;
    line-height: 14px;
    color: #333;
    display: inherit;
    text-transform: none;
}
.feature-table .feature-cell .fetaure-cell-table .fetaure-cell-table-cell h2 strong {
    font-weight: 700;
    display: block;
    font-size: 15px;
}
.background-img-loan {
    background-image: url(<?php echo base_url(); ?>assets/img/banner-image.png);
    background-size: 501px auto;
    position: absolute;
    width: 501px;
    height: 426px;
    left: -149px;
    background-repeat: no-repeat;
    top: 31px;
    right: -108px;
}
.loan-form {
     background: #fff;
    padding-top: 15px;
    color: #555;
    margin-bottom: 15px;
    box-shadow: 0 0 40px 0 rgba(0,0,0,.3);
    border-radius: 5px;
    padding-bottom: 4px;
    position: relative;padding: 30px;
}
.w100 { width:100%;margin-bottom:10px;}
input[type=checkbox] + label {
    display: block; 
}
input[type=checkbox] + label:before {
    width: 1.5em;
    height: 1.5em;
    float: left;
}
.md-input .md-form-control {
    width: 100%;
    background-color: #fff;
    color: #555;
    height: 52px;
    border: 2px solid #e6ecef;
	font-size: 13.5px;
    padding: 10px 10px 10px 10px;
}
.md-input label {
    color: #656565;
    font-size: 14px;
	top:15px;
}
.md-input .md-form-control:focus ~ label, .md-input .md-form-control:valid ~ label {
    top: 5px;
    font-size: 10px;
    color: #656565;
}
.md-input {
    position: relative;
    margin-bottom: 10px;
}
.md-form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
.btn {
    padding: 15px 20px;
    margin-bottom: 10px;
}
.accup {
	position: relative;
    margin-top: 10px;
    color: #555;
    font-size: 14px;
    background: transparent;
    left: 0px;
    top: 0px;
    margin: 0px;
    line-height: 1.6;
    font-weight: 400;
}


/*== start of code for tooltips ==*/
.f14 {
	font-size: 14px;
}
.tool {
    cursor: pointer;
    position: relative;
}


/*== common styles for both parts of tool tip ==*/
.tool::before,
.tool::after {
    left: 50%;
    opacity: 0;
    position: absolute;
    z-index: -100;
}

.tool:hover::before,
.tool:focus::before,
.tool:hover::after,
.tool:focus::after {
    opacity: 1;
    transform: scale(1) translateY(0);
    z-index: 100; 
}


/*== pointer tip ==*/
.tool::before {
    border-style: solid;
    border-width: 1em 0.75em 0 0.75em;
    border-color:#487ae4 transparent transparent transparent;
    bottom: 100%;
    content: "";
    margin-left: -10px;
    transition: all .65s cubic-bezier(.84,-0.18,.31,1.26), opacity .65s .5s;
    transform:  scale(.6) translateY(-90%);
} 

.tool:hover::before,
.tool:focus::before {
    transition: all .65s cubic-bezier(.84,-0.18,.31,1.26) .2s;
}


/*== speech bubble ==*/
.tool::after {
    background: #487ae4;
    border-radius: 0.25em;
    bottom: 180%;
    color: #EDEFF0;
    content: attr(data-tip);
    margin-left: -8em;
    padding: 8px;
    transition: all .65s cubic-bezier(.84,-0.18,.31,1.26) .2s;
    transform: scale(.6) translateY(50%);
    width: 17.5em;
    font-size: 11px;
    text-align: center;
}

.tool:hover::after,
.tool:focus::after  {
    transition: all .65s cubic-bezier(.84,-0.18,.31,1.26);
}

@media (max-width: 760px) {
  .tool::after { 
        font-size: .75em;
        margin-left: -5em;
        width: 10em; 
  }
}



</style>


<div class="section-space40 loan-apply">
        <!-- content start -->
        <div class="container">
            <div class="row d-flex ">
			  <div class="col-lg-7 col-md-12 col-12">
                <?php if(!empty($logoagent->logo)){ ?>
                    <a href="javascript:void(0)" class="navbar-brand" id="logo" style="width: 220px;">
			        <img src="<?php echo base_url('uploads/logo/'.$logoagent->logo); ?>" alt=""></a>
                <?php } ?>
				<div class="p-3 p-lg-0">
				  <h1 class="display-5">Instant Business & Personal Loan</h1>
				  <div class="feature-table">
                       <div class="feature-cell">
                           <div class="fetaure-cell-table">
                               <div class="fetaure-cell-table-cell">
                                   <div class="feature-circle loan-amount"><img src="<?php echo base_url(); ?>assets/img/inr-icon.png"/></div>
                               </div>
                               <div class="fetaure-cell-table-cell">
                                   <h2>Loan Amount<strong>5L - 5CR</strong></h2>
                               </div>
                           </div>
                       </div>
                       <div class="feature-cell">
                           <div class="fetaure-cell-table">
                               <div class="fetaure-cell-table-cell">
                                   <div class="feature-circle roi"><img src="<?php echo base_url(); ?>assets/img/percentage-icon.png"/></div>
                               </div>
                               <div class="fetaure-cell-table-cell">
                                   <h2> Rate of Interest<strong>15% Onwards</strong></h2>
                               </div>
                           </div>
                       </div>
                   </div>
				   <div class="feature-table">
                       <div class="feature-cell">
                           <div class="fetaure-cell-table">
                               <div class="fetaure-cell-table-cell">
                                   <div class="feature-circle loan-amount"><img src="<?php echo base_url(); ?>assets/img/calander-icon.png"/></div>
                               </div>
                               <div class="fetaure-cell-table-cell">
                                   <h2>Tenure<strong>12 - 48 Months</strong></h2>
                               </div>
                           </div>
                       </div>
                       <div class="feature-cell">
                           <div class="fetaure-cell-table">
                               <div class="fetaure-cell-table-cell">
                                   <div class="feature-circle roi"><img src="<?php echo base_url(); ?>assets/img/processing-fee.png"/></div>
                               </div>
                               <div class="fetaure-cell-table-cell">
                                   <h2>Processing Fee<strong>1% Onwards</strong></h2>
                               </div>
                           </div>
                       </div>
                   </div>
				   
				</div>
			  </div>
			  
			    <div class="col-lg-5 col-md-12 col-12 d-lg-block">
				    <div class="loanform-outer">
					   <div class="background-img-loan"></div>
					        <input type="hidden" id="das_agent_id" value="<?php  if(!empty($agent->user_id)){ echo $agent->user_id; } ?>">
					        <input type="hidden" id="other_app_user_id" value="<?php  if(!empty($otherapp_user_id)){ echo $otherapp_user_id; } ?>">
					        <div class="loan-form">
                                 <h5>Personal info </h5>
                                <small class="text-center text-danger" id="registration_error"></small>
						        <div class="form-row">
                                    <?php
                                        $first_name = "";
                                        $last_name = "";
                                        if(!empty($pay1data->name)){
                                            $name=explode(" ",$pay1data->name);
                                            $first_name=$name[0];
                                            $last_name=end($name);
                                        }
                                    ?>
									<div class="col-12 col-sm-6">
									    <p class="mb-0 f14">Your First Name 
										  <span class="tool" data-tip="Your name should be the same as your name on your PAN card." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
										<div class="md-input">
										    <input class="md-form-control" title="First Name" value="<?php echo $first_name; ?>" id="first_name" required="" type="text" placeholder="Enter First Name">
										    <!--<label>First Name</label>-->
                                            <small class="text-danger" id="first_name_error"></small>
									    </div>
									</div>
									<div class="col-12 col-sm-6">
										<p class="mb-0 f14">Your Last Name 
										  <span class="tool" data-tip="Your sir name should be the same as your name on your PAN card." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
										<div class="md-input">
											<input class="md-form-control"  title="Last Name" value="<?php echo $last_name; ?>" id="last_name" required="" type="text" placeholder="Enter Last Name">
											<!--<label>Last Name</label>--->
                                            <small class="text-danger" id="last_name_error"></small>
										</div>
									</div>
									
								</div>
								<div class="form-row">
									<div class="col-12 col-sm-6">
									  <p class="mb-0 f14">Your Email Address
										  <span class="tool" data-tip="Please share valid email address to ensure timely communication regarding this application." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
									  <div class="md-input">
										<input class="md-form-control" id="email" value='<?php if(!empty($pay1data->email_id)){ echo $pay1data->email_id; } ?>' title="Mobile number" required="" type="text" placeholder="Enter Email">
										<!--<label>Email</label>-->
                                        <small class="text-danger" id="email_error"></small>
									  </div>
									</div>
									<div class="col-12 col-sm-6">
										<p class="mb-0 f14">Mobile Number 
										  <span class="tool" data-tip="100% privacy and security . We will never share your details to other." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
										<div class="md-input">
											<input class="md-form-control" id="phone" maxlength="10" value="<?php if(!empty($pay1data->mobile)){ echo $pay1data->mobile; } ?>" type="text" title="Mobile number" required="" placeholder="EX-9999999999" >
											<!--<label>Mobile Number</label>-->
                                            <small class="text-danger" id="phone_error"></small>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12 col-sm-6">
										<label style="display:none" id="employment_type_label" class="accup">Type Of Occupation <span class="tool" data-tip="Salaried - You are doing job.
Business - You are doing business." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span></label>
										<select class="multisteps-form__input form-control" title="Type Of Occupation" id="employment_type">
											<!--<option value="">Select Occupation</option>-->
											<option value="Salaried">Salaried</option>
											<option value="Business" >Business</option>
                                        </select>
                                        <small class="text-danger" id="employment_type_error"></small>
									</div>
									<div class="col-12 col-sm-6">
										<p class="mb-0 f14">Your Age
										  <span class="tool" data-tip="Salaried - Age between 18 years and 65 years.&#xA;
										  Self-employed - Age between 21 years and 67 years." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
										<div class="md-input">
											<input class="md-form-control" id="age" oninput="this.value = Math.abs(this.value)" title="Age" required="" type="number" placeholder="Enter Age (Min 18 year)">
											<!--<label>Age</label>-->
										</div>
									</div>
									
								</div>
                                <div class="form-row">
									<div class="col-12 col-sm-12" id="add_date_field">
										
									</div>
                                </div>
                                <div class="custom-checkbox">
                                    <input name="noti_6" class="checkbox-custom" id="noti_6" value="6" type="checkbox">
                                    <label class="checkbox-custom-label" for="noti_6">
                                    By applying you agree to our <a href="<?php echo site_url('terms-of-use'); ?>">Terms of Use</a> and <a href="<?php echo site_url('privacy-policy'); ?>">Privacy Policy</a></label>
                                    <small class="text-danger" id="term_error"></small>
                                </div>
				                <input type="button" id="personal-form-submit" class="w100 action-button btn btn-primary" value="Apply Now" />
								
								<a href="#!" class="w100 action-button btn btn-primary" data-toggle="modal" data-target="#checkstatus">Check Status</a>
								
					    </div>
				    </div>
			  </div>
			</div>
        </div>
    </div>
	
	
	<div class="modal fade" id="checkstatus" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modal_content">
                <div class="modal-header">
                    <h4 class="modal-title">Check Your Loan Status</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id='addstatus'>
                        <div class="col-12 col-sm-12">
                            <div class="md-input">
                                <input class="md-form-control" id="caseid" title="Case Id" required="" type="text">
                                <label>Case Id</label>
                                <small class="text-danger" id="caseid_error"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="md-input">
                                <input class="md-form-control" id="password" title="Password" required="" type="password">
                                <label>Password</label>
                                <small class="text-danger" id="password_error"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="status-footer">
                    <button type="button" onclick="GetStatus()" class="btn btn-primary">Check</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('employment_type').onchange=function(){
            OccupationTypeLabel();
            if(this.value=='Business'){
                var html='<div class="md-input">'+
                            `<p class="mb-0 f14">Date of Birth
										<span class="tool" data-tip="As per your official PAN Card records, to ensure your application gets successfully processed." tabindex="1">
									    <i class="fas fa-question-circle f14"></i></span>
									</p>`+
                            '<input class="md-form-control datepickerrange" id="birthdate" name="birthdate"  title="Date Of Birth" autocomplete="off" required="" type="text">'+
                            ''+
                            '<small class="text-danger" id="birthdate_error"></small>'+
                        '</div>';
                document.getElementById('add_date_field').innerHTML=html;
                setTimeout(function(){ loadDatePicker(); }, 100);
            }else{
                document.getElementById('add_date_field').innerHTML='';
            }
        }
        function OccupationTypeLabel(){
            if(document.getElementById('employment_type').value==''){
                document.getElementById('employment_type_label').setAttribute('style','display:none');
                document.getElementById('employment_type').setAttribute('style','');
            }else{
                document.getElementById('employment_type_label').setAttribute('style','');
                document.getElementById('employment_type').setAttribute('style','padding-top:5px;');
            }
        }
        OccupationTypeLabel();
    </script>
    
	