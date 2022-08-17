<style>
    #progressbar li{
        width:16% !important;
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


@media all and (max-width: 991px) and (min-width: 320px) {
.dn { display:none;}
}

</style>
<section class="section-space60 bg-white full-width-loan">
    <div class="container">
        <div class="row">
            <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 offset-md-1 col-md-10 col-sm-12 col-12">
                <div class="request-form">
                    <input type="hidden" id="das_agent_id" value="57" />

                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active"><span class="dn">Additional Personal Info</span></li>
                            <li><span class="dn">Employment Information</span></li>
                            <li><span class="dn">Salary Detail</span></li>
                            <li><span class="dn">Residence Details</span></li>
                            <li><span class="dn">Upload Doc</span></li>
                            <li><span class="dn">Reference</span></li>
                        </ul>
                        <!-- fieldsets -->
                        <div id="showdocumentbar">
								
						</div>
                        <fieldset>
                            <h3 class="multisteps-form__title">Additional Personal Info</h3>
                            <input type="hidden" id="phone" value="<?php echo $mobile_number; ?>">
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-12">
                                    <p class="mb-0 f14">Your Father's Name 
										  <span class="tool" data-tip="As per your offical document records,enter your father's name" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									</p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Father's Name" onkeyup="AutoSave(this.id,this.value)" value="<?php if(!empty($detail->father_name)){ echo $detail->father_name; } ?>" title="Father's Name" id="father_name" type="text" required="" />
                                        <!--<label>Father's Name</label>-->
                                        <small class="text-danger invalid" id="father_name_error"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                    <div class="md-input">
                                    <p class="mb-0 f14">Date of Birth 
										  <span class="tool" data-tip="Your date of birth should be the same as your PAN card" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									</p>
                                        <input class="md-form-control" autocomplete="off" placeholder="Enter Date of Birth" id="date_of_birth" onkeyup="AutoSave(this.id,this.value)" onchange="AutoSave(this.id,this.value)" value="<?php if(!empty($detail->date_of_birth)){ echo date('m/d/Y',strtotime($detail->date_of_birth)); }elseif(!empty($pay1data->dob)){ echo date('m/d/Y',strtotime($pay1data->dob)); } ?>" name="birthday" type="text" title="Date of Birth" required="" />
                                        <!--<label>Date of Birth</label>-->
                                        <small class="text-danger invalid" id="date_of_birth_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                     <p class="mb-0 f14">Gender
										  <span class="tool" data-tip="Select gender form the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
									</p>
                                    <!--<label style="display:none" id="gender_label" class="accup">Gender</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);GenderLabel()" title="Gender" id="gender">
                                        <option value="">Gender</option>
                                        <option value="Male" <?php if(!empty($detail->gender) && $detail->gender=='Male'){ echo "selected"; } ?>>Male</option>
                                        <option value="Female" <?php if(!empty($detail->gender) && $detail->gender=='Female'){ echo "selected"; } ?>>Female</option>
                                        <option value="Other" <?php if(!empty($detail->gender) && $detail->gender=='MaOtherle'){ echo "selected"; } ?>>Other</option>
                                        <option value="Prefer not to disclose" <?php if(!empty($detail->gender) && $detail->gender=='Prefer not to disclose'){ echo "selected"; } ?>>Prefer not to disclose</option>
                                    </select>
                                    <small class="text-danger invalid" id="gender_error"></small>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Qualification
										  <span class="tool" data-tip="Select your qualification from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="qualification_label" class="accup">Qualification</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);QualificationLabel();" title="Qualification" id="qualification">
                                        <option value="">Qualification</option>
                                        <option value="Under Graduate" <?php if(!empty($detail->qualification) && $detail->qualification=='Under Graduate'){ echo "selected"; } ?>>Under Graduate</option>
                                        <option value="Graduate" <?php if(!empty($detail->qualification) && $detail->qualification=='Graduate'){ echo "selected"; } ?>>Graduate</option>
                                        <option value="Post Graduate" <?php if(!empty($detail->qualification) && $detail->qualification=='Post Graduate'){ echo "selected"; } ?>>Post Graduate</option>
                                    </select>
                                    <small class="text-danger invalid" id="qualification_error"></small>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Marital Status
										  <span class="tool" data-tip="Select your Marital Status" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="marital_status_label" class="accup">Marital Status</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);MaritalStatusLabel();" title="Marital Status" id="marital_status">
                                        <option value="">Marital Status</option>
                                        <option value="Married" <?php if(!empty($detail->marital_status) && $detail->marital_status=='Married'){ echo "selected"; } ?>>Married</option>
                                        <option value="Single" <?php if(!empty($detail->marital_status) && $detail->marital_status=='Single'){ echo "selected"; } ?>>Single</option>
                                        <option value="Prefer Not to Say" <?php if(!empty($detail->marital_status) && $detail->marital_status=='Prefer Not to Say'){ echo "selected"; } ?>>Prefer Not to Say</option>
                                    </select>
                                    <small class="text-danger invalid" id="marital_status_error"></small>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">Number of Kids
										  <span class="tool" data-tip="Enter your number of kids" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Number of Kids" oninput="this.value = Math.abs(this.value)" onkeyup="AutoSave(this.id,this.value)" title="Number of Kids" value="<?php if(!empty($detail->number_of_kids)){ echo $detail->number_of_kids; }elseif(!empty($detail)){ echo $detail->number_of_kids; } ?>" id="number_of_kids"  type="number" required="" />
                                        <!--<label>Number of Kids</label>-->
                                        <small class="text-danger invaild" id="number_of_kid_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Vehicle Type
										  <span class="tool" data-tip="Select your vehicle type" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="vehicle_type_label" class="accup">Vehicle Type</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);VehicleTypeLabel();" title="Vehicle Type" id="vehicle_type">
                                        <option value="">Vehicle Type</option>
                                        <option value="2 wheeler" <?php if(!empty($detail->vehicle_type) && $detail->vehicle_type=='2 wheeler'){ echo "selected"; } ?>>2 wheeler</option>
                                        <option value="4 wheeler" <?php if(!empty($detail->vehicle_type) && $detail->vehicle_type=='4 wheeler'){ echo "selected"; } ?>>4 wheeler</option>
                                        <option value="None" <?php if(!empty($detail->vehicle_type) && $detail->vehicle_type=='None'){ echo "selected"; } ?>>None</option>
                                    </select>
                                    <small class="text-danger invalid" id="vehicle_type_error"></small>
                                </div>
                            </div>
                            <input type="button" name="next" id="next-1" class="next action-button btn btn-primary" value="Next" />
                        </fieldset>

                        <fieldset>
                            <h3 class="multisteps-form__title">Employment Information</h3>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-12">
                                    <p class="mb-0 f14">Name of current employer
										  <span class="tool" data-tip="Enter the name of your current employeer as per the documents" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Name of current employer" id="employer_name" onkeyup="AutoSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->employer_name)){ echo $detail->employer_name; }elseif(!empty($pay1data->shop_name)){ echo $pay1data->shop_name; } ?>" title="Name of current employer" required="" />
                                        <!--<label>Name of current employer</label>-->
                                        <small class="text-danger invalid" id="employer_name_error"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Designation
										  <span class="tool" data-tip="Enter your designation" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter your Designation" id="designation" onkeyup="AutoSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->designation)){ echo $detail->designation; } ?>" title="Designation" required="" />
                                        <!--<label>Designation</label>-->
                                        <small class="text-danger invalid" id="designation_error"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">No. of years in current organization
										  <span class="tool" data-tip="Please fill the number of years in current organization" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter No. of years in current organization" id="organization" oninput="this.value = Math.abs(this.value)" onkeyup="AutoSave(this.id,this.value)" type="number" value="<?php if(!empty($detail->organization)){ echo $detail->organization; } ?>" title="No. of years in current organization" required="" />
                                        <!--<label>No. of years in current organization</label>-->
                                        <small class="text-danger invalid" id="organization_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Type of organization
										  <span class="tool" data-tip="Select the type of your organization" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="organization_type_label" class="accup">Type of organization</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);OtherOrganization(this.value);OrganizationTypeLabel()" title="Type of organization" id="organization_type">
                                        <option value="">Type of organization</option>
                                        <option value="Proprietorship" <?php if(!empty($detail->organization_type) && $detail->organization_type=='Proprietorship'){ echo "selected"; } ?>>Proprietorship</option>
                                        <option value="Partnership" <?php if(!empty($detail->organization_type) && $detail->organization_type=='Partnership'){ echo "selected"; } ?>>Partnership</option>
                                        <option value="Private Limited" <?php if(!empty($detail->organization_type) && $detail->organization_type=='Private Limited'){ echo "selected"; } ?>>Private Limited</option>
                                        <option value="Public Limited" <?php if(!empty($detail->organization_type) && $detail->organization_type=='Public Limited'){ echo "selected"; } ?>>Public Limited</option>
                                        <option value="Government" <?php if(!empty($detail->organization_type) && $detail->organization_type=='Government'){ echo "selected"; } ?>>Government</option>
                                        <option value="Other" <?php if(!empty($detail->organization_type) && $detail->organization_type=='Other'){ echo "selected"; } ?>>Other</option>
                                    </select>
                                    <small class="text-danger invalid" id="organization_type_error"></small>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">Total Exprience (In Year)
										  <span class="tool" data-tip="Fill the number of Total Exprience (In Year)" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="total_experience_label" class="accup">Total Exprience (In Year)</label>-->
                                    <select class="multisteps-form__input form-control" id="total_experience" onchange="AutoSave(this.id,this.value);TotalExperienceLabel();">
                                        <option value="">Total Exprience (In Year)</option>
                                        <option value="Less than 1" <?php if(!empty($detail->total_experience) && $detail->total_experience=='Less than 1'){ echo "selected"; } ?>>Less than Year</option>
                                        <option value="1" <?php if(!empty($detail->total_experience) && $detail->total_experience=='1'){ echo "selected"; } ?>>1</option>
                                        <option value="2" <?php if(!empty($detail->total_experience) && $detail->total_experience=='2'){ echo "selected"; } ?>>2</option>
                                        <option value="3" <?php if(!empty($detail->total_experience) && $detail->total_experience=='3'){ echo "selected"; } ?>>3</option>
                                        <option value="4" <?php if(!empty($detail->total_experience) && $detail->total_experience=='4'){ echo "selected"; } ?>>4</option>
                                        <option value="5" <?php if(!empty($detail->total_experience) && $detail->total_experience=='5'){ echo "selected"; } ?>>5</option>
                                        <option value="6" <?php if(!empty($detail->total_experience) && $detail->total_experience=='6'){ echo "selected"; } ?>>6</option>
                                        <option value="7" <?php if(!empty($detail->total_experience) && $detail->total_experience=='7'){ echo "selected"; } ?>>7</option>
                                        <option value="8" <?php if(!empty($detail->total_experience) && $detail->total_experience=='8'){ echo "selected"; } ?>>8</option>
                                        <option value="9"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='9'){ echo "selected"; } ?>>9</option>
                                        <option value="10"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='10'){ echo "selected"; } ?>>10</option>
                                        <option value="11" <?php if(!empty($detail->total_experience) && $detail->total_experience=='11'){ echo "selected"; } ?>>11</option>
                                        <option value="12"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='12'){ echo "selected"; } ?>>12</option>
                                        <option value="13" <?php if(!empty($detail->total_experience) && $detail->total_experience=='13'){ echo "selected"; } ?>>13</option>
                                        <option value="14"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='14'){ echo "selected"; } ?>>14</option>
                                        <option value="15"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='15'){ echo "selected"; } ?>>15</option>
                                        <option value="16"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='16'){ echo "selected"; } ?>>16</option>
                                        <option value="17"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='17'){ echo "selected"; } ?>>17</option>
                                        <option value="18"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='18'){ echo "selected"; } ?>>18</option>
                                        <option value="19" <?php if(!empty($detail->total_experience) && $detail->total_experience=='19'){ echo "selected"; } ?>>19</option>
                                        <option value="20"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='20'){ echo "selected"; } ?>>20</option>
                                        <option value="21"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='21'){ echo "selected"; } ?>>21</option>
                                        <option value="22"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='22'){ echo "selected"; } ?>>22</option>
                                        <option value="23"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='23'){ echo "selected"; } ?>>23</option>
                                        <option value="24"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='24'){ echo "selected"; } ?>>24</option>
                                        <option value="25"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='25'){ echo "selected"; } ?>>25</option>
                                        <option value="26"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='26'){ echo "selected"; } ?>>26</option>
                                        <option value="27"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='27'){ echo "selected"; } ?>>27</option>
                                        <option value="28"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='28'){ echo "selected"; } ?>>28</option>
                                        <option value="29"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='29'){ echo "selected"; } ?>>29</option>
                                        <option value="30"  <?php if(!empty($detail->total_experience) && $detail->total_experience=='30'){ echo "selected"; } ?>>30</option>
                                        <option value="Greater than 30" <?php if(!empty($detail->total_experience) && $detail->total_experience=='Greater than 30'){ echo "selected"; } ?>>Greater than 30</option>
                                    </select>
                                    <small class="text-danger invalid" id="total_experience_error"></small>
                                </div>
                                <div class="col-12 col-sm-6" id="filed_other_organization">
                                     <p class="mb-0 f14">Other organization
										  <span class="tool" data-tip="please fill the name of other organization" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <?php if(!empty($detail->organization_type) && $detail->organization_type=='Other'){ ?>
                                        <div class="md-input">
                                            <input class="md-form-control" placeholder="Enter Other organization" id="other_organization" onkeyup="AutoSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->other_organization)){ echo $detail->other_organization; } ?>" title="Other organization" required="" />
                                            <!--<label>Other organization</label>-->
                                            <small class="text-danger invalid" id="other_organization_error"></small>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--<label class="mt-4">Existing organisation address</label>-->
                            <div class="form-row mt-2">
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Building No./Plot No.
										  <span class="tool" data-tip="Fill the organisation address as per the records" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Building No./Plot No." id="company_building" onkeyup="AutoSave(this.id,this.value)" value="<?php if(!empty($detail->company_building)){ echo $detail->company_building; } ?>"  type="text" title="Building No./Plot No." required="" />
                                        <!--<label>Building No./Plot No.</label>-->
                                        <small class="text-danger invalid" id="company_building_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Locality/Area
										  <span class="tool" data-tip="Fill Locality/Area" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Locality/Area" id="company_area" onkeyup="AutoSave(this.id,this.value)" value="<?php if(!empty($detail->company_area)){ echo $detail->company_area; } ?>" type="text" title="Locality/Area" required="" />
                                        <!--<label>Locality/Area</label>-->
                                        <small class="text-danger invalid" id="company_area_error"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">State
										  <span class="tool" data-tip="Select state from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="company_state_label" class="accup">State</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);GetCompanyCityList(this.value);CompanyStateLabel();" title="State" id="company_state">
                                        <option value="">State</option>
                                            <?php foreach($states as $state){ ?>
                                            <option value="<?php echo $state->name; ?>" <?php if(!empty($detail->company_state) && $detail->company_state==$state->name){ echo 'selected'; }elseif(!empty($pay1data->shop_state) && $pay1data->shop_state==$state->name){ echo 'selected'; }  ?>><?php echo $state->name; ?></option>
                                            <?php }  ?>
                                    </select>
                                    <small class="text-danger invalid" id="company_state_error"></small>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                     <p class="mb-0 f14">City
										  <span class="tool" data-tip="Select City from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="company_city_label" class="accup">City</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);CheckCompanySelectCity(this.value);CompanyOtherCity(this.value);CompanyCityLabel()"  id="company_city" title="City">
                                        <option value="">City</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <small class="text-danger invalid" id="company_city_error"></small>
                                    <input id="company_city_hidden" type="hidden"  value="<?php if(!empty($detail->company_city)){ echo $detail->company_city; }elseif(!empty($pay1data->shop_city)){ echo $pay1data->shop_city; } ?>" />
                                    <input id="company_other_city_hidden" type="hidden"  value="<?php if(!empty($detail->company_other_city)){ echo $detail->company_other_city; }?>" />
                                </div>
                            </div>
                            <div class="form-row" id="company_other_city_field">

                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                     <p class="mb-0 f14">Official Email Address
										  <span class="tool" data-tip="Please share valid email address to ensure timely communication regarding this application." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Official Email Address" onkeyup="AutoSave(this.id,this.value)" id="company_email" type="text" title="Official Email Address" value="<?php if(!empty($detail->company_email)){ echo $detail->company_email; } ?>" required="" />
                                        <!--<label>Official Email Address</label>-->
                                        <small class="text-danger invalid" id="company_email_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Pincode
										  <span class="tool" data-tip="Please share valid pincode" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="company_pincode_label" class="accup">Pincode</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);CompanyOtherPincode(this.value);CompanyPincodeLabel();" id="company_pincode">
                                        <option value="">Pincode</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <small class="text-danger invalid" id="company_pincode_error"></small>
                                    <input type="hidden" id="company_pincode_hidden" value="<?php if(!empty($detail->company_pincode)){ echo $detail->company_pincode; }elseif(!empty($pay1data->shop_pincode)){ echo $pay1data->shop_pincode; } ?>" >
                                    <input type="hidden" id="company_other_pincode_hidden" value="<?php if(!empty($detail->company_other_pincode)){ echo $detail->company_other_pincode; } ?>" >
                                </div>
                            </div> 
                           
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">Company Website
										  <span class="tool" data-tip="Share valid Company Website link" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Company Website" onkeyup="AutoSave(this.id,this.value)" id="company_website" type="text" title="Company Website" value="<?php if(!empty($detail->company_website)){ echo $detail->company_website; } ?>" required="" />
                                        <!--<label>Company Website</label>-->
                                        <small class="text-danger invalid" id="company_website_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0" id="company_other_pincode_field">

                                </div>
                            </div>

                            <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                            <input type="button" name="next" id="next-2" class="next action-button btn btn-primary" id="next-2" value="Next" />
                        </fieldset>

                        <fieldset>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-12">
                                    <h3>
                                        Salary Details
                                    </h3>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Monthly take home
										  <span class="tool" data-tip="Share a detail about your monthly income" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Monthly Salary" onkeyup="AutoSave(this.id,this.value)" id="salery_inhand" type="number" value="<?php if(!empty($detail->salery_inhand)){ echo $detail->salery_inhand; } ?>" title="Monthly take home" required="" />
                                        <!--<label>Monthly take home</label>-->
                                        <small class="text-danger invalid" id="salery_inhand_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Mode of receiving salary
										  <span class="tool" data-tip="Select mode of receiving salary" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="salary_mode_label" class="accup">Mode of receiving salary</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);SalaryModeLabel()" title="Mode of receiving salary" id="salary_mode">
                                        <option value="">Mode of receiving salary</option>
                                        <option value="Bank account transfer" <?php if(!empty($detail->salary_mode) && $detail->salary_mode=='Bank account transfer'){ echo "selected"; } ?>>Bank account transfer</option>
                                        <option value="Cheque" <?php if(!empty($detail->salary_mode) && $detail->salary_mode=='Cheque'){ echo "selected"; } ?>>Cheque</option>
                                        <option value="Cash" <?php if(!empty($detail->salary_mode) && $detail->salary_mode=='Cash'){ echo "selected"; } ?>>Cash</option>
                                    </select>
                                    <small class="text-danger invalid" id="salary_mode_error"></small>
                                </div>
                            </div> 
                            <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                            <input type="button" name="next" id="next-3" class="next action-button btn btn-primary" value="Next" />
                        </fieldset>

                        <fieldset>
                            <h3 class="multisteps-form__title">Residence Details</h3>
                            <div class="form-row mt-2">
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Flat No./Building No./Street No.
										  <span class="tool" data-tip="Fill the details about Flat No./Building No./Street No." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Flat No./Building No./Street No." onkeyup="AutoSave(this.id,this.value)" id="residence_building" type="text" value="<?php if(!empty($detail->residence_building)){ echo $detail->residence_building; } ?>" title="Flat No./Building No./Street No." required="" />
                                        <!--<label>Flat No./Building No./Street No.</label>-->
                                        <small class="text-danger invalid" id="residence_building_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                     <p class="mb-0 f14">Locality/Area
										  <span class="tool" data-tip="Fill details about your Locality/Area." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Locality/Area" onkeyup="AutoSave(this.id,this.value)" id="residence_area" type="text" value="<?php if(!empty($detail->residence_area)){ echo $detail->residence_area; } ?>" title="Locality/Area" required="" />
                                        <!--<label>Locality/Area</label>-->
                                        <small class="text-danger invalid" id="residence_area_error"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                     <p class="mb-0 f14">State
										  <span class="tool" data-tip="select state from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="residence_state_label" class="accup">State</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);GetResidenceCityList(this.value);ResidenceStateLabel()" title="State" id="residence_state">
                                        <option value="">State</option>
                                            <?php foreach($states as $state){ ?>
                                            <option value="<?php echo $state->name; ?>" <?php if(!empty($detail->residence_state) && $detail->residence_state==$state->name){ echo 'selected'; }elseif(!empty($pay1data->state) && $pay1data->state==$state->name){ echo 'selected'; }  ?>><?php echo $state->name; ?></option>
                                            <?php }  ?>
                                    </select>
                                    <small class="text-danger invalid" id="residence_state_error"></small>
                                </div>
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">City
										  <span class="tool" data-tip="Select city from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="residence_city_label" class="accup">City</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);CheckResidenceCityList(this.value);ResidenceOtherCity(this.value);" id="residence_city" >
                                        <option value="">City</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <small class="text-danger invalid" id="residence_city_error"></small>
                                    <input type="hidden" id="residence_city_hidden" value="<?php if(!empty($detail->residence_city)){ echo $detail->residence_city; } ?>">
                                    <input type="hidden" id="residence_other_city_hidden" value="<?php if(!empty($detail->residence_other_city)){ echo $detail->residence_other_city; } ?>">
                                </div>
                            </div>
                            <div class="form-row" id="residence_other_city_field"></div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                    <!--<label style="display:none" id="residence_pincode_label" class="accup">Pincode</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);ResidenceOtherPincode(this.value);ResidencePincodeLabel();" id="residence_pincode">
                                        <option value="">Pincode</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <small class="text-danger invalid" id="residence_pincode_error"></small>
                                    <input type="hidden" id="residence_pincode_hidden" value="<?php if(!empty($detail->residence_pincode)){ echo $detail->residence_pincode; }elseif(!empty($pay1data->pincode)){ echo $pay1data->pincode; } ?>" />
                                    <input type="hidden" id="residence_other_pincode_hidden" value="<?php if(!empty($detail->residence_other_pincode)){ echo $detail->residence_other_pincode; } ?>" />
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <p class="mb-0 f14">Residence Type
										  <span class="tool" data-tip="Select your Residence Type from the given list" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="residence_type_label" class="accup">Residence Type</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);ResidenceTypeLabel()" title="Residence Type" id="residence_type">
                                        <option value="">Residence Type</option>
                                        <option value="Rented" <?php if(!empty($detail->residence_type) && $detail->residence_type=='Rented'){ echo "selected"; } ?>>Rented</option>
                                        <option value="Owned" <?php if(!empty($detail->residence_type) && $detail->residence_type=='Owned'){ echo "selected"; } ?>>Owned</option>
                                        <option value="PG" <?php if(!empty($detail->residence_type) && $detail->residence_type=='PG'){ echo "selected"; } ?>>PG</option>
                                        <option value="Company Accomodation" <?php if(!empty($detail->residence_type) && $detail->residence_type=='Company Accomodation'){ echo "selected"; } ?>>Company Accomodation</option>
                                        <option value="Staying with relatives" <?php if(!empty($detail->residence_type) && $detail->residence_type=='Staying with relatives'){ echo "selected"; } ?>>Staying with relatives</option>
                                    </select>
                                    <small class="text-danger invalid" id="residence_type_error"></small>
                                </div>
                            </div> 
                            <div class="form-row" id="residence_other_pincode_field">

                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Number of years at current residence
										  <span class="tool" data-tip="Select number of years at current residence" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <!--<label style="display:none" id="year_at_residence_label" class="accup">Number of years at current residence</label>-->
                                    <select class="multisteps-form__input form-control" onchange="AutoSave(this.id,this.value);YearAtResidenceLabel()" id="year_at_residence" title="Number of years at current residence" >
                                        <option value="">Number of years at current residence </option>
                                        <option value="Less than 1" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='Less than 1'){ echo "selected"; } ?>>Less than Year</option>
                                        <option value="1" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='1'){ echo "selected"; } ?>>1</option>
                                        <option value="2" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='2'){ echo "selected"; } ?>>2</option>
                                        <option value="3" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='3'){ echo "selected"; } ?>>3</option>
                                        <option value="4" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='4'){ echo "selected"; } ?>>4</option>
                                        <option value="5" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='5'){ echo "selected"; } ?>>5</option>
                                        <option value="6" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='6'){ echo "selected"; } ?>>6</option>
                                        <option value="7" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='7'){ echo "selected"; } ?>>7</option>
                                        <option value="8" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='8'){ echo "selected"; } ?>>8</option>
                                        <option value="9"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='9'){ echo "selected"; } ?>>9</option>
                                        <option value="10"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='10'){ echo "selected"; } ?>>10</option>
                                        <option value="11" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='11'){ echo "selected"; } ?>>11</option>
                                        <option value="12"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='12'){ echo "selected"; } ?>>12</option>
                                        <option value="13" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='13'){ echo "selected"; } ?>>13</option>
                                        <option value="14"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='14'){ echo "selected"; } ?>>14</option>
                                        <option value="15"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='15'){ echo "selected"; } ?>>15</option>
                                        <option value="16"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='16'){ echo "selected"; } ?>>16</option>
                                        <option value="17"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='17'){ echo "selected"; } ?>>17</option>
                                        <option value="18"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='18'){ echo "selected"; } ?>>18</option>
                                        <option value="19" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='19'){ echo "selected"; } ?>>19</option>
                                        <option value="20"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='20'){ echo "selected"; } ?>>20</option>
                                        <option value="21"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='21'){ echo "selected"; } ?>>21</option>
                                        <option value="22"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='22'){ echo "selected"; } ?>>22</option>
                                        <option value="23"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='23'){ echo "selected"; } ?>>23</option>
                                        <option value="24"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='24'){ echo "selected"; } ?>>24</option>
                                        <option value="25"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='25'){ echo "selected"; } ?>>25</option>
                                        <option value="26"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='26'){ echo "selected"; } ?>>26</option>
                                        <option value="27"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='27'){ echo "selected"; } ?>>27</option>
                                        <option value="28"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='28'){ echo "selected"; } ?>>28</option>
                                        <option value="29"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='29'){ echo "selected"; } ?>>29</option>
                                        <option value="30"  <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='30'){ echo "selected"; } ?>>30</option>
                                        <option value="Greater than 30" <?php if(!empty($detail->year_at_residence) && $detail->year_at_residence=='Greater than 30'){ echo "selected"; } ?>>Greater than 30</option>
                                    </select>
                                    <small class="text-danger invalid" id="year_at_residence_error"></small>
                                </div>
                            </div>
                            <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                            <input type="button" name="submit" id="next-4" class="next submit action-button btn btn-primary" value="Next" />
                        </fieldset>

                        <fieldset>
                            <h3 class="multisteps-form__title">Upload Doc</h3>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">PAN No.
										  <span class="tool" data-tip=" Please share valid PAN number to ensure  regarding this application." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter PAN No." onkeyup="AutoSave(this.id,this.value)" value="<?php if(!empty($detail->pan_number)){ echo $detail->pan_number; }elseif(!empty($pay1data->pan)){ echo $pay1data->pan; } ?>" type="text" id="pan_number" title="Enter PAN No." required="" />
                                        <!--<label>Enter PAN No.</label>-->
                                        <small class="text-danger invalid" id="pan_number_error"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>Upload Proof +</span><input type="file" multiple="" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage1`,`base_pancard_`)" id="pancard_image" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="pan_image_error"></small>
                                </div>
                                <div id="shownearimage1" style="width: 100%;" <?php if(!empty($detail->pancard_image) || !empty($pay1data->pan_front)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
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
                                    <?php }}}elseif(!empty($pay1data->pan_front)){ 
                                        $randid=time().rand(111,999);
                                        $path = $pay1data->pan_front;
                                        $type = 'jpg';
                                        $data = file_get_contents($path);
                                        $base64pancard = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    ?>
                                        <div class="m-2">
                                            <a href="javascript:void(0)">
                                                <img
                                                    class="img-preview-thumb"
                                                    onclick="ShowLargeImage(this.src)"
                                                    id="<?php echo $randid; ?>"
                                                    src="<?php echo $base64pancard; ?>"
                                                />
                                            </a>
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage1`)">×</a>
                                            <input
                                                type="hidden"
                                                id="<?php echo $randid; ?>image"
                                                name="base_pancard_[]"
                                                value="<?php echo $base64pancard; ?>@kk@jpg"
                                            />
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                    <p class="mb-0 f14">Enter Aadhar No.
										  <span class="tool" data-tip="Please share valid adhar number to ensure regarding this application." tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder="Enter Aadhar No."onkeyup="AutoSave(this.id,this.value)" type="text" value="<?php if(!empty($detail->aadhar_number)){ echo $detail->aadhar_number; } ?>" id="aadhar_number" title="Enter Aadhar No." required="" />
                                        <!--<label>Enter Aadhar No.</label>-->
                                        <small class="text-danger invalid" id="aadhar_number_error"></small>
                                    </div>   
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>Upload Proof +</span><input type="file" multiple="" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage2`,`base_aadharcard_`)" id="aadhar_image" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="aadhar_image_error"></small>
                                </div>
                                <div id="shownearimage2" style="width: 100%;" <?php if(!empty($detail->aadhar_image)){ echo 'class="quote-imgs-thumbs"'; }  ?> aria-live="polite">
                                    <?php if(!empty($detail->aadhar_image)){
                                        $explode=explode(',',$detail->aadhar_image);
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
                                                    src="<?php echo base_url('uploads/merchant/aadharcard/'.$file); ?>"
                                                />
                                            </a>
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage2`)">×</a>
                                            <input
                                                type="hidden"
                                                id="<?php echo $randid; ?>image"
                                                name="base_aadharcard_[]"
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
                                                name="base_aadharcard_[]"
                                                value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
                                            />
                                        </div>
                                    <?php }}} ?>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-12">
                                    <p class="mb-0 f14">Upload current address proof (utility bill/rent agreement/voter id)
										  <span class="tool" data-tip="Upload current address proof (utility bill/rent agreement/voter id)" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>Upload current address proof (utility bill/rent agreement/voter id) +</span><input type="file" multiple="" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage5`,`base_residence_address_proof_`)" id="residence_address_proof" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="redsidence_proof_error"></small>
                                </div>
                                <div id="shownearimage5" <?php if(!empty($detail->residence_address_proof)){ echo 'class="quote-imgs-thumbs"'; }  ?> style="width: 100%;" aria-live="polite">
                                    <?php if(!empty($detail->residence_address_proof)){
                                        $explode=explode(',',$detail->residence_address_proof);
                                        foreach($explode as $file){
                                            $extension = pathinfo($file,PATHINFO_EXTENSION);
                                            $randid=rand(1111111111,9999999909);
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage5`)">×</a>
                                            <input
                                                type="hidden"
                                                id="<?php echo $randid; ?>image"
                                                name="base_residence_address_proof_[]"
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
                                                name="base_residence_address_proof_[]"
                                                value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
                                            />
                                        </div>
                                    <?php }}} ?>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-12">
                                    <p class="mb-0 f14">Upload latest 3 months salary slips +
										  <span class="tool" data-tip="Upload latest 3 months salary slips +" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>Latest 3 months salary slips +</span><input type="file" multiple="" accept=".pdf" onchange="ShowSelectImage(this,`shownearimage3`,`base_salery_slip_`)" id="salery_slip" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="salery_slip_error"></small>
                                </div>
                                <div id="shownearimage3" <?php if(!empty($detail->salery_slip)){ echo 'class="quote-imgs-thumbs"'; }  ?> style="width: 100%;" aria-live="polite">
                                    <?php if(!empty($detail->salery_slip)){
                                        $explode=explode(',',$detail->salery_slip);
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
                                                    src="<?php echo base_url('uploads/merchant/salery_slip/'.$file); ?>"
                                                />
                                            </a>
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage3`)">×</a>
                                            <input
                                                type="hidden"
                                                id="<?php echo $randid; ?>image"
                                                name="base_salery_slip_[]"
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
                                                name="base_salery_slip_[]"
                                                value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
                                            />
                                        </div>
                                    <?php }}} ?>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-9 col-sm-9">
                                    <p class="mb-0 f14">One Year Latest Bank Statement +
										  <span class="tool" data-tip="Upload One Year Latest Bank Statement +" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>One Year Latest Bank Statement +</span><input type="file" multiple="" accept=".pdf" onchange="ShowSelectImage(this,`shownearimage4`,`base_bankstatement_`)" id="bankstatement" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="bankstatement_error"></small>
                                </div>
                                <div class="col-3 col-sm-3">
                                    <p class="mb-0 f14">PDF Password (Optional)
										  <span class="tool" data-tip="Enter PDF Password (Optional)" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" placeholder ="PDF Password (Optional)" value="<?php if(!empty($detail->bankstatement_password)){ echo $$detail->bankstatement_password; } ?>" id="bankstatement_password">
                                        <!--<label>PDF Password (Optional)</label>-->
                                    </div>
                                </div>
                                <div id="shownearimage4" <?php if(!empty($detail->bank_statement)){ echo 'class="quote-imgs-thumbs"'; }  ?> style="width: 100%;" aria-live="polite">
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage4`)">×</a>
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage4`)">×</a>
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
                                    <p class="mb-0 f14">Upload ITR (OPTIONAL) +
										  <span class="tool" data-tip="Upload ITR (OPTIONAL) +" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>Upload ITR (OPTIONAL) +</span><input type="file" multiple="" accept=".pdf,.png,.jpeg,.docx,.doc,.jpg" onchange="ShowSelectImage(this,`shownearimage9`,`base_itr_`)" id="itr" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="itr_error"></small>
                                </div>
                                <div id="shownearimage9" <?php if(!empty($detail->itr_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> style="width: 100%;" aria-live="polite">
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage9`)">×</a>
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage9`)">×</a>
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
                                     <p class="mb-0 f14">Upload CANCELLED CHEQUE (OPTIONAL) +
										  <span class="tool" data-tip="Please upload CANCELLED CHEQUE (OPTIONAL) +" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="fileUpload blue-btn btn width100">
                                        <span>Upload CANCELLED CHEQUE (OPTIONAL) +</span><input type="file" multiple="" accept=".pdf,.png,.jpeg,.jpg,.docx,.doc" onchange="ShowSelectImage(this,`shownearimage6`,`base_cheque_`)" id="cheque" class="uploadlogo" />
                                    </div>
                                    <small class="text-danger" id="cheque_error"></small>
                                </div>
                                <div id="shownearimage6" <?php if(!empty($detail->cheque_docs)){ echo 'class="quote-imgs-thumbs"'; }  ?> style="width: 100%;" aria-live="polite">
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`shownearimage6`)">×</a>
                                            <input
                                                type="hidden"
                                                id="<?php echo $randid; ?>image"
                                                name="base_cheque_[]"
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
                                                name="base_cheque_[]"
                                                value="<?php echo $file; ?>@kk@<?php echo $extension; ?>"
                                            />
                                        </div>
                                    <?php }}} ?>
                                </div>
                            </div>
                            <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                            <input type="button" name="submit" id="next-5" class="next submit action-button btn btn-primary" value="Next" />
                        </fieldset>
                        <fieldset>
                            <h3 class="multisteps-form__title">Reference</h3>
                            <div class="form-row mt-4">
                                <div class="col-12 col-sm-6">
                                     <p class="mb-0 f14">Enter Reference Name
										  <span class="tool" data-tip="Please fill the Reference Name" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" id="reference" placeholder="Enter Reference Name" type="text" title="Reference Name" required="" />
                                        <!--<label>Reference Name</label>-->
                                        <small id="reference_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                     <p class="mb-0 f14">Reference Mobile Number
										  <span class="tool" data-tip="Please enter Reference Mobile Number" tabindex="1">
									      <i class="fas fa-question-circle f14"></i></span>
								    </p>
                                    <div class="md-input">
                                        <input class="md-form-control" maxlength="10" id="reference_number" placeholder="Enter Reference Mobile Number" title="Reference Mobile Number" type="text" required="" />
                                        <!--<label>Reference Mobile Number</label>-->
                                        <small id="refernece_number_error" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                            <button type="button" name="submit" id="next-6" class="next submit action-button btn btn-primary">
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
<div class="modal fade" id="LargeDocModel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modal_content">
            <div class="modal-body">
                <div class="col-12 col-sm-12">
                    <iframe src="" id="to-large-doc" title="document" height="500px" width="100%"></iframe>
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
        function GenderLabel(){
            if(document.getElementById('gender').value==''){
                document.getElementById('gender_label').setAttribute('style','display:none');
                document.getElementById('gender').setAttribute('style','');
            }else{
                document.getElementById('gender_label').setAttribute('style','');
                document.getElementById('gender').setAttribute('style','padding-top:17px;');
            }
        }
        GenderLabel();
        function QualificationLabel(){
            if(document.getElementById('qualification').value==''){
                document.getElementById('qualification_label').setAttribute('style','display:none');
                document.getElementById('qualification').setAttribute('style','');
            }else{
                document.getElementById('qualification_label').setAttribute('style','');
                document.getElementById('qualification').setAttribute('style','padding-top:17px;');
            }
        }
        QualificationLabel();
        function MaritalStatusLabel(){
            if(document.getElementById('marital_status').value==''){
                document.getElementById('marital_status_label').setAttribute('style','display:none');
                document.getElementById('marital_status').setAttribute('style','');
            }else{
                document.getElementById('marital_status_label').setAttribute('style','');
                document.getElementById('marital_status').setAttribute('style','padding-top:17px;');
            }
        }
        MaritalStatusLabel();
        function VehicleTypeLabel(){
            if(document.getElementById('vehicle_type').value==''){
                document.getElementById('vehicle_type_label').setAttribute('style','display:none');
                document.getElementById('vehicle_type').setAttribute('style','');
            }else{
                document.getElementById('vehicle_type_label').setAttribute('style','');
                document.getElementById('vehicle_type').setAttribute('style','padding-top:17px;');
            }
        }
        VehicleTypeLabel();
        function OrganizationTypeLabel(){
            if(document.getElementById('organization_type').value==''){
                document.getElementById('organization_type_label').setAttribute('style','display:none');
                document.getElementById('organization_type').setAttribute('style','');
            }else{
                document.getElementById('organization_type_label').setAttribute('style','');
                document.getElementById('organization_type').setAttribute('style','padding-top:17px;');
            }
        }
        OrganizationTypeLabel();
        function TotalExperienceLabel(){
            if(document.getElementById('total_experience').value==''){
                document.getElementById('total_experience_label').setAttribute('style','display:none');
                document.getElementById('total_experience').setAttribute('style','');
            }else{
                document.getElementById('total_experience_label').setAttribute('style','');
                document.getElementById('total_experience').setAttribute('style','padding-top:17px;');
            }
        }
        TotalExperienceLabel();
        function CompanyStateLabel(){
            if(document.getElementById('company_state').value==''){
                document.getElementById('company_state_label').setAttribute('style','display:none');
                document.getElementById('company_state').setAttribute('style','');
            }else{
                document.getElementById('company_state_label').setAttribute('style','');
                document.getElementById('company_state').setAttribute('style','padding-top:17px;');
            }
        }
        CompanyStateLabel();
        function SalaryModeLabel(){
            if(document.getElementById('salary_mode').value==''){
                document.getElementById('salary_mode_label').setAttribute('style','display:none');
                document.getElementById('salary_mode').setAttribute('style','');
            }else{
                document.getElementById('salary_mode_label').setAttribute('style','');
                document.getElementById('salary_mode').setAttribute('style','padding-top:17px;');
            }
        }
        SalaryModeLabel();
        function ResidenceStateLabel(){
            if(document.getElementById('residence_state').value==''){
                document.getElementById('residence_state_label').setAttribute('style','display:none');
                document.getElementById('residence_state').setAttribute('style','');
            }else{
                document.getElementById('residence_state_label').setAttribute('style','');
                document.getElementById('residence_state').setAttribute('style','padding-top:17px;');
            }
        }
        ResidenceStateLabel();
        function ResidenceTypeLabel(){
            if(document.getElementById('residence_type').value==''){
                document.getElementById('residence_type_label').setAttribute('style','display:none');
                document.getElementById('residence_type').setAttribute('style','');
            }else{
                document.getElementById('residence_type_label').setAttribute('style','');
                document.getElementById('residence_type').setAttribute('style','padding-top:17px;');
            }
        }
        ResidenceTypeLabel();
        function YearAtResidenceLabel(){
            if(document.getElementById('year_at_residence').value==''){
                document.getElementById('year_at_residence_label').setAttribute('style','display:none');
                document.getElementById('year_at_residence').setAttribute('style','');
            }else{
                document.getElementById('year_at_residence_label').setAttribute('style','');
                document.getElementById('year_at_residence').setAttribute('style','padding-top:17px;');
            }
        }
        YearAtResidenceLabel();
        function CompanyCityLabel(){
            if(document.getElementById('company_city').value==''){
                document.getElementById('company_city_label').setAttribute('style','display:none');
                document.getElementById('company_city').setAttribute('style','');
            }else{
                document.getElementById('company_city_label').setAttribute('style','');
                document.getElementById('company_city').setAttribute('style','padding-top:17px;');
            }
        }
        function CompanyPincodeLabel(){
            if(document.getElementById('company_pincode').value==''){
                document.getElementById('company_pincode_label').setAttribute('style','display:none');
                document.getElementById('company_pincode').setAttribute('style','');
            }else{
                document.getElementById('company_pincode_label').setAttribute('style','');
                document.getElementById('company_pincode').setAttribute('style','padding-top:17px;');
            }
        }
		function ResidenceCityLabel(){
            if(document.getElementById('residence_city').value==''){
                document.getElementById('residence_city_label').setAttribute('style','display:none');
                document.getElementById('residence_city').setAttribute('style','');
            }else{
                document.getElementById('residence_city_label').setAttribute('style','');
                document.getElementById('residence_city').setAttribute('style','padding-top:17px;');
            }
        }
        function ResidencePincodeLabel(){
            if(document.getElementById('residence_pincode').value==''){
                document.getElementById('residence_pincode_label').setAttribute('style','display:none');
                document.getElementById('residence_pincode').setAttribute('style','');
            }else{
                document.getElementById('residence_pincode_label').setAttribute('style','');
                document.getElementById('residence_pincode').setAttribute('style','padding-top:17px;');
            }
        }
    </script>