<style>
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
	    font-size: 14px;
    padding: 23px 16px 13px 20px;
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
.accup {position: absolute;margin-top:10px; color: #656565; font-size: 10px; background: #fff; left: 20px; top: -4px;}

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

<section class="section-space60 bg-white full-width-loan">
	     <div class="container">
	       <div class="row">
	            
				   <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 offset-md-1 col-md-10 col-sm-12 col-12">
                    <div class="request-form">
					<input type="hidden" id="phone" value="<?php  if(!empty($mobile_number)){ echo $mobile_number; } ?>">
					<form id="msform">
							<!-- progressbar -->
							<ul id="progressbar">
							   	<li class="active">Business info</li>
								<li>Co-Applicants</li>
								<li>Upload documents</li>
								<li>Reference</li>
							</ul>
							<div id="showcoapplicantbar">
								
							</div>
							<div id="showdocumentbar">
								
							</div>
							<fieldset>
								 <h3 class="multisteps-form__title">Business info</h3>
								 	<div class="form-row mt-4">
										<div class="col-12 col-sm-6">
										     <p class="mb-0 f14">Business Name 
    										  <span class="tool" data-tip="Fill the name of your business" tabindex="1">
    									      <i class="fas fa-question-circle f14"></i></span>
    									    </p>
											<div class="md-input">
												<input class="md-form-control" placeholder="Enter Business Name" required="" value="<?php if(!empty($users->company_name)){ echo $users->company_name; }elseif(!empty($pay1data->shop_name)){ echo $pay1data->shop_name; }?>" onkeyup="DataSave(this.id,this.value)" id="business_name" type="text" title="Business name">
												<!--<label>Business Name</label>-->
												<small class="text-danger" id="business_name_error"></small>
											</div>
										</div>
										<div class="col-12 col-sm-6">
										 <p class="mb-0 f14">Loan Type
										  <span class="tool" data-tip="Please select Loan Type from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="loan_type1_label" class="accup">Type Of Loan</label>-->
											<select class="multisteps-form__input form-control" title="Type Of loan" onchange="DataSave(this.id,this.value);LoanTypeLabel()" id="loan_type1">
												<option value="">Type Of Loan</option>
												<option value="Personal" <?php if(!empty($detail->loan_type1) && $detail->loan_type1=='Personal'){ echo "selected"; } ?>>Personal</option>
												<option value="Business" <?php if(!empty($detail->loan_type1) && $detail->loan_type1=='Business'){ echo "selected"; } ?>>Business</option>
											</select>
											<small class="text-danger" id="loan_type1_error"></small>
										</div>
									</div>
									<div class="form-row mt-4">
										<div class="col-12 col-sm-6 mt-4 mt-sm-0">
										<p class="mb-0 f14">State
										  <span class="tool" data-tip="Select state from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="state_label" class="accup">State</label>-->
										    <select class="multisteps-form__input form-control" id="state" title="State"  onchange="GetCityList(this.value);DataSave(this.id,this.value);StateLabel()">
											  	<option value="">State</option>
												<?php foreach($states as $state){ ?>
												<option value="<?php echo $state->name; ?>" <?php if(!empty($detail->state) && $detail->state==$state->name){ echo 'selected'; }elseif(!empty($pay1data->shop_state) && $pay1data->shop_state==$state->name){ echo "selected"; }  ?>><?php echo $state->name; ?></option>
												<?php }  ?>
											</select>
											<small class="text-danger" id="state_error"></small>
										</div>
										<div class="col-12 col-sm-6">
										<p class="mb-0 f14">City
										  <span class="tool" data-tip="Select city from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="city_label" class="accup">City</label>-->
											<select title="City" onchange="DataSave(this.id,this.value);CheckSelectCity(this.value);CityLabel()" class="multisteps-form__input form-control" id="city">
												<option value="">City</option>
											</select>
											<input type="hidden" id="city_hidden" value="<?php if(!empty($detail->city)){ echo $detail->city; }elseif(!empty($pay1data->shop_city)){ echo $pay1data->shop_city; } ?>">
											<input type="hidden" id="other_city_hidden" value="<?php if(!empty($detail->other_city)){ echo $detail->other_city; } ?>">
											<small class="text-danger" id="city_error"></small>
										</div>
									</div>
									<div class="form-row" id="other_city_field">
										
									</div>
									<div class="form-row mt-4">
										<div class="col-12 col-sm-6">
									 <p class="mb-0 f14">Flat No./Building No./Street No.
										  <span class="tool" data-tip="Fill the detail about your Flat No./Building No./Street No." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<div class="md-input">
												<input class="md-form-control" placeholder="Enter Flat No./Building No./Street No." value="<?php if(!empty($detail->houseno)){ echo $detail->houseno; } ?>" id="houseno" type="text" onkeyup="DataSave(this.id,this.value)" required="" title="Flat No./Building No./Street No." />
												<!--<label>Flat No./Building No./Street No.</label>-->
												<small class="text-danger" id="houseno_error"></small>
											</div>
										</div>
										<div class="col-12 col-sm-6 mt-4 mt-sm-0">
										<p class="mb-0 f14">Pincode
										  <span class="tool" data-tip="Select Pincode from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="pincode_label" class="accup">Pincode</label>-->
											<select onchange="DataSave(this.id,this.value);OtherPincode(this.value);PincodeLabel()" class="multisteps-form__input form-control"  title="Pincode"  id="pincode" >
													<option value="">Pincode</option>
													<option value="Other">Other</option>
											</select>
											<small class="text-danger" id="pincode_error"></small>
											<input type="hidden" id="pincode_hidden" value="<?php if(!empty($detail->pincode)){ echo $detail->pincode; }elseif(!empty($pay1data->shop_pincode)){ echo $pay1data->shop_pincode; } ?>" >
											<input type="hidden" id="other_pincode_hidden" value="<?php if(!empty($detail->other_pincode)){ echo $detail->other_pincode; } ?>" >
										</div>
									</div>
									<div class="form-row" id="other_pincode_field">
										
									</div>
									<div class="form-row mt-4">
									    <div class="col-12 col-sm-6">
									    <p class="mb-0 f14">Type of Firm
										  <span class="tool" data-tip="Select type of firm from the given list below" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="business_type_label" class="accup">Type Of Firm</label>-->
											<select class="multisteps-form__select form-control" onchange="CheckDPBtn();DataSave(this.id,this.value);BusinessTypeLabel()" title="Type of Firm" id="business_type">
												<option value="" >Type of Firm</option>
												<option value="Individual"  <?php if(!empty($detail->business_type) && $detail->business_type=='Individual'){ echo 'selected'; }  ?>>Individual</option>
												<option value="Proprietorship" <?php if(!empty($detail->business_type) && $detail->business_type=='Proprietorship'){ echo 'selected'; }  ?>>Proprietorship</option>
												<option value="Partnership" <?php if(!empty($detail->business_type) && $detail->business_type=='Partnership'){ echo 'selected'; }  ?>>Partnership</option>
												<option value="PVT .ltd" <?php if(!empty($detail->business_type) && $detail->business_type=='PVT .ltd'){ echo 'selected'; }  ?>>PVT .ltd</option>
										  	</select>
											<small class="text-danger" id="type_of_firm_error"></small>
										</div>
										<div class="col-12 col-sm-6">
										<p class="mb-0 f14">Nature Of Business
										  <span class="tool" data-tip="Select nature of business from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="nature_of_business_label" class="accup">Nature Of Business</label>-->
											<select class="multisteps-form__select form-control"  onchange="CheckNatureBtn(this.value);DataSave(this.id,this.value);NatureLabel();" title="Nature Of Business" id="nature_of_business">
												<option value="" >Nature Of Business</option>
												<option value="Retail"  <?php if(!empty($detail->nature_of_business) && $detail->nature_of_business=='Retail'){ echo 'selected'; }  ?>>Retail</option>
												<option value="Manufacturing"  <?php if(!empty($detail->nature_of_business) && $detail->nature_of_business=='Manufacturing'){ echo 'selected'; }  ?>>Manufacturing</option>
												<option value="Service"  <?php if(!empty($detail->nature_of_business) && $detail->nature_of_business=='Service'){ echo 'selected'; }  ?>>Service</option>
												<option value="Wholesale"  <?php if(!empty($detail->nature_of_business) && $detail->nature_of_business=='Wholesale'){ echo 'selected'; }  ?>>Wholesale</option>
										  	</select>
											<small class="text-danger" id="nature_of_business_error"></small>
										</div>
									</div>
									<div class="form-row" id="firm_field">
										<?php  if(!empty($detail->business_type)){ if($detail->business_type=='Partnership'){ ?>
											<div id="add_number_field" class="col-12 col-sm-6 mt-4">
										<p class="mb-0 f14">No. of Partners
										  <span class="tool" data-tip=" Fill the number of your Partners" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
												<div class="md-input">
													<input class="md-form-control" placeholder="Enter No. of Partners" onkeyup="TotalPartnerDoc(this.value);DataSave(this.id,this.value)" id="no_of_partner" type="number" value="<?php echo $detail->total_director_partner; ?>" required="" title="No. of Partners"  />
													<!--<label>No. of Partners</label>-->
													<small id="partner_number_error" class="text-danger"></small>
												</div>
											</div>
										<?php }elseif($detail->business_type=='PVT .ltd'){ ?>
											<div id="add_number_field" class="col-12 col-sm-6 mt-4">
										<p class="mb-0 f14">No. of Directors
										  <span class="tool" data-tip=" Fill the number of Directors" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
												<div class="md-input">
													<input class="md-form-control" placeholder="Enter No. of Directors" onkeyup="TotalDirectorDoc(this.value);DataSave(this.id,this.value)" id="no_of_director" value="<?php echo $detail->total_director_partner; ?>" type="number" title="No. of Directors" required=""/>
													<!--<label>No. of Directors</label>-->
													<small id="director_number_error" class="text-danger"></small>
												</div>
											</div>
										<?php }else{ ?>
											<div id="add_number_field" class="col-12 col-sm-6"></div>
										<?php }}else{ ?>
											<div id="add_number_field" class="col-12 col-sm-6"></div>
										<?php } ?>
										<?php if(!empty($detail->type_of_nature)){ ?>
										<div id="add_nature_field" class="col-12 col-sm-6 mt-4">
										<p class="mb-0 f14">Nautre Of business
										  <span class="tool" data-tip=" Select the nautre of business" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<div class="md-input">
												<input class="md-form-control" placeholder="Enter Nautre Of business" id="type_of_nature" onkeyup="DataSave(this.id,this.value)" value="<?php echo $detail->type_of_nature; ?>" type="text" title="Type Of <?php echo $detail->nature_of_business; ?>" required="" />
												<!--<label>Type Of <?php echo $detail->nature_of_business; ?></label>-->
												<small id="type_of_nature_error" class="text-danger"></small>
											</div>
										</div>
										<?php  }else{ ?>
											<div id="add_nature_field" class="col-12 col-sm-6">
											</div>
										<?php } ?>
									</div>
									<div class="form-row mt-4">
										<div class="col-12 col-sm-6">
									   <p class="mb-0 f14">No. of years in business
										  <span class="tool" data-tip="Fill the acutal number of years in business" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<div class="md-input">
												<input class="md-form-control" placeholder="No. of years in business" value="<?php if(!empty($detail->vintage)){ echo $detail->vintage; } ?>" onkeyup="DataSave(this.id,this.value)" id="vintage" type="number" oninput="this.value = Math.abs(this.value)" title="No. of years in business" required=""/>
												<!--<label>No. of years in business</label>-->
												<small class="text-danger" id="vintage_error"></small>
											</div>
										</div>
										<div class="col-12 col-sm-6 mt-4 mt-sm-0">
										<p class="mb-0 f14">Monthly Turnover
										  <span class="tool" data-tip="Please select the Monthly Turnover from the list given below" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="turn_over_label" class="accup">Monthly Turnover</label>-->
										    <select id="turn_over" class="multisteps-form__input form-control" onchange="DataSave(this.id,this.value);TurnOverLabel();" title="Monthly Turnover">
											  	<option value="">Monthly Turnover</option>
											  	<option value="0.5 - 0.75 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='0.5 - 0.75 lac'){ echo "selected"; } ?>>0.5 - 0.75 lac</option>
												<option value="0.75 - 1 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='0.75 - 1 lac'){ echo "selected"; } ?>>0.75 - 1 lac</option>
												<option value="1 - 5 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='1 - 5 lac'){ echo "selected"; } ?>>1 - 5 lac</option>
												<option value="5 - 10 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='5 - 10 lac'){ echo "selected"; } ?>>5 - 10 lac</option>
												<option value="10 - 15 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='10 - 15 lac'){ echo "selected"; } ?>>10 - 15 lac</option>
												<option value="15 - 20 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='15 - 20 lac'){ echo "selected"; } ?>>15 - 20 lac</option>
												<option value="20 - 25 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='20 - 25 lac'){ echo "selected"; } ?>>20 - 25 lac</option>
												<option value="25 - 30 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='25 - 30 lac'){ echo "selected"; } ?>>25 - 30 lac</option>
												<option value="30 - 35 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='30 - 35 lac'){ echo "selected"; } ?>>30 - 35 lac</option>
												<option value="35 - 40 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='35 - 40 lac'){ echo "selected"; } ?>>35 - 40 lac</option>
												<option value="40 - 45 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='40 - 45 lac'){ echo "selected"; } ?>>40 - 45 lac</option>
												<option value="45 - 50 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='45 - 50 lac'){ echo "selected"; } ?>>45 - 50 lac</option>
												<option value="50 - 55 lac" <?php if(!empty($detail->turn_over) &&  $detail->turn_over=='50 - 55 lac'){ echo "selected"; } ?>>50 - 55 lac</option>
												<option value="55 - 60 lac" <?php if(!empty($detail->turn_over)&&  $detail->turn_over=='55 - 60 lac'){ echo "selected"; } ?>>55 - 60 lac</option>
												<option value="60 - 65 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='60 - 65 lac'){ echo "selected"; } ?>>60 - 65 lac</option>
												<option value="65 - 70 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='65 - 70 lac'){ echo "selected"; } ?>>65 - 70 lac</option>
												<option value="70 - 75 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='70 - 75 lac'){ echo "selected"; } ?>>70 - 75 lac</option>
												<option value="75 - 80 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='75 - 80 lac'){ echo "selected"; } ?>>75 - 80 lac</option>
												<option value="80 - 85 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='80 - 85 lac'){ echo "selected"; } ?>>80 - 85 lac</option>
												<option value="85 - 90 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='85 - 90 lac'){ echo "selected"; } ?>>85 - 90 lac</option>
												<option value="90 - 95 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='90 - 95 lac'){ echo "selected"; } ?>>90 - 95 lac</option>
												<option value="95 - 99 lac" <?php if(!empty($detail->turn_over) && $detail->turn_over=='95 - 99 lac'){ echo "selected"; } ?>>95 - 99 lac</option>
												<option value="99 above" <?php if(!empty($detail->turn_over) && $detail->turn_over=='99 above'){ echo "selected"; } ?>>99 above</option>
											</select>
											<small class="text-danger" id="turn_over_error"></small>
										</div>
									  </div>
									  <div class="form-row mt-4">
										<div class="col-12 col-sm-6">
								    	<p class="mb-0 f14">Desired Loan Amount
										  <span class="tool" data-tip=" Please select the desired loan amount from the list given below" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									    </p>
											<!--<label style="display:none" id="desired_amount_label" class="accup">Desired Loan Amount</label>-->
										    <select id="desired_amount" class="multisteps-form__input form-control" onchange="DataSave(this.id,this.value);DesiredAmountLabel();" title="Desired Loan Amount">
											  	<option value="">Desired Loan Amount</option>
											  	<option value="0.5 - 0.75 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='0.5 - 0.75 lac'){ echo "selected"; } ?>>0.5 - 0.75 lac</option>
												<option value="0.75 - 1 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='0.75 - 1 lac'){ echo "selected"; } ?>>0.75 - 1 lac</option>
												<option value="1 - 5 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='1 - 5 lac'){ echo "selected"; } ?>>1 - 5 lac</option>
												<option value="5 - 10 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='5 - 10 lac'){ echo "selected"; } ?>>5 - 10 lac</option>
												<option value="10 - 15 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='10 - 15 lac'){ echo "selected"; } ?>>10 - 15 lac</option>
												<option value="15 - 20 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='15 - 20 lac'){ echo "selected"; } ?>>15 - 20 lac</option>
												<option value="20 - 25 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='20 - 25 lac'){ echo "selected"; } ?>>20 - 25 lac</option>
												<option value="25 - 30 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='25 - 30 lac'){ echo "selected"; } ?>>25 - 30 lac</option>
												<option value="30 - 35 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='30 - 35 lac'){ echo "selected"; } ?>>30 - 35 lac</option>
												<option value="35 - 40 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='35 - 40 lac'){ echo "selected"; } ?>>35 - 40 lac</option>
												<option value="40 - 45 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='40 - 45 lac'){ echo "selected"; } ?>>40 - 45 lac</option>
												<option value="45 - 50 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='45 - 50 lac'){ echo "selected"; } ?>>45 - 50 lac</option>
												<option value="50 - 55 lac" <?php if(!empty($detail->desired_amount) &&  $detail->desired_amount=='50 - 55 lac'){ echo "selected"; } ?>>50 - 55 lac</option>
												<option value="55 - 60 lac" <?php if(!empty($detail->desired_amount)&&  $detail->desired_amount=='55 - 60 lac'){ echo "selected"; } ?>>55 - 60 lac</option>
												<option value="60 - 65 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='60 - 65 lac'){ echo "selected"; } ?>>60 - 65 lac</option>
												<option value="65 - 70 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='65 - 70 lac'){ echo "selected"; } ?>>65 - 70 lac</option>
												<option value="70 - 75 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='70 - 75 lac'){ echo "selected"; } ?>>70 - 75 lac</option>
												<option value="75 - 80 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='75 - 80 lac'){ echo "selected"; } ?>>75 - 80 lac</option>
												<option value="80 - 85 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='80 - 85 lac'){ echo "selected"; } ?>>80 - 85 lac</option>
												<option value="85 - 90 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='85 - 90 lac'){ echo "selected"; } ?>>85 - 90 lac</option>
												<option value="90 - 95 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='90 - 95 lac'){ echo "selected"; } ?>>90 - 95 lac</option>
												<option value="95 - 99 lac" <?php if(!empty($detail->desired_amount) && $detail->desired_amount=='95 - 99 lac'){ echo "selected"; } ?>>95 - 99 lac</option>
												<option value="99 above" <?php if(!empty($detail->desired_amount) &&$detail->desired_amount=='99 above'){ echo "selected"; } ?>>99 above</option>
											</select>
											<small class="text-danger" id="desired_amount_error"></small>
										</div>
										
									  </div>
											  						
								<input type="button" name="previous" onclick="window.location.href=window.location.href" class="action-button-previous btn btn-primary" value="Previous"/>
								<input type="button" name="next" id="next-2" class="next action-button btn btn-primary" id="next-2" value="Next"/>
							</fieldset>
						  
						  	<fieldset>
						  		<div class="form-row mt-4">
									<div class="col-12 col-sm-12"><h3>Co-Applicants
										<button type="button" id="add_co_applicant_btn" onclick="AddCoApplicant()" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add</button>
										</h3>
									</div>
								</div>
								<div id="add_co_applicant">
									<?php if(!empty($users->applicant)){
										$l=0;
										foreach($users->applicant as $applicant){ ?>
										<div>
											<hr />
											<button type="button" onclick="DeleteRow(this)" class="btn btn-danger float-right mt-2">Delete</button>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												    	<p class="mb-0 f14">Name
                										  <span class="tool" data-tip="Your name should be the same as your name on your PAN card." tabindex="1">
                									      <i class="fas fa-question-circle f14"></i></span>
                									    </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Name" type="text" name="co_name[]" title="Name of co-Applicant" value="<?php echo $applicant->name; ?>" required="" />
														<!--<label>Name</label>-->
														<small class="text-danger invalid"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
            										<p class="mb-0 f14">Relationship
            										  <span class="tool" data-tip="Enter Relationship" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
            									    </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Relationship" type="text" name="co_relationship[]" title="Relationship with co-applicant" required="" value="<?php echo $applicant->relationship; ?>"/>
														<!--<label>Relationship</label>-->
														<small class="text-danger invalid"></small>
													</div>
												</div>
											</div>
											<div class="form-row mt-4">
												<input type="hidden" name="getCoId[]" value="<?php echo $l; ?>">
												<div class="col-12 col-sm-6">
												    	<p class="mb-0 f14">PAN No.
                										  <span class="tool" data-tip="Enter the number of your valid pan card" tabindex="1">
                									      <i class="fas fa-question-circle f14"></i></span>
                									    </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Pan Number" title="PAN" value="<?php echo $applicant->pan_number; ?>" name="co_pan_number[]" type="text" required=""/>
														<!--<label>Pan</label>-->
														<small  class="text-danger other_pan_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												    	<p class="mb-0 f14">Upload Pan Card
                										  <span class="tool" data-tip="Upload valid Pan Card" tabindex="1">
                									      <i class="fas fa-question-circle f14"></i></span>
                									    </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload Pan Card +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`ShowCoPancard<?php echo $applicant->id; ?>`,`base_co_pancard_<?php echo $l; ?>`,`co_pancard_image`)"  id="co_pancard_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="other_pancard_error<?php echo $l; ?>"></small>
												</div>
												<div id="ShowCoPancard<?php echo $applicant->id; ?>" style="width:100%;" <?php if(!empty($applicant->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($applicant->pancard_image)){
														$explode=explode(',',$applicant->pancard_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`ShowCoPancard<?php echo $applicant->id; ?>`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_co_pancard_<?php echo $l; ?>[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`ShowCoPancard<?php echo $applicant->id; ?>`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_co_pancard_<?php echo $l; ?>[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
										</div>
									<?php $l+=1; }}else{ ?>
									<div class="form-row mt-4">
										<div class="col-12 col-sm-6">
										    	<p class="mb-0 f14">Name
        										  <span class="tool" data-tip="Your name should be the same as your name on your PAN card." tabindex="1">
        									      <i class="fas fa-question-circle f14"></i></span>
        									    </p>
											<div class="md-input">
												<input class="md-form-control" type="text" placeholder="Enter Name" name="co_name[]" title="Name of co-Applicant" required="" />
												<!--<label>Name</label>-->
												<small class="text-danger invalid"></small>
											</div>
										</div>
										<div class="col-12 col-sm-6 mt-4 mt-sm-0">
										    <p class="mb-0 f14">Relationship
        										  <span class="tool" data-tip="Fill Relationship" tabindex="1">
        									      <i class="fas fa-question-circle f14"></i></span>
        									    </p>
											<div class="md-input">
												<input class="md-form-control" placeholder="Enter Relationship" type="text" name="co_relationship[]" title="Relationship" required="" />
												<!--<label>Relationship</label>-->
												<small class="text-danger invalid"></small>
											</div>
										</div>
									</div>
									<div class="form-row mt-4">
										<div class="col-12 col-sm-6">
										     <p class="mb-0 f14">PAN Number
        										  <span class="tool" data-tip="Enter your valid PAN Number" tabindex="1">
        									      <i class="fas fa-question-circle f14"></i></span>
        									    </p>
											<div class="md-input">
												<input class="md-form-control" placeholder="Enter PAN Number" name="co_pan_number[]" type="text" title="PAN No. of co-applicant" required="" />
												<!--<label>PAN</label>-->
												<small class="text-danger other_pan_error"></small>
											</div>
										</div>
										<div class="col-12 col-sm-6 mt-4 mt-sm-0">
										      <p class="mb-0 f14">Co-applicant Pan Card
        										  <span class="tool" data-tip="Upload valid Co-applicant Pan Card" tabindex="1">
        									      <i class="fas fa-question-circle f14"></i></span>
        									  </p>
											<input type="hidden" name="getCoId[]" value="0" >
											<div class="fileUpload blue-btn btn width100"><span>Co-applicant Pan Card +</span>
												<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`ShowCoPancard`,`base_co_pancard_0`,`co_pancard_image`)"  id="co_pancard_image" class="uploadlogo" />
											</div>
											<small class="text-danger" id="other_pancard_error0"></small>
										</div>
										<div id="ShowCoPancard" style="width:100%;">
										</div>
									</div>
									<?php  } ?>
								</div>
								<input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous"/>
								<input type="button" name="next" id="next-3" class="next action-button btn btn-primary" value="Next"/>
							</fieldset>
						  
							<fieldset>
								<h3 class="multisteps-form__title">Upload Documents</h3>
								<div id="documents_field">
									<?php if($detail->business_type=='Individual'){ ?>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												<p class="mb-0 f14">PAN No.
        										  <span class="tool" data-tip="Enter your valid pan number" tabindex="1">
        									      <i class="fas fa-question-circle f14"></i></span>
        									    </p>
													<div class="md-input">
													    	<p class="mb-0 f14">PAN No.
                    										  <span class="tool" data-tip="Enter your valid pan number" tabindex="1">
                    									      <i class="fas fa-question-circle f14"></i></span>
                    									    </p>
														<input class="md-form-control" placeholder="Enter PAN Number" type="text" title="Enter PAN No." onkeyup="DataSave(this.id,this.value)"  value="<?php if(!empty($detail->pan_number)){ echo $detail->pan_number; } ?>" id="pan_number" required="" />
														<!--<label>Enter PAN No.</label>-->
														<small class="text-danger" id="pan_number_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												  <p class="mb-0 f14">Upload Pan Card
        										  <span class="tool" data-tip="Upload a valid Pan Card" tabindex="1">
        									      <i class="fas fa-question-circle f14"></i></span>
        									      </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload Pan Card +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`shownearimage21`,`base_pancard_`,`pancard_image`)"  id="pancard_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="pan_image_error"></small>
												</div>
												<div id="shownearimage21" style="width:100%;" <?php if(!empty($detail->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->pancard_image)){
														$explode=explode(',',$detail->pancard_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage21`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage21`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Business Address
            										  <span class="tool" data-tip="Enter a valid business Address of yours" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									      </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Business Address" type="text" onkeyup="DataSave(this.id,this.value)" value="<?php if(!empty($detail->business_address)){ echo $detail->business_address; } ?>" id="business_address" title="Enter Business Address" required="" />
														<!--<label>Enter Business Address</label>-->
														<small class="text-danger" id="business_address_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
													<div class="fileUpload blue-btn btn width100">
														<span>Upload +</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`shownearimage22`,`base_business_proof_`,`business_proof_image`)" id="business_proof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="business_address_proof_error"></small>
												</div>
												<div id="shownearimage22" style="width:100%;" <?php if(!empty($detail->business_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->business_address_proof)){
														$explode=explode(',',$detail->business_address_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/business/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage22`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage22`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												 <p class="mb-0 f14">Residence Address
            										  <span class="tool" data-tip="Fill the address of your residence" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									      </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Residence Address" type="text" onkeyup="DataSave(this.id,this.value)" value="<?php if(!empty($detail->business_address)){ echo $detail->business_address; } ?>" id="resident_address" title="Enter Residence Address" required="" />
														<!--<label>Enter Residence Address</label>-->
														<small class="text-danger" id="resident_address_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload +
            										  <span class="tool" data-tip="Upload address proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									         </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`shownearimage23`,`base_resident_address_`,`resident_proof_image`)" id="resident_proof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="resident_address_proof_error"></small>
												</div>
												<div id="shownearimage23" style="width:100%;" <?php if(!empty($detail->resident_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->resident_address_proof)){
														$explode=explode(',',$detail->resident_address_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/resident/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage23`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_resident_address_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage23`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_resident_address_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-9 col-sm-9">
												    <p class="mb-0 f14">UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +
            										  <span class="tool" data-tip="Upload latest minimum 6 months bank statement" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									         </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +</span>
														<input type="file" accept=".pdf" multiple onchange="ShowSelectImage(this,`shownearimage24`,`base_bankstatement_`,`bankstatement_image`)" id="bankstatement_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="bankstatement_error"></small>
												</div>
												<div class="col-3 col-sm-3">
												     <p class="mb-0 f14"> PDF Password (Optional)
            										  <span class="tool" data-tip="Enter PDF Password (Optional)" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter PDF Password (Optional)" value="<?php if(!empty($detail->bankstatement_password)){ echo $$detail->bankstatement_password; } ?>" id="bankstatement_password">
														<!--<label>PDF Password (Optional)</label>-->
													</div>
												</div>
												<div id="shownearimage24" style="width:100%;" <?php if(!empty($detail->bank_statement)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->bank_statement)){
														$explode=explode(',',$detail->bank_statement);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/bankstatement/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage24`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage24`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD ITR (OPTIONAL)  +
            										  <span class="tool" data-tip="Upload ITR (optional) in format .png, .jpeg, .jpg, .pdf, .doc, .docx" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									         </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD ITR (OPTIONAL) +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage1`,`base_itr_`,`itr_image`)" id="itr_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="itr_error"></small>
												</div>
												<div id="showExtraImage1" style="width:100%;" <?php if(!empty($detail->itr_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->itr_docs)){
														$explode=explode(',',$detail->itr_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/itr/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD CANCELLED CHEQUE (OPTIONAL)  +
            										  <span class="tool" data-tip="Upload cancelled cheque(optional)" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									         </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD CANCELLED CHEQUE (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage2`,`base_canceled_cheque_`,`canceled_cheque`)" id="canceled_cheque" class="uploadlogo" />
													</div>
													<small class="text-danger" id="cheque_error"></small>
												</div>
												<div id="showExtraImage2" style="width:100%;" <?php if(!empty($detail->cheque_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->cheque_docs)){
														$explode=explode(',',$detail->cheque_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/canceled_cheque/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD OTHER DOCS (OPTIONAL)  +
            										  <span class="tool" data-tip="Upload other docs (optional) in .png, .jpeg, .jpg, .pdf, .doc, .docx format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									         </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD OTHER DOCS (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage3`,`base_additional_docs_`,`additiona_docs`)" id="additiona_docs" class="uploadlogo" />
													</div>
													<small class="text-danger" id="additionaldocs_error"></small>
												</div>
												<div id="showExtraImage3" style="width:100%;" <?php if(!empty($detail->additional_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->additional_docs)){
														$explode=explode(',',$detail->additional_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/addition_docs/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
										<?php }elseif($detail->business_type=='Proprietorship'){ ?>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Firm's PAN No.
            										  <span class="tool" data-tip="Enter your valid firm's pan number" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Firm's PAN No." type="text" onkeyup="DataSave(this.id,this.value)"  value="<?php if(!empty($detail->pan_number)){ echo $detail->pan_number; } ?>" id="pan_number" title="Enter Firm's PAN No." required="" />
														<!--<label>Enter Firm's PAN No.</label>-->
														<small class="text-danger" id="pan_number_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload Pan Card
            										  <span class="tool" data-tip=">Upload a valid Pan Card" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload Pan Card +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`shownearimage31`,`base_pancard_`,`pancard_image`)"  id="pancard_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="pan_image_error"></small>
												</div>
												<div id="shownearimage31" style="width:100%;" <?php if(!empty($detail->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->pancard_image)){
														$explode=explode(',',$detail->pancard_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage31`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage31`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Firm's GST Number
            										  <span class="tool" data-tip=">Enter valid firm's GST number" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Firm's GST Number" onkeyup="DataSave(this.id,this.value)" value="<?php if(!empty($detail->gst_number)){ echo $detail->gst_number; } ?>"  type="text" id="gstnumber" title="Enter Firm's GST Number" required="" />
														<!--<label>Enter Firm's GST Number</label>-->
														<small class="text-danger" id="gstnumber_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload GST Registration 
            										  <span class="tool" data-tip=">Upload your GST registration " tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload GST Registration +</span><input multiple type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage32`,`base_gstnumber_`,`gstproof_image`)" id="gstproof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="gst_proof_error"></small> 
												</div>
												
												<div id="shownearimage32" style="width:100%;" <?php if(!empty($detail->gstproof_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->gstproof_image)){
														$explode=explode(',',$detail->gstproof_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/gst/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage32`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_gstnumber_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage32`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_gstnumber_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Business Address
            										  <span class="tool" data-tip=">Please fill the valid Business address of yours" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Business Address" onkeyup="DataSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->business_address)){ echo $detail->business_address; } ?>" id="business_address" title="Enter Business Address" required="" />
														<!--<label>Enter Business Address</label>-->
														<small class="text-danger" id="business_address_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload
            										  <span class="tool" data-tip=">Upload business proof image in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload +</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage33`,`base_business_proof_`,`business_proof_image`)" id="business_proof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="business_address_proof_error"></small>
												</div>
												<div id="shownearimage33" style="width:100%;" <?php if(!empty($detail->business_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->business_address_proof)){
														$explode=explode(',',$detail->business_address_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/business/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage33`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage33`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Residence Address
            										  <span class="tool" data-tip=">Please fill the valid residence address" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Residence Address" onkeyup="DataSave(this.id,this.value)" value="<?php if(!empty($detail->resident_address)){ echo $detail->resident_address; } ?>" type="text" id="resident_address" title="Enter Residence Address" required="" />
														<!--<label>Enter Residence Address</label>-->
														<small class="text-danger" id="resident_address_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload +
            										  <span class="tool" data-tip=">Please upload resident address proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload +</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage34`,`base_resident_address_`,`resident_proof_image`)" id="resident_proof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="resident_address_proof_error"></small>
												</div>
												
												<div id="shownearimage34" style="width:100%;" <?php if(!empty($detail->resident_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->resident_address_proof)){
														$explode=explode(',',$detail->resident_address_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/resident/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage34`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_resident_address_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage34`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_resident_address_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-9 col-sm-9">
												    <p class="mb-0 f14">UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT
            										  <span class="tool" data-tip=">Please upload latest minimum 6 months bank statement in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +</span>
														<input type="file" accept=".pdf" multiple onchange="ShowSelectImage(this,`shownearimage35`,`base_bankstatement_`,`bankstatement_image`)" id="bankstatement_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="bankstatement_error"></small>
												</div>
												<div class="col-3 col-sm-3">
												    <p class="mb-0 f14">PDF Password (Optional)
            										  <span class="tool" data-tip=">Enter PDF Password (Optional) " tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" value="<?php if(!empty($detail->bankstatement_password)){ echo $$detail->bankstatement_password; } ?>" id="bankstatement_password">
														<!--<label>PDF Password (Optional)</label>-->
													</div>
												</div>
												<div id="shownearimage35" style="width:100%;" <?php if(!empty($detail->bank_statement)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->bank_statement)){
														$explode=explode(',',$detail->bank_statement);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/bankstatement/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage35`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage35`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD ITR (OPTIONAL)
            										  <span class="tool" data-tip=">Please upload ITR in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD ITR (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage1`,`base_itr_`,`itr_image`)" id="itr_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="itr_error"></small>
												</div>
												<div id="showExtraImage1" style="width:100%;" <?php if(!empty($detail->itr_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->itr_docs)){
														$explode=explode(',',$detail->itr_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/itr/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD CANCELLED CHEQUE (OPTIONAL) 
            										  <span class="tool" data-tip=">Please upload cancelled cheque in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD CANCELLED CHEQUE (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage2`,`base_canceled_cheque_`,`canceled_cheque`)" id="canceled_cheque" class="uploadlogo" />
													</div>
													<small class="text-danger" id="cheque_error"></small>
												</div>
												<div id="showExtraImage2" style="width:100%;" <?php if(!empty($detail->cheque_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->cheque_docs)){
														$explode=explode(',',$detail->cheque_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/canceled_cheque/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												    <p class="mb-0 f14">UPLOAD OTHER DOCS (OPTIONAL) 
            										  <span class="tool" data-tip=">Please upload other docs in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD OTHER DOCS (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage3`,`base_additional_docs_`,`additiona_docs`)" id="additiona_docs" class="uploadlogo" />
													</div>
													<small class="text-danger" id="additionaldocs_error"></small>
												</div>
												<div id="showExtraImage3" style="width:100%;" <?php if(!empty($detail->additional_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->additional_docs)){
														$explode=explode(',',$detail->additional_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/addition_docs/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
										<?php }elseif($detail->business_type=='Partnership'){ ?>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Firm's PAN No.
            										  <span class="tool" data-tip=">Enter a valid firm's pan number" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Firm's PAN No." type="text" onkeyup="DataSave(this.id,this.value)"  value="<?php if(!empty($detail->pan_number)){ echo $detail->pan_number; } ?>" id="pan_number" title="Enter Firm's PAN No." required="" />
														<!--<label>Enter Firm's PAN No.</label>-->
														<small class="text-danger" id="pan_number_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload Pan Card
            										  <span class="tool" data-tip=">Upload a valid Pan Card" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload Pan Card</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`shownearimage10`,`base_pancard_`,`pancard_image`)"  id="pancard_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="pan_image_error"></small>
												</div>
												<div id="shownearimage10" style="width:100%;" <?php if(!empty($detail->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->pancard_image)){
														$explode=explode(',',$detail->pancard_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage10`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage10`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Firm's GST Number
            										  <span class="tool" data-tip=">Enter a validn firm's GST number" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Firm's GST Number" onkeyup="DataSave(this.id,this.value)" value="<?php if(!empty($detail->gst_number)){ echo $detail->gst_number; } ?>"  type="text" id="gstnumber" title="Enter Firm's GST Number" required="" />
														<!--<label>Enter Firm's GST Number</label>-->
														<small class="text-danger" id="gstnumber_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												    <p class="mb-0 f14">Upload GST Registration
            										  <span class="tool" data-tip=">Upload a valid GST registration in png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload GST Registration</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage11`,`base_gstnumber_`,`gstproof_image`)" id="gstproof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="gst_proof_error"></small>
												</div>
							
												<div id="shownearimage11" style="width:100%;" <?php if(!empty($detail->gstproof_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->gstproof_image)){
														$explode=explode(',',$detail->gstproof_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/gst/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage11`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_gstnumber_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage11`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_gstnumber_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												    <p class="mb-0 f14">Business Address
            										  <span class="tool" data-tip=">Enter your valid business address" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Business Address" onkeyup="DataSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->business_address)){ echo $detail->business_address; } ?>" id="business_address" title="Enter Business Address" required="" />
														<!--<label>Enter Business Address</label>-->
														<small class="text-danger" id="business_address_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">Upload
            										  <span class="tool" data-tip=">Upload business address proof image" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage12`,`base_business_proof_`,`business_proof_image`)" id="business_proof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="business_address_proof_error"></small>
												</div>
							
												<div id="shownearimage12" style="width:100%;" <?php if(!empty($detail->business_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->business_address_proof)){
														$explode=explode(',',$detail->business_address_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/business/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage12`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage12`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-9 col-sm-9">
												     <p class="mb-0 f14">UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT
            										  <span class="tool" data-tip=">Upload latest minimum 6 months bank statement in pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT</span>
														<input type="file" accept=".pdf" multiple onchange="ShowSelectImage(this,`shownearimage13`,`base_bankstatement_`,`bankstatement_image`)" id="bankstatement_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="bankstatement_error"></small>
												</div>
												<div class="col-3 col-sm-3">
													<div class="md-input">
														<input class="md-form-control" value="<?php if(!empty($detail->bankstatement_password)){ echo $$detail->bankstatement_password; } ?>" id="bankstatement_password">
														<label>PDF Password (Optional)</label>
													</div>
												</div>
												<div id="shownearimage13" style="width:100%;" <?php if(!empty($detail->bank_statement)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->bank_statement)){
														$explode=explode(',',$detail->bank_statement);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/bankstatement/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage13`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage13`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">Upload Ownership Proof
            										  <span class="tool" data-tip=">Upload ownership proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<div class="fileUpload blue-btn btn width100">
															<span>Upload Ownership Proof</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage14`,`base_ownership_`,`ownershipproof_image`)" id="ownershipproof_image" class="uploadlogo" />
														</div>
														<small class="text-danger" id="ownershipproof_error"></small>
													</div>
												</div>
												
												<div id="shownearimage14" style="width:100%;" <?php if(!empty($detail->ownership_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->ownership_proof)){
														$explode=explode(',',$detail->ownership_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/ownership/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage14`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_ownership_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage14`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_ownership_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">Upload Partnership Dead Proof
            										  <span class="tool" data-tip=">Upload partnership dead proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload Partnership Dead Proof</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage15`,`base_partnership_`,`partnershipdeal_image`)" id="partnershipdeal_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="partnershipdeal_error"></small>
												</div>
												
												<div id="shownearimage15" style="width:100%;" <?php if(!empty($detail->partnership_deal)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->partnership_deal)){
														$explode=explode(',',$detail->partnership_deal);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/partnership/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage15`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_partnership_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage15`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_partnership_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD ITR (OPTIONAL) 
            										  <span class="tool" data-tip=">Upload ITR (optional) in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD ITR (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage1`,`base_itr_`,`itr_image`)" id="itr_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="itr_error"></small>
												</div>
												<div id="showExtraImage1" style="width:100%;" <?php if(!empty($detail->itr_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->itr_docs)){
														$explode=explode(',',$detail->itr_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/itr/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD CANCELLED CHEQUE (OPTIONAL) 
            										  <span class="tool" data-tip=">Upload cancelled cheque (optional) in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD CANCELLED CHEQUE (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage2`,`base_canceled_cheque_`,`canceled_cheque`)" id="canceled_cheque" class="uploadlogo" />
													</div>
													<small class="text-danger" id="cheque_error"></small>
												</div>
												<div id="showExtraImage2" style="width:100%;" <?php if(!empty($detail->cheque_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->cheque_docs)){
														$explode=explode(',',$detail->cheque_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/canceled_cheque/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												    <p class="mb-0 f14">UPLOAD OTHER DOCS (OPTIONAL)
            										  <span class="tool" data-tip=">Upload other docs (optional) in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD OTHER DOCS (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage3`,`base_additional_docs_`,`additiona_docs`)" id="additiona_docs" class="uploadlogo" />
													</div>
													<small class="text-danger" id="additionaldocs_error"></small>
												</div>
												<div id="showExtraImage3" style="width:100%;" <?php if(!empty($detail->additional_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->additional_docs)){
														$explode=explode(',',$detail->additional_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/addition_docs/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-2 condition_type_of_firm">
												<div class="col-12 col-sm-12"><h3>Partner Docs</h3></div>
											</div>
											<div id="add_partner_doc_field">
												<?php $i=10000000; if(!empty($detail->total_director_partner)){ for($j=0;$j<$detail->total_director_partner;$j++){ ?>
													<div>
														<hr />
														<div class="form-row mt-1">
															<div class="col-12 col-sm-6">
															    <p class="mb-0 f14">partner name
                        										  <span class="tool" data-tip=">Enter partner name" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="md-input">
																	<input class="md-form-control" placeholder="Enter partner name" type="text" value="<?php if(!empty($partner[$j]) && !empty($partner[$j]->name)){ echo $partner[$j]->name; } ?>" name="other_name[]" title="Enter partner name" required="" />
																	<!--<label>Enter partner name</label>-->
																	<small class="text-danger invalid"></small>
																</div>
															</div>
															<div class="col-12 col-sm-6 mt-4 mt-sm-0">
																<div class="fileUpload blue-btn btn width100">
																	<span>Upload Proof</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" name="other_nameproof_image[]" onchange="ShowSelectImage(this,`shownearimage<?php echo $i; ?>`,`other_name_proof<?php echo $j; ?>`)" id="other_name_proof<?php echo $j; ?>" class="uploadlogo" />
																</div>
																<small class="text-danger" id="nameerror<?php echo $j; ?>"></small>
																<div id="shownearimage<?php  echo $i;?>" style="width:100%;" <?php if(!empty($partner[$j]) && !empty($partner[$j]->director_partner_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
																	<?php if(!empty($partner[$j]->director_partner_proof)){
																			$explode=explode(',',$partner[$j]->director_partner_proof);
																			foreach($explode as $file){
																				$extension = pathinfo($file,PATHINFO_EXTENSION);
																				$randid=rand(111111111,999999999);
																				if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
																		?>
																			<div class="m-2">
																				<a href="javascript:void(0)">
																					<img
																						class="img-preview-thumb"
																						onclick="ShowLargeImage(this.src)"
																						id="<?php echo $randid; ?>"
																						src="<?php echo base_url('uploads/merchant/other/'.$file); ?>"
																					/>
																				</a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>image"
																					name="other_name_proof<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php }else{ ?>
																			<div class="m-2 img-preview-thumb">
																				<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>"
																					name="other_name_proof<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php  }}} $i+=1; ?>
																	</div>
															</div>
														</div>
														<div class="form-row mt-4">
															<div class="col-12 col-sm-6">
															     <p class="mb-0 f14">Partner PAN No.
                        										  <span class="tool" data-tip=">Enter a valid pan number of your partner" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="md-input">
																	<input class="md-form-control" placeholder="Enter partner PAN No." value="<?php if(!empty($partner[$j]) && !empty($partner[$j]->pan_number)){ echo $partner[$j]->pan_number; } ?>"  type="text" name="other_pan_number[]" title="Enter partner PAN No." required="" />
																	<label>Enter partner PAN No.</label>
																	<small class="text-danger invalid"></small>
																</div>
															</div>
															<div class="col-12 col-sm-6 mt-4 mt-sm-0">
															     <p class="mb-0 f14">Partner Pan Card
                        										  <span class="tool" data-tip=">Upload a Partner Pan Card in format png, .jpeg, .jpg, .doc, .docx, .pdf" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="fileUpload blue-btn btn width100">
																	<span>Upload Partner Pan Card</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" name="other_pancard_image[]" onchange="ShowSelectImage(this,`shownearimage<?php echo $i; ?>`,`other_pancard<?php echo $j; ?>`)" id="other_pancard<?php echo $j; ?>" class="uploadlogo" />
																</div>
																<small class="text-danger" id="panerror<?php echo $j; ?>"></small>
																<div id="shownearimage<?php echo $i;?>" style="width:100%;" <?php if(!empty($partner[$j]) && !empty($partner[$j]->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
																	<?php if(!empty($partner[$j]->pancard_image)){
																			$explode=explode(',',$partner[$j]->pancard_image);
																			foreach($explode as $file){
																				$extension = pathinfo($file,PATHINFO_EXTENSION);
																				$randid=rand(111111111,999999999);
																				if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
																		?>
																			<div class="m-2">
																				<a href="javascript:void(0)">
																					<img
																						class="img-preview-thumb"
																						onclick="ShowLargeImage(this.src)"
																						id="<?php echo $randid; ?>"
																						src="<?php echo base_url('uploads/merchant/other/'.$file); ?>"
																					/>
																				</a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>image"
																					name="other_pancard<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php }else{ ?>
																			<div class="m-2 img-preview-thumb">
																				<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>"
																					name="other_pancard<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php  }}} $i+=1; ?>
																	</div>
															</div>
														</div>
														<div class="form-row mt-4">
															<div class="col-12 col-sm-6">
															    <p class="mb-0 f14">Partner Address
                        										  <span class="tool" data-tip=">Enter your partner address" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="md-input">
																	<input class="md-form-control" placeholder="Enter partner Address"value="<?php if(!empty($partner[$j]) && !empty($partner[$j]->address)){ echo $partner[$j]->address; } ?>" type="text" name="other_address[]" title="Enter partner Address" required="" />
																	<!--<label>Enter partner Address</label>-->
																	<small class="text-danger invalid"></small>
																</div>
															</div>
															<div class="col-12 col-sm-6 mt-4 mt-sm-0">
															    <p class="mb-0 f14">Partner Address Proof
                        										  <span class="tool" data-tip=">Upload Partner Address Proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="fileUpload blue-btn btn width100">
																	<span>Upload Partner Address Proof</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage<?php echo $i; ?>`,`other_address<?php echo $j; ?>`)" id="other_address<?php echo $j; ?>" name="other_address_proof[]" class="uploadlogo" />
																</div>
																<small class="text-danger" id="addresserror<?php echo $j; ?>"></small>
																<div id="shownearimage<?php  echo $i;?>" style="width:100%;" <?php if(!empty($partner[$j]) && !empty($partner[$j]->address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
																	<?php if(!empty($partner[$j]->address_proof)){
																			$explode=explode(',',$partner[$j]->address_proof);
																			foreach($explode as $file){
																				$extension = pathinfo($file,PATHINFO_EXTENSION);
																				$randid=rand(111111111,999999999);
																				if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
																		?>
																			<div class="m-2">
																				<a href="javascript:void(0)">
																					<img
																						class="img-preview-thumb"
																						onclick="ShowLargeImage(this.src)"
																						id="<?php echo $randid; ?>"
																						src="<?php echo base_url('uploads/merchant/other/'.$file); ?>"
																					/>
																				</a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>image"
																					name="other_address<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php }else{ ?>
																			<div class="m-2 img-preview-thumb">
																				<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>"
																					name="other_address<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php  }}}  $i+=1;  ?>
																	</div>
															</div>
														</div>
													</div>

												<?php }} ?>
											</div>
										<?php }else{ ?>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Firm's PAN No.
            										  <span class="tool" data-tip=">Enter Firm's PAN No." tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control"placeholder="Enter Firm's PAN No." type="text" onkeyup="DataSave(this.id,this.value)"  value="<?php if(!empty($detail->pan_number)){ echo $detail->pan_number; } ?>" id="pan_number" title="Enter Firm's PAN No." required="" />
														<!--<label>Enter Firm's PAN No.<label>-->
														<small class="text-danger" id="pan_number_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												    <p class="mb-0 f14">Upload Pan Card
            										  <span class="tool" data-tip=">Upload Pan Card in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload Pan Card</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple onchange="ShowSelectImage(this,`shownearimage1`,`base_pancard_`,`pancard_image`)"  id="pancard_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="pan_image_error"></small>
												</div>
												<div id="shownearimage1" style="width:100%;" <?php if(!empty($detail->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->pancard_image)){
														$explode=explode(',',$detail->pancard_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_pancard_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Firm's GST Number
            										  <span class="tool" data-tip=">Enter Firm's GST Number" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Firm's GST Number" onkeyup="DataSave(this.id,this.value)" value="<?php if(!empty($detail->gst_number)){ echo $detail->gst_number; } ?>"  type="text" id="gstnumber" title="Enter Firm's GST Number" required="" />
														<!--<label>Enter Firm's GST Number</label>-->
														<small class="text-danger" id="gstnumber_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												     <p class="mb-0 f14">GST Registration
            										  <span class="tool" data-tip=">Upload GST Registration in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload GST Registration</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage2`,`base_gstnumber_`,`gstproof_image`)" id="gstproof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="gst_proof_error"></small>
												</div>
											
												<div id="shownearimage2" style="width:100%;" <?php if(!empty($detail->gstproof_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite" >
													<?php if(!empty($detail->gstproof_image)){
														$explode=explode(',',$detail->gstproof_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/gst/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_gstnumber_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_gstnumber_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-6">
												     <p class="mb-0 f14">Business Address
            										  <span class="tool" data-tip=">Enter a valid business address" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter Business Address" onkeyup="DataSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->business_address)){ echo $detail->business_address; } ?>" id="business_address" title="Enter Business Address" required="" />
														<!--<label>Enter Business Address</label>-->
														<small class="text-danger" id="business_address_error"></small>
													</div>
												</div>
												<div class="col-12 col-sm-6 mt-4 mt-sm-0">
												    <p class="mb-0 f14">Upload
            										  <span class="tool" data-tip=">Upload business address proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage3`,`base_business_proof_`,`business_proof_image`)" id="business_proof_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="business_address_proof_error"></small>
												</div>
												<div id="shownearimage3" style="width:100%;" <?php if(!empty($detail->business_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->business_address_proof)){
														$explode=explode(',',$detail->business_address_proof);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/business/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_business_proof_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">Upload MOA/AOA
            										  <span class="tool" data-tip=">Upload MOA/AOA in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload MOA/AOA</span>
														<input type="file" accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" multiple id="tan_image" onchange="ShowSelectImage(this,`shownearimage4`,`base_tan_`,`tan_image`)" class="uploadlogo" />
													</div>
													<small class="text-danger" id="tan_image_error"></small>
												</div>
	
												<div id="shownearimage4" style="width:100%;" <?php if(!empty($detail->tan_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->tan_image)){
														$explode=explode(',',$detail->tan_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/tan/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage4`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_tan_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage4`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_tan_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												    <p class="mb-0 f14">Upload COI of Firm
            										  <span class="tool" data-tip=">Upload COI of Firm in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100"><span>Upload COI of Firm</span>
														<input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage5`,`base_coi_firm_`,`coi_image`)" id="coi_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="coi_error"></small>
												</div>
												
												<div id="shownearimage5" style="width:100%;" <?php if(!empty($detail->coi_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->coi_image)){
														$explode=explode(',',$detail->coi_image);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/coi/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage5`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_coi_firm_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage5`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_coi_firm_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-9 col-sm-9">
												    <p class="mb-0 f14">UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT
            										  <span class="tool" data-tip=">Upload latest minimum 6 months bank statement in .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT</span>
														<input type="file" accept=".pdf" multiple onchange="ShowSelectImage(this,`shownearimage6`,`base_bankstatement_`,`bankstatement_image`)" id="bankstatement_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="bankstatement_error"></small>
												</div>
												<div class="col-3 col-sm-3">
												     <p class="mb-0 f14">PDF Password (Optional)
            										  <span class="tool" data-tip=">Enter PDF Password (Optional)" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="md-input">
														<input class="md-form-control" placeholder="Enter PDF Password (Optional)" value="<?php if(!empty($detail->bankstatement_password)){ echo $$detail->bankstatement_password; } ?>" id="bankstatement_password">
														<!--<label>PDF Password (Optional)</label>-->
													</div>
												</div>
												<div id="shownearimage6" style="width:100%;" <?php if(!empty($detail->bank_statement)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->bank_statement)){
														$explode=explode(',',$detail->bank_statement);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/bankstatement/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage6`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage6`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_bankstatement_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												      <p class="mb-0 f14">Upload Board Resolution for signing authority
            										  <span class="tool" data-tip=">Upload board resolution for signing authority in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>Upload Board Resolution for signing authority</span>
														<input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" onchange="ShowSelectImage(this,`shownearimage7`,`base_resolution_`,`boardresolution_image`)" id="boardresolution_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="board_resolution_error"></small>
												</div>
												<div id="shownearimage7" style="width:100%;" <?php if(!empty($detail->boardresolution)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->boardresolution)){
														$explode=explode(',',$detail->boardresolution);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/boardresolution/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage7`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_resolution_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage7`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_resolution_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD ITR (OPTIONAL)
            										  <span class="tool" data-tip=">Upload ITR(optional) in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
												`	<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD ITR (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage1`,`base_itr_`,`itr_image`)" id="itr_image" class="uploadlogo" />
													</div>
													<small class="text-danger" id="itr_error"></small>
												</div>
												<div id="showExtraImage1" style="width:100%;" <?php if(!empty($detail->itr_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->itr_docs)){
														$explode=explode(',',$detail->itr_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/itr/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage1`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_itr_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD CANCELLED CHEQUE (OPTIONAL)
            										  <span class="tool" data-tip=">Upload cancelled cheque (optional) in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD CANCELLED CHEQUE (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage2`,`base_canceled_cheque_`,`canceled_cheque`)" id="canceled_cheque" class="uploadlogo" />
													</div>
													<small class="text-danger" id="cheque_error"></small>
												</div>
												<div id="showExtraImage2" style="width:100%;" <?php if(!empty($detail->cheque_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->cheque_docs)){
														$explode=explode(',',$detail->cheque_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/canceled_cheque/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage2`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_canceled_cheque_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-4">
												<div class="col-12 col-sm-12">
												     <p class="mb-0 f14">UPLOAD OTHER DOCS (OPTIONAL) 
            										  <span class="tool" data-tip=">Upload other docs (optional) in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
            									      <i class="fas fa-question-circle f14"></i></span>
        									        </p>
													<div class="fileUpload blue-btn btn width100">
														<span>UPLOAD OTHER DOCS (OPTIONAL)  +</span>
														<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple onchange="ShowSelectImage(this,`showExtraImage3`,`base_additional_docs_`,`additiona_docs`)" id="additiona_docs" class="uploadlogo" />
													</div>
													<small class="text-danger" id="additionaldocs_error"></small>
												</div>
												<div id="showExtraImage3" style="width:100%;" <?php if(!empty($detail->additional_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
												<?php if(!empty($detail->additional_docs)){
														$explode=explode(',',$detail->additional_docs);
														foreach($explode as $file){
															$extension = pathinfo($file,PATHINFO_EXTENSION);
															$randid=rand(111111111,999999999);
															if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
													?>
														<div class="m-2">
															<a href="javascript:void(0)">
																<img
																	class="img-preview-thumb"
																	onclick="ShowLargeImage(this.src)"
																	id="<?php echo $randid; ?>"
																	src="<?php echo base_url('uploads/merchant/addition_docs/'.$file); ?>"
																/>
															</a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>image"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }else{ ?>
														<div class="m-2 img-preview-thumb">
															<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
															<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`showExtraImage3`)">×</a>
															<input
																type="hidden"
																id="<?php echo $randid; ?>"
																name="base_additional_docs_[]"
																value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
															/>
														</div>
													<?php }}} ?>
												</div>
											</div>
											<div class="form-row mt-2 condition_type_of_firm">
												<div class="col-12 col-sm-12"><h3>Director Docs</h3></div>
											</div>
											<div id="add_director_doc_field">
												<?php $i=100000000; if(!empty($detail->total_director_partner)){ for($j=0;$j<$detail->total_director_partner;$j++){  ?>
													<div>
														<hr />
														<div class="form-row mt-1">
															<div class="col-12 col-sm-12">
															    <p class="mb-0 f14">Enter Director Name
                        										  <span class="tool" data-tip=">Please enter the director name" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<input class="md-form-control" placeholder="Enter director name" value="<?php if(!empty($partner[$j]) && !empty($partner[$j]->name)){ echo $partner[$j]->name; } ?>" type="text" name="other_name[]" required="" />
																<!--<label>Enter director name</label>-->
																<small class="text-danger invalid"></small>
															</div>
									
														</div>
														<div class="form-row mt-4">
															<div class="col-12 col-sm-6">
															     <p class="mb-0 f14">Director Pan No.
                        										  <span class="tool" data-tip=">Enter Director Pan number" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="md-input">
																	<input class="md-form-control" placeholder="Enter Director Pan No." value="<?php if(!empty($partner[$j]) && !empty($partner[$j]->pan_number)){ echo $partner[$j]->pan_number; } ?>"  type="text" name="other_pan_number[]" title="Enter Director Pan No." required="" />
																	<!--<label>Enter Director Pan No.<label>-->
																	<small class="text-danger invalid"></small>
																</div>
															</div>
															<div class="col-12 col-sm-6 mt-4 mt-sm-0">
															     <p class="mb-0 f14">Upload Director Pan Card
                        										  <span class="tool" data-tip=">Upload director Pan card in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="fileUpload blue-btn btn width100">
																	<span>Upload Director Pan Card</span><input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" name="other_pancard_image[]" onchange="ShowSelectImage(this,`shownearimage<?php echo $i; ?>`,`other_pancard<?php echo $j; ?>`)" id="other_pancard<?php echo $j; ?>" class="uploadlogo" />
																</div>
																<small class="text-danger" id="panerror<?php echo $j; ?>"></small>
																<div id="shownearimage<?php echo $i;?>" style="width:100%;" <?php if(!empty($partner[$j]) && !empty($partner[$j]->pancard_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
																	<?php if(!empty($partner[$j]->pancard_image)){
																			$explode=explode(',',$partner[$j]->pancard_image);
																			foreach($explode as $file){
																				$extension = pathinfo($file,PATHINFO_EXTENSION);
																				$randid=rand(111111111,999999999);
																				if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
																		?>
																			<div class="m-2">
																				<a href="javascript:void(0)">
																					<img
																						class="img-preview-thumb"
																						onclick="ShowLargeImage(this.src)"
																						id="<?php echo $randid; ?>"
																						src="<?php echo base_url('uploads/merchant/other/'.$file); ?>"
																					/>
																				</a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>image"
																					name="other_pancard<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php }else{ ?>
																			<div class="m-2 img-preview-thumb">
																				<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>"
																					name="other_pancard<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php  }}}  $i+=1; ?>
																	</div>
															</div>
														</div>
														<div class="form-row mt-4">
															<div class="col-12 col-sm-6">
															     <p class="mb-0 f14">Director Address
                        										  <span class="tool" data-tip=">Upload director Pan card in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="md-input">
																	<input class="md-form-control" placeholder="Enter Director Address" value="<?php if(!empty($partner[$j]) && !empty($partner[$j]->address)){ echo $partner[$j]->address; } ?>"  type="text" name="other_address[]" title="Enter Director Address" required="" />
																	<!--<label>Enter Director Address</label>-->
																	<small class="text-danger invalid"></small>
																</div>
															</div>
															<div class="col-12 col-sm-6 mt-4 mt-sm-0">
															    <p class="mb-0 f14">Upload Director Address Proof
                        										  <span class="tool" data-tip=">Upload director address proof in .png, .jpeg, .jpg, .doc, .docx, .pdf format" tabindex="1">
                        									      <i class="fas fa-question-circle f14"></i></span>
                    									        </p>
																<div class="fileUpload blue-btn btn width100">
																	<span>Upload Director Address Proof</span>
																	<input type="file" multiple accept=".png, .jpeg, .jpg, .doc, .docx, .pdf" name="other_address_proof[]" onchange="ShowSelectImage(this,`shownearimage<?php echo $i; ?>`,`other_address<?php echo $j; ?>`)" id="other_address<?php echo $j; ?>" class="uploadlogo" />
																</div>
																<small class="text-danger" id="addresserror<?php echo $j; ?>"></small>
																<div id="shownearimage<?php  echo $i;?>" style="width:100%;" <?php if(!empty($partner[$j]) && !empty($partner[$j]->address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
																	<?php if(!empty($partner[$j]->address_proof)){
																			$explode=explode(',',$partner[$j]->address_proof);
																			foreach($explode as $file){
																				$extension = pathinfo($file,PATHINFO_EXTENSION);
																				$randid=rand(111111111,999999999);
																				if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
																		?>
																			<div class="m-2">
																				<a href="javascript:void(0)">
																					<img
																						class="img-preview-thumb"
																						onclick="ShowLargeImage(this.src)"
																						id="<?php echo $randid; ?>"
																						src="<?php echo base_url('uploads/merchant/other/'.$file); ?>"
																					/>
																				</a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>image"
																					name="other_address<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php }else{ ?>
																			<div class="m-2 img-preview-thumb">
																				<a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> document.<?php echo $extension; ?></a>
																				<a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage<?php echo $i; ?>`)">×</a>
																				<input
																					type="hidden"
																					id="<?php echo $randid; ?>"
																					name="other_address<?php echo $j; ?>[]"
																					value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
																				/>
																			</div>
																		<?php  }}} $i+=1; ?>
																	</div>
															</div>
														</div>
													</div>
												<?php }} ?>
											</div>
										<?php } ?>
								</div>
								<input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous"/>
								<input type="button" name="submit" id="next-4" class="next submit action-button btn btn-primary" value="Next"/>
							</fieldset>
							
							<fieldset>
								<h3 class="multisteps-form__title">Reference</h3>
								<div class="form-row mt-4">		
									<div class="col-12 col-sm-6">
									     <p class="mb-0 f14">Reference Name
										  <span class="tool" data-tip="Please fill reference name" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								        </p>
										<div class="md-input">
											<input class="md-form-control" placeholder="Enter Reference Name" id="reference" type="text" title="Reference Name" required=""/>
											<!--<label>Reference Name<label>-->
											<small id="reference_error" class="text-danger"></small>
										</div>
									</div>
									<div class="col-12 col-sm-6 mt-4 mt-sm-0">
									     <p class="mb-0 f14">Reference Mobile Number
										  <span class="tool" data-tip="Please fill reference mobile number" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								        </p>
										<div class="md-input">
											<input class="md-form-control" placeholder="Enter Reference Mobile Number" maxlength="10" id="reference_number" title="Reference Mobile Number" type="text" required=""/>
											<!--<label>Reference Mobile Number<label>-->
											<small id="refernece_number_error" class="text-danger"></small>
										</div>
									</div>
								</div>
								<input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous"/>
								<button type="button" name="submit" id="next-5" class="next submit action-button btn btn-primary">
									Submit
									<span id="submitloader" >
										
									</span>
								</button>
							</fieldset>
							
						</form>
                    </div>
                </div>
				
	       </div>
		 </div>
	</section>
	<div class="modal fade" id="OpenOtpModel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modal_content">
                <div class="modal-header">
                    <h4 class="modal-title">Enter Otp</h4>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-sm-12">
                        <small id="loan_otp_errorr" class="text-danger"></small>
                        <input class="multisteps-form__input form-control" id="loan_otp" maxlength="6" type="text" placeholder="Enter Otp Here" />
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" onclick="VerifyOtp()" disabled id="disabled_btn" class="btn btn-primary">Verify Otp <span id="loan_loader"></span></button>
                    <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="LargeImageModel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modal_content">
                <div class="modal-body">
                    <div class="col-12 col-sm-12">
                        <img id="to-large-image" src="#">
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="SuccessModel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="modal_content">
                <div class="modal-body">
					<div class="alert alert-success">
						Thank you ! Your application has been successfully received. You may choose to note down the file number for further tracking of the case!
					</div>
					<?php  
						$password='';
						if(!empty($users->full_name)){
							$fullname = str_replace(' ','',$users->full_name);
							$pass_start=substr($fullname, 0, 4);
							$pass_end= preg_replace('~[+\d-](?=[\d-]{4})~', '', $mobile_number);
							$password=$pass_start.$pass_end;
						}
					?>
					<ul class="col-md-12">
						<li style="float:left"><b>File ID :</b><?php if(!empty($users->file_id)){ echo $users->file_id; } ?></li>
						<li style="float:right">Password:<?php echo $password; ?></li>
					</ul>
                </div>
				<div class="modal-footer">
					<button onclick="CloseModal()" class="btn btn-primary">CLOSE</button>
				</div>
            </div>
        </div>
    </div>
	<script>
        
        function LoanTypeLabel(){
            if(document.getElementById('loan_type1').value==''){
                document.getElementById('loan_type1_label').setAttribute('style','display:none');
                document.getElementById('loan_type1').setAttribute('style','');
            }else{
                document.getElementById('loan_type1_label').setAttribute('style','');
                document.getElementById('loan_type1').setAttribute('style','padding-top:17px;');
            }
        }
		LoanTypeLabel();
		
        function StateLabel(){
            if(document.getElementById('state').value==''){
                document.getElementById('state_label').setAttribute('style','display:none');
                document.getElementById('state').setAttribute('style','');
            }else{
                document.getElementById('state_label').setAttribute('style','');
                document.getElementById('state').setAttribute('style','padding-top:17px;');
            }
        }
		StateLabel();
		function BusinessTypeLabel(){
            if(document.getElementById('business_type').value==''){
                document.getElementById('business_type_label').setAttribute('style','display:none');
                document.getElementById('business_type').setAttribute('style','');
            }else{
                document.getElementById('business_type_label').setAttribute('style','');
                document.getElementById('business_type').setAttribute('style','padding-top:17px;');
            }
		}
		function CityLabel(){
            if(document.getElementById('city').value==''){
                document.getElementById('city_label').setAttribute('style','display:none');
                document.getElementById('city').setAttribute('style','');
            }else{
                document.getElementById('city_label').setAttribute('style','');
                document.getElementById('city').setAttribute('style','padding-top:17px;');
            }
		}
		function PincodeLabel(){
            if(document.getElementById('pincode').value==''){
                document.getElementById('pincode_label').setAttribute('style','display:none');
                document.getElementById('pincode').setAttribute('style','');
            }else{
                document.getElementById('pincode_label').setAttribute('style','');
                document.getElementById('pincode').setAttribute('style','padding-top:17px;');
            }
        }
		BusinessTypeLabel();
		function BusinessTypeLabel(){
            if(document.getElementById('business_type').value==''){
                document.getElementById('business_type_label').setAttribute('style','display:none');
                document.getElementById('business_type').setAttribute('style','');
            }else{
                document.getElementById('business_type_label').setAttribute('style','');
                document.getElementById('business_type').setAttribute('style','padding-top:17px;');
            }
        }
		BusinessTypeLabel();

		function NatureLabel(){
            if(document.getElementById('nature_of_business').value==''){
                document.getElementById('nature_of_business_label').setAttribute('style','display:none');
                document.getElementById('nature_of_business').setAttribute('style','');
            }else{
                document.getElementById('nature_of_business_label').setAttribute('style','');
                document.getElementById('nature_of_business').setAttribute('style','padding-top:17px;');
            }
        }
		NatureLabel();
		function TurnOverLabel(){
            if(document.getElementById('turn_over').value==''){
                document.getElementById('turn_over_label').setAttribute('style','display:none');
                document.getElementById('turn_over').setAttribute('style','');
            }else{
                document.getElementById('turn_over_label').setAttribute('style','');
                document.getElementById('turn_over').setAttribute('style','padding-top:17px;');
            }
        }
		TurnOverLabel();
		function DesiredAmountLabel(){
            if(document.getElementById('desired_amount').value==''){
                document.getElementById('desired_amount_label').setAttribute('style','display:none');
                document.getElementById('desired_amount').setAttribute('style','');
            }else{
                document.getElementById('desired_amount_label').setAttribute('style','');
                document.getElementById('desired_amount').setAttribute('style','padding-top:17px;');
            }
        }
		DesiredAmountLabel();
		
    </script>