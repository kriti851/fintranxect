<style>
    #progressbar li {
        width:20% !important;
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight:400 !important;
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
                        <li class="active"><a href="#!">Update Case</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12 mt-4 text-left">
                                <h3 class="text-left">Personal Info</h3>
                                <input type="hidden" id="merchant_id" value="<?php echo $users->user_id; ?>">
                                <form id="msform">
                                    <fieldset>
                                        <?php $exp= explode(' ',$users->full_name); ?>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <div class="md-input">
                                                    <input class="md-form-control" id="first_name" title="First Name" required type="text" value="<?php echo $exp[0]; ?>" />
                                                    <label>First Name</label>
                                                    <small class="text-danger" id="first_name_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <div class="md-input">
                                                    <input class="md-form-control" required="" id="last_name" title="Last Name" type="text" value="<?php echo end($exp) ?>" />
                                                    <label>Last Name<label>
                                                    <small class="text-danger" id="last_name_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <div class="md-input">
                                                    <input class="md-form-control" id="email" title="Email" required="" type="email" value="<?php echo $users->email; ?>" >
                                                    <label>Email</label>
                                                    <small class="text-danger" id="email_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6  mt-4 mt-sm-0">
                                                <div class="md-input">
                                                    <input class="md-form-control" id="phone" title="Mobile Number" maxlength="10" disabled type="text" value="<?php echo $users->mobile_number; ?>" required="">
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
                                                    <input class="md-form-control" title="Age" id="age" value="<?php echo $users->age; ?>" type="number" required=""/>
                                                    <label >Age</label>
                                                    <small class="text-danger" id="age_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($users->loan_type=='Business'){ ?>
                                            <div class="form-row mt-4">
                                                <div class="col-12 col-sm-12" id="add_date_field">
                                                    <div class="md-input">
                                                        <input class="md-form-control datepickerrange" value="<?php if(!empty($detail->date_of_birth)){  echo date('m/d/Y',strtotime($detail->date_of_birth)); } ?>" id="birthdate" name="birthdate" required="" title="Date Of Birth">
                                                        <label>Date Of Birth</label>
                                                        <small class="text-danger" id="birthdate_error"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }else{ ?>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-12" id="add_date_field">
                                                
                                            </div>
                                        </div>
                                        <?php } ?>
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
<div class="modal fade" id="OpenOtpModel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-center"><h3>Processing...</h3></div>
            </div>
            <div class="modal-body">
                <div class="progress" style="height: 40px;">
                    <div style="font-size: 30px;" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        0%
                    </div>
                    <div id="status"></div>
                </div>
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
<script>
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
</script>
