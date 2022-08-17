<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Partner</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Upload Logo</a></li>
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
                            <h3 class="text-left">Upload Logo</h3>
                        </div>
                        <div class="col-md-12 mt-2 text-left">
                            <small class="text-success" id="success_message"></small>
                            <small class="text-danger" id="logo_error"></small>
                            <div class="fileUpload blue-btn btn width100">
                                <input type="hidden" id="dsa_id" value="<?php echo $dsa_id; ?>">
                                <input type="hidden" id="file_ext">
                                <span>Upload Logo +</span><input type="file" onchange="ShowImage(this)"  id="selectlogo" class="uploadlogo" />
                            </div>
                            <div id="cropped_result">
                                <?php if(!empty($record->logo)){ ?>
                                    <img style="margin-top:10px;" class="quote-imgs-thumbs" src="<?php echo base_url('uploads/logo/'.$record->logo); ?>">
                                <?php } ?>
                            </div>
                            <div id="append_upload_btn"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="LargeImageModel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="append_image">
				
			</div>
			<div class="modal-footer">
				<button type="button" id="crop_button" class="btn btn-primary" data-dismiss="modal">Crop Image</button>
				<button type="button" style="background:black;" class="btn btn-secondary" onclick="dismissModal()">Close</button>
			</div>
		</div>
	</div>
</div>