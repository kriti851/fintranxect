<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Pay1 Integration</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Pay1 Integration</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    
                </div>
            </div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">  
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Pay1 Integration 
                                <div class="float-right">
                                    <h5>
                                        <a class="button viewbutton" href="<?php echo admin_url('pay1/DataApi'); ?>">Download Pay1 Excel</a>
                                    </h5>
                                </div>
                            </h3>
                            <?php if(!empty($approvarResponse)){ if(!empty($approvarResponse['pre_apprvals_res'])){ ?><div class="alert alert-success" role="alert">Success Approvals : <br><?php foreach($approvarResponse['pre_apprvals_res'] as $success_approval){ ?>
                                Pay1 User Id : <?php echo $success_approval['user_id']; ?> Approved Amount : <?php echo $success_approval['approved_amount']; ?> Processing Fees : <?php echo $success_approval['processing_fee']; ?> Tenure in Days: <?php echo $success_approval['tenure_in_days'];?><br>
                            <?php } ?></div><?php }} ?>
                            <?php if(!empty($approvarResponse)){ if(!empty($approvarResponse['err_pre_approvals'])){ ?>  <div class="alert alert-danger" role="alert">Failed Approvals : <br><?php foreach($approvarResponse['err_pre_approvals'] as $error_approval){ ?>
                               Pay1 User Id : <?php echo $error_approval['user_id']; ?> Approved Amount : <?php echo $error_approval['approved_amount']; ?> Processing Fees : <?php echo $error_approval['processing_fee']; ?> Tenure in Days: <?php echo $error_approval['tenure_in_days'];?><br>
                            <?php } ?></div><?php }} ?>
                            <hr>
                            <form method="post" action="<?php echo admin_url('pay1'); ?>" enctype="multipart/form-data">
                                <div class="form-row mt-4">
                                    <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                                        <small class="text-danger" ><?php if(!empty($excel_error)){ echo $excel_error; }?></small>
                                        <div class="fileUpload blue-btn btn width100">
                                            <span>Upload Pay1 Excel +</span><input type="file" accept=".csv,.xlsx,.xls" name="excel" onchange="ShowSelectFile(this,`showFile`)" class="uploadlogo">
                                        </div>
                                        <div class="float-left" id="showFile">
                                        </div>
                                    </div>
                                </div>
                                <div class="float-left mt-4">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>