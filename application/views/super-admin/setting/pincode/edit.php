<style>
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
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Pincode</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0)">Home</a></li>
                        <li><a href="javascript:void(0)">Setting</a></li>
                        <li class="active"><a href="javascript:void(0)">Pincode</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Add Pincode
                            </h3>
                            <form id="pincodeform" method="post">
                                <div class="form-row mt-4">
                                    <div class="col-12 col-sm-12">
                                        <select class="multisteps-form__input form-control" onchange="GetCityList(this.value)" name="state_id" id="state_id" title="State" >
                                            <option value="">State</option>
                                            <?php foreach($states as $state){  ?>
                                                <option value="<?php echo $state->id; ?>" <?php if(set_value('state_id') && set_value('state_id')==$state->id){ echo "selected"; } ?>><?php echo $state->name; ?></option>
                                            <?php }  ?>
                                        </select>
                                        <small class="text-danger float-left"><?php echo form_error('state_id'); ?></small>
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="col-12 col-sm-12">
                                        <select class="multisteps-form__input form-control" name="city" id="city" title="City" >
                                            <option value="">City</option>
                                            
                                        </select>
                                        <small class="text-danger float-left"><?php echo form_error('state_id'); ?></small>
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="col-12 col-sm-12">
                                        <div class="md-input">
                                            <input class="md-form-control" id="pincode" name="pincode" title="Pincode" value="<?php if(set_value('pincode')){ echo set_value('pincode'); } ?>" type="text" required=""/>
                                            <label>Pincode</label>
                                            <small class="text-danger float-left"><?php echo form_error('pincode'); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" style="float:left;" class="next action-button btn btn-primary mt-4" value="Submit" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("setting-li").classList.add("active");
</script>