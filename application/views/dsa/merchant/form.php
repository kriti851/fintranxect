<style>
    #progressbar li {
        width:20% !important;
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
.accup {position: absolute;margin-top:10px;color: #656565;  font-size: 10px; background: #fff; left: 20px; top: -4px;}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Partner Loan</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Partner Loan Application</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>

            <?php $this->load->view('dsa/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12 mt-4 text-left">
                            <form id="msform">
                                    <input type="hidden" id="merchant_id" >
                                    <?php if(!empty($users->full_name)){ $full_name=explode(' ',trim($users->full_name)); } ?>
                                    <fieldset>
                                        <h3 class="multisteps-form__title">Personal info</h3>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <div class="md-input">
                                                    <input class="md-form-control" title="First Name" id="first_name" value="<?php if(!empty($full_name)){ echo $full_name[0];} ?>" type="text" required=""/>
                                                    <label>First Name</label>
                                                    <small class="text-danger" id="first_name_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <div class="md-input">
                                                    <input class="md-form-control" title="Last Name" id="last_name" value="<?php if(!empty($full_name)){ echo end($full_name);} ?>" type="text" required=""/>
                                                    <label>Last Name</label>
                                                    <small class="text-danger" id="last_name_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <div class="md-input">
                                                    <input class="md-form-control" title="Email" id="email" type="text" value="<?php if(!empty($users->email)){ echo $users->email; } ?>" required=""/>
                                                    <label>Email</label>
                                                    <small class="text-danger" id="email_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6  mt-4 mt-sm-0">
                                                <div class="md-input">
                                                    <input class="md-form-control" title="Mobile Number" id="phone" maxlength="10" value="<?php if(!empty($users->mobile_number)){ echo $users->mobile_number; } ?>" type="text" required=""/>
                                                    <label>Mobile number</label>
                                                    <small class="text-danger" id="phone_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <label style="display:none" id="employment_type_label" class="accup">Type Of Occupation</label>
                                                <select class="multisteps-form__input form-control" title="Type Of Occupation" id="employment_type">
                                                    <option value="">Type Of Occupation</option>
                                                    <option value="Salaried" <?php if(!empty($users->loan_type) && $users->loan_type=='Salaried'){ echo "selected"; } ?>>Salaried</option>
                                                    <option value="Business" <?php if(!empty($users->loan_type) && $users->loan_type=='Business'){ echo "selected"; } ?>>Business</option>
                                                </select>
                                                <small class="text-danger" id="employment_type_error"></small>
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <div class="md-input">
                                                    <input class="md-form-control" title="Age" oninput="this.value = Math.abs(this.value)" value="<?php if(!empty($users->age)){ echo $users->age; } ?>" id="age" type="number" required=""/>
                                                    <label>Age</label>
                                                    <small class="text-danger" id="age_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-12" id="add_date_field">
                                                
                                            </div>
                                        </div>
                                        <input type="button" name="next" id="next-1" class="next action-button btn btn-primary" value="Next" />
                                    </fieldset>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('employment_type').onchange=function(){
        OccupationTypeLabel();
    }
    function OccupationTypeLabel(){
        if(document.getElementById('employment_type').value==''){
            document.getElementById('employment_type_label').setAttribute('style','display:none');
            document.getElementById('employment_type').setAttribute('style','');
        }else{
            document.getElementById('employment_type_label').setAttribute('style','');
            document.getElementById('employment_type').setAttribute('style','padding-top:17px;');
        }
    }
    OccupationTypeLabel();
    
    document.getElementById('employment_type').onchange=function(){
        OccupationTypeLabel();
        if(this.value=='Business'){
            var html='<div class="md-input">'+
                        '<input class="md-form-control datepickerrange" id="birthdate" name="birthdate"  title="Date Of Birth" autocomplete="off" required="" type="text">'+
                        '<label>Date of Birth</label>'+
                        '<small class="text-danger" id="birthdate_error"></small>'+
                    '</div>';
            document.getElementById('add_date_field').innerHTML=html;
            setTimeout(function(){ loadDatePicker(); }, 100);
        }else{
            document.getElementById('add_date_field').innerHTML='';
        }
    }
</script>