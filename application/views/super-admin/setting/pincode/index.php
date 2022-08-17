<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>
<style>
.breadcrumb-form form {
    max-width: 330px;
    position: relative;
    margin-left: 0px;
    float: right;
    display: block;
    width: 100%;
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

</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Pincode</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0)">Home</a></li>
                        <li><a href="javascript:void(0)">Setting</a></li>
                        <li class="active"><a href="javascript:void(0)">Pincode</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#" class="form-inline">
                        <div class="form-group">
                            <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
                        </div>
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Pincode List
                                <div class="float-right">
                                    <div class="buttons">
                                        <?php if(SubPermission(47)){ ?>
                                        <h5>
                                            <a href="<?php echo admin_url('setting/pincode/add'); ?>"  class="button viewbutton" ><i class="fa fa-plus" aria-hidden="true"></i>Add New</a>
                                        </h5>
                                        <?php } ?>
                                    </div>
                                </div>
                            </h3>
                            <?php if(!empty($results)){  foreach($results as $result){  ?>
                                <div class="job-list">
                                    <div class="body">
                                        <div class="content">
                                            <span class="company">
                                            <?php echo $result->statename; ?> : <?php echo $result->city; ?> : <b><?php echo $result->pincode; ?> </b>
                                            </span>
                                    
                                        </div>
                                        <?php if(SubPermission(48)){ ?>
                                        <div class="more">
                                            <div class="buttons mr-2">
                                                <a href="javascript:void(0)" style="background:#ca1010;" onclick="Delete(`<?php echo $result->id; ?>`)"  class="button viewbutton" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php }}else{ ?>
                                <h3 class="text-center">No Record Found</h3>
                            <?php } ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                <div class="st-pagination">
                                    <?php echo $pagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="DeleteModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-center"><h3>Delete Confirm</h3></div>
            </div>
            <div class="modal-body">
                <div class="company">
                    Are you sure ? You want to delete this item.
                </div>
            </div>
            <div class="modal-footer">
                <a id="deleteconfirm" href="javascript:void(0)" class="btn btn-secondary">Yes</a>
                <button type="button"  data-dismiss="modal" class="btn btn-primary">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("setting-li").classList.add("active");
</script>