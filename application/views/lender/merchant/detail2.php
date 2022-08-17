<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.job-list .content { width: 100%;}
.mobile { float: right;font-size: 15px;}
.job-list .body .content .info span { margin-right: 20px; border-right: 1px solid #ccc; padding-right: 20px;}
.information { text-align: left; margin-bottom:20px;}
.partnerimg { width: 120px; background: #fff;  padding: 10px;  border-radius: 10px; border: 1px solid #ccc;  display: block;
    margin-top: 0px;
}
.information img { width: 182px; background: #fff; padding: 10px;border-radius: 10px;  border: 1px solid #ccc;}
.mb-20 {margin-bottom: 20px;}
.photodocument a { position: relative; background: transparent; border: none;}


.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 999;
    top: 0;
    right: -10px;
    background-color: #fff;
    overflow-x: hidden;
    padding-top: 60px;
    transition: 0.5s;
    box-shadow:0px 0px 6px 6px #f1f1f1;
}
.sidenav a {
    padding: 8px 8px 8px 8px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}
.sidenav .closebtn {
    position: absolute;
    top: 0;
    left: 0px;
    font-size: 14px;
    margin-left: 0px;
}

.fixedcomment {
	font-size: 25px;
    background: #1787ff;
    color: #fff;
    padding: 10px;
    position: fixed;
    right: 0px;
    bottom: 20%;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
.textarea{
    position: fixed;
    bottom: 15px;
}

.textarea textarea {
	    background: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px;
    width: 90%;
    height: 150px;
    border: 1px solid #ccc;
}
.mleft15 {
    margin-left: 14px;
}
.box-body {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    position: relative;
    overflow-x: hidden;
    padding: 0;
	height: 550px;
}
.direct-chat-messages {
    -webkit-transform: translate(0, 0);
    -ms-transform: translate(0, 0);
    -o-transform: translate(0, 0);
    transform: translate(0, 0);
    padding: 10px;
	height: 65%;
    overflow: auto
}

.direct-chat-messages,
.direct-chat-contacts {
    -webkit-transition: -webkit-transform .5s ease-in-out;
    -moz-transition: -moz-transform .5s ease-in-out;
    -o-transition: -o-transform .5s ease-in-out;
    transition: transform .5s ease-in-out
}

.direct-chat-msg {
    margin-bottom: 10px
}

.direct-chat-msg,
.direct-chat-text {
    display: block
}

.direct-chat-info {
    display: block;
    margin-bottom: 2px;
    font-size: 12px
}

.direct-chat-timestamp {
    color: #999
}
.right .direct-chat-text {
    margin-right: 10px;
}
.direct-chat-text {
    margin: 5px 0 0 10px;
}


#style-4::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

#style-4::-webkit-scrollbar
{
	width: 5px;
	background-color: #F5F5F5;
}

#style-4::-webkit-scrollbar-thumb
{
	background-color: #000000;
	border: 2px solid #555555;
}

.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 15px;margin-bottom: 0px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}
.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: -1px;
    bottom: 0px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border: 1px solid #504d4d;
}
input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.resolved {
	position: relative;
    top: 0px;
}
.partnerbtn {
    font-size: 14px;
    border-radius: 2px;
    line-height: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 10px 20px;
    font-weight: 600;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}
</style>

<span onclick="openNav()"><i class="far fa-comment-dots fixedcomment"></i></span>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
     <i class="far fa-arrow-alt-circle-right" style="font-size: 30px;"></i>
  </a>
   
 <div class="box-body">  
    <div class="direct-chat-messages" id="style-4">
		<?php foreach($comments as $comment){ ?>
        <div class="direct-chat-msg <?php if($comment->commented_by=='SUPER-ADMIN'){ echo 'right'; } ?>">
           <div class="direct-chat-info clearfix"> 
		   	<span class="direct-chat-name <?php if($comment->commented_by=='SUPER-ADMIN'){ echo 'pull-left'; }else{ echo 'pull-right'; } ?>">
				<?php if($comment->commented_by=='LENDER'){ ?> You <?php }else{ echo 'Admin'; } ?>
			</span> 
		   <span class="direct-chat-timestamp pull-right"><?php echo  date('d M Y h:i A',strtotime($comment->created_at)); ?> | <?php echo strtolower($comment->comment_for); ?></span> </div> 
		   
		  <span> 
		     <label class="switch">
			 	<input type="checkbox" id="isresolved<?php echo $comment->comment_id; ?>" onclick="IsResolved(`<?php echo $comment->comment_id; ?>`)"; value="" <?php if($comment->is_resolved=='NO' || $comment->is_resolved==null){ echo '' ; }else{ echo 'checked'; } ?>>
			    <span class="slider round"></span>
		     </label>
		  </span> 
		  <span class="resolved">Resolved?</span>
		   
		   <div class="direct-chat-text"><?php echo $comment->comment; ?></div>
        </div>
		<?php } ?>
    </div>
   </div>
   
  <div class="textarea">
  	<small class="text-danger" style="margin-left:14px;" id="comment_error"></small>
	<input type="hidden" id="merchant_id" value="<?php echo $record->user_id; ?>">		
    <textarea id="comments" placeholder="Enter your comment"></textarea>
		<button onclick="SubmitComment(`<?php echo $this->session->userdata('user_id'); ?>`,`LENDER`)" style="margin-left:14px;" type="button"  class="d-inline-block btn btn-secondary btn-sm partnerbtn">
		 <small style="font-size: 66%;">SEND <i class="fas fa-share" style="font-size: 13px;"></i></small>
		</button>
  </div> 
</div>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Case Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Cases Reports Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    
                </div>
            </div>

            <?php $this->load->view('lender/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            
                    	<h3 class="text-left">Personal Detail
							<div class="float-right">
								<div class="buttons">
									<h5>
									<a href="<?php echo lender_url('merchant/DownloadApplicant2/'.$record->user_id); ?>" download class="button viewbutton"><i class="fa fa-download"></i> Download Case</a>
										<?php if($record->lender_status!='APPROVED' && $record->lender_status!="REJECTED" && $record->lender_status!="DISBURSED"){ ?>
											<a href="<?php echo lender_url('merchant/approve/'.$record->user_id); ?>" class="button viewbutton">Approve</a>
											<a href="javascript:void(0)" onclick="RejectCaseModal(`<?php echo $record->user_id; ?>`)" class="button viewbutton">Reject</a>
										<?php } if($record->lender_status=='APPROVED'){ ?>
											<a href="javascript:void(0)" data-toggle="modal" data-target="#DisbursedModel" class="button viewbutton">Disburse</a> 
										<?php } ?>
									</h5>
								</div>
							</div>
						</h3>
						<div class="job-list">
							<div class="body">
								<div class="content">
										<h4>
										<a href="#"><?php echo $record->full_name; ?></a>
										<span class="mobile">
											<a href="#"><b>Age:</b> <?php echo $record->age; ?></a>
										</span>
										</h4>
										<div class="info">
											<span class="company">
												<a href="#"><b><?php echo $record->file_id; ?></b></a>
											</span>
											<span class="company">
												<a href="#"><b>Email:</b> <?php echo $record->email; ?></a>
											</span>
											
											<span class="company">
												<a href="#"><b>Mob:</b> +91 <?php echo $record->mobile_number; ?></a>
											</span>
											<span class="company">
												<a href="#"><b>Type of Loan:</b> <?php if(!empty($record->loan_type)){ echo $record->loan_type; }else{ $record->employment_type; } ?></a>
											</span>
											<span class="company">
												<a href="#"><b>Status:</b> <?php echo $record->lender_status; ?></a>
											</span>
											<?php if(!empty($record->disbursed_amount)){ ?>
											<span class="company">
												<a href="#"><b>Status:</b> <?php echo $record->disbursed_amount; ?></a>
											</span>
											<?php } ?>
										</div>
									</div>
							   </div>
						</div>
						  
                        <div class="information">
                            <h4>Additional Personal info</h4>
                            <ul>
                                <li><span>Father's Name:</span> <?php echo $record->father_name; ?></li>
                                <li><span>Date Of Birth:</span> <?php echo $record->date_of_birth; ?></li>
                                <li><span>Gender:</span> <?php echo $record->gender; ?></li>
                                <li><span>Qualification:</span> <?php echo $record->qualification; ?></li>
                                <li><span>Marital Status:</span> <?php echo $record->marital_status; ?></li>
                                <?php if(!empty($record->number_of_kids)){ ?>
                                <li><span>Number Of Kids :</span> <?php echo $record->number_of_kids; ?></li>
                                <?php } ?>
                                <li><span>Vehicle Type:</span> <?php echo $record->vehicle_type; ?></li>
                            </ul>
                        </div>
                        <div class="information">
							<h4>Employment Information</h4>
							<ul>
								<li><span>Name Of Employer:</span> <?php echo $record->employer_name; ?></li>
								<li><span>Designation</span> <?php echo $record->designation; ?></li>
								<li><span>No.of year in current organization:</span> <?php echo $record->organization; ?></li>
								<li><span>Type Of Organization:</span> <?php echo $record->organization_type; ?></li>
								<li><span>Total Experience (In Months):</span> <?php echo $record->total_experience; ?></li>
							</ul>
                            <h4>Company Address</h4>
                            <ul>
								<li><span>Building No./Plot No.:</span> <?php echo $record->company_building; ?></li>
								<li><span>Locality/Area</span> <?php echo $record->company_area; ?></li>
								<li><span>Pincode:</span> <?php if($record->company_pincode=='Other'){ echo $record->company_other_pincode; }else{ echo $record->company_pincode; } ?></li>
								<li><span>State:</span> <?php echo $record->company_state; ?></li>
								<li><span>City:</span> <?php if($record->company_city=='Other'){ echo $record->company_other_city; } else{echo $record->company_city; } ?></li>
								<li><span>Email:</span> <?php echo $record->company_email; ?></li>
								<li><span>Website:</span> <?php echo $record->company_website; ?></li>
							</ul>
						</div>
                        <div class="information">
							<h4>Salary Detail</h4>
							<ul>
								<li><span>Inhand Salary (Without Incentives/Bonus):</span> <?php echo $record->salery_inhand; ?></li>
								<li><span>Mode Of Receiving Salary</span> <?php echo $record->salary_mode; ?></li>
							</ul>
						</div>
						<div class="information">
							<h4>Residence Address</h4>
                            <ul>
								<li><span>Building No./Plot No.:</span> <?php echo $record->residence_building; ?></li>
								<li><span>Locality/Area</span> <?php echo $record->residence_area;  ?></li>
								<li><span>Pincode:</span> <?php if($record->residence_pincode=='Other'){ echo $record->residence_other_pincode; }else{ echo $record->residence_pincode; } ?></li>
								<li><span>State:</span> <?php echo $record->residence_state; ?></li>
								<li><span>City:</span> <?php if($record->residence_city=='Other'){ echo $record->residence_other_city; }else{ echo $record->residence_city; } ?></li>
								<li><span>Residence Type:</span> <?php echo $record->residence_type; ?></li>
								<li><span>No. of year at current residence:</span> <?php echo $record->year_at_residence; ?></li>
							</ul>
						</div>						
                        <div class="information">
                            <h4>Upload Documents</h4>
                            <?php if(!empty($record->pan_number)){  ?>
                                <div style="width:100%" class="quote-imgs-thumbs">
                                    <p>Pan No. : <b><?php echo $record->pan_number; ?></b></p> 
                                    <?php if(!empty($record->pancard_image)){ $imagearray=explode(',',$record->pancard_image); foreach($imagearray as $file){ ?>
                                        <?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/pancard/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
                                        <?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/pancard/'.$file)); ?>`)"  class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
                                    <?php }else{ ?>
                                        <div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"/></a></div>
                                    <?php }}} ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($record->aadhar_number)){  ?>
                                <div style="width:100%" class="quote-imgs-thumbs">
                                    <p>Aadhar No. : <b><?php echo $record->aadhar_number; ?></b></p> 
                                    <?php if(!empty($record->aadhar_image)){ $imagearray=explode(',',$record->aadhar_image); foreach($imagearray as $file){ ?>
                                        <?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/aadharcard/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
                                        <?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/aadharcard/'.$file)); ?>`)"  class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
                                    <?php }else{ ?>
                                        <div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/aadharcard/'.$file); ?>"/></a></div>
                                    <?php }}} ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($record->salery_slip)){  ?>
                                <div style="width:100%" class="quote-imgs-thumbs">
                                    <p>Salary Silp : </p>
                                    <?php if(!empty($record->salery_slip)){ $imagearray=explode(',',$record->salery_slip); foreach($imagearray as $file){ ?>
                                        <?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/salery_slip/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
                                        <?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/salery_slip/'.$file)); ?>`)"  class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
                                    <?php }else{ ?>
                                        <div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/salery_slip/'.$file); ?>"/></a></div>
                                    <?php }}} ?>
                                </div>
                            <?php } ?>							
                            <?php if(!empty($record->bank_statement)){  ?>
                                <div style="width:100%" class="quote-imgs-thumbs">
                                    <p>6 Month bank statement: <?php if(!empty($record->bankstatement_password)){ echo '( Password :- '.$record->bankstatement_password.' )'; } ?></p> 
                                    <?php $imagearray=explode(',',$record->bank_statement); foreach($imagearray as $file){ ?>
                                        <?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/bankstatement/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
                                        <?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/bankstatement/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
                                    <?php }else{ ?>
                                        <div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/bankstatement/'.$file); ?>"/></a></div>
                                    <?php }} ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($record->residence_address_proof)){  ?>
                                <div style="width:100%" class="quote-imgs-thumbs">
                                    <p>Address Proof:</p> 
                                    <?php $imagearray=explode(',',$record->residence_address_proof); foreach($imagearray as $file){ ?>
                                        <?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/resident/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
                                        <?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/resident/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
                                    <?php }else{ ?>
                                        <div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/resident/'.$file); ?>"/></a></div>
                                    <?php }} ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($record->itr_docs)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>ITR:</p> 
									<?php $imagearray=explode(',',$record->itr_docs); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/itr/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){
										 ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/itr/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/itr/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->cheque_docs)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Cancelled Cheque Docs:</p> 
									<?php $imagearray=explode(',',$record->cheque_docs); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/canceled_cheque/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){
										 ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/canceled_cheque/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/canceled_cheque/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
                        </div>
                        <div class="information">
                            <h4>Trade Reference</h4>
                            <ul>
                                <li><span>Reference Name:</span> <?php echo $record->reference; ?></li>
                                <li><span>Reference mobile number:</span> <?php echo $record->reference_number; ?></li>
                            </ul>
                        </div>
						<!--div class="float-left">
							<a href="<?php //echo admin_url('merchant/partner_comments/'.$record->user_id); ?>" class="btn btn-primary">Partner Comment</a>
						</div-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="LargeImageModel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
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
			<div class="modal-body" id="modaldocbody">
				
			</div>

			<div class="modal-footer">
				<button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="RejectCaseModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Reject Case
			</div>
			<div class="modal-body">
				<div class="form-row mt-3">
					<div class="col-12 col-sm-12">
						<small class="text-danger" id="reject_comment_error"></small>
						<input type="hidden" id="rejector_id" >
						<textarea class="multisteps-form__input form-control" id="reject_comments" type="text" placeholder="Comments" ></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="RejectCaseSubmit()" class="btn btn-primary">Submit</button>
				<button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="DisbursedModel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="modal_content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Disbursed Amount</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12">
                    <input type="hidden" id="disbursed_id" value="<?php echo $record->user_id; ?>">
                    <small class="text-danger" id="disbursederror"></small>
                    <input type="number" id="disburse_amount"  placeholder="Disburse Amount" class="multisteps-form__input form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="DisbursedSubmit" class="btn btn-primary" >Save</button>
            </div>
        </div>
    </div>
</div>