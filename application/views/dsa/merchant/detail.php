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
<?php if(SubPermission(18)){ ?>
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
				<?php if($comment->commented_by=='PARTNER'){ ?> You <?php }else{ echo 'Admin'; } ?>
			</span> 
		   <span class="direct-chat-timestamp pull-right"><?php echo  date('d M Y h:i A',strtotime($comment->created_at)); ?></span> </div> 
		   
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
		<button onclick="SubmitComment(`<?php echo $this->session->userdata('user_id'); ?>`,`PARTNER`)" style="margin-left:14px;" type="button"  class="d-inline-block btn btn-secondary btn-sm partnerbtn">
		 <small style="font-size: 66%;">SEND <i class="fas fa-share" style="font-size: 13px;"></i></small>
		</button>
  </div> 
</div>
<?php } ?>
<div class="section-space40 bg-white"  style="padding-bottom:0px;">
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
            <?php $this->load->view('dsa/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            
                    	<H3 class="text-left">Personal Detail
							<div class="float-right">
								<div class="buttons">
								<h5>
								<?php if(SubPermission(17)){ ?>
									<a class="button viewbutton" href="<?php echo dsa_url('merchant/DownloadApplicant/'.$record->user_id) ?>" class="ediprofile-button"><i class="fa fa-download"></i>Download</a>
								<?php } ?>
								</h5>
								</div>
							</div>
						</H3>
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
												<a href="#"><b>Dob:</b> <?php echo $record->date_of_birth; ?></a>
											</span>
											<span class="company">
												<a href="#"><b>Mob:</b> +91 <?php echo $record->mobile_number; ?></a>
											</span>
											<span class="company">
												<a href="#"><b>Type of Loan:</b> <?php echo $record->loan_type; ?></a>
											</span>
											<span class="company">
												<a href="#"><b>Status:</b> <?php if(!empty($record->lender_status) && !empty($record->lender_status)){ echo $record->lender_status; }elseif($record->status!=""){ echo $record->status; }else{ echo 'RECEIVED'; } ?></a>
											</span>
											<?php if(!empty($status) && $status=='DISBURSED' && !empty($status)){ ?>
												<span class="company">
													<a href="#"><b>Disbursed Amount:</b><?php echo $record->disbursed_amount; ?></a>
												</span>
											<?php } ?>
										</div>
									</div>
							   </div>
						  </div>
						  
						 <div class="information">
							<h4>Business info</h4>
							  <ul>
								<li><span>Business Name:</span> <?php echo $record->company_name; ?></li>
								<li><span>Address:</span> <?php echo $record->business_address; ?></li>
								<li><span>Pincode:</span> <?php if($record->pincode=='Other'){ echo $record->other_pincode; }else{ echo $record->pincode; } ?></li>
								<li><span>State:</span> <?php echo $record->state; ?></li>
								<li><span>City:</span> <?php if($record->city=='Other'){ echo $record->other_city; }else{ echo $record->city; } ?></li>
								<li><span>Type of firm:</span> <?php echo $record->business_type; ?></li>
							    <li><span>Nature of business:</span> <?php echo $record->nature_of_business; ?></li>
							    <li><span>Type of <?php echo $record->nature_of_business; ?>:</span> <?php echo $record->type_of_nature; ?></li>
								<?php  if($record->business_type=='Partnership'){ ?>
								<li><span>No of Partner:</span> <?php echo $record->total_director_partner; ?></li>
								<?php }elseif($record->business_type=='PVT .ltd'){  ?>
									<li><span>No of Director:</span> <?php echo $record->total_director_partner; ?></li>
								<?php }  ?>
								<li><span>No of year business:</span> <?php echo $record->vintage; ?> year</li>
								<li><span>Desired loan amount:</span> <?php echo $record->desired_amount; ?></li>
								<li><span>Monthly turn over:</span> <?php echo $record->turn_over; ?></li>
							</ul>
						</div>
						<?php if(!empty($record->applicant)){ ?>
                        <h3 class="text-left">Co-Applicants</h3>
                         <table class="table">
						   <thead>
						     <tr>
							   <th scope="col">Pancard</th>
							   <th scope="col">Name</th>
							   <th scope="col">Pan Number</th>
							   <th scope="col">Relationship</th>
							  </tr>
						     </thead>
						    <tbody>
							<?php foreach($record->applicant as $applicant){  ?>
							<tr>
							  <td>
							  	<?php if(!empty($applicant->pancard_image)){  ?>
									<?php if(!empty($applicant->pancard_image)){ $imagearray=explode(',',$applicant->pancard_image); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/pancard/'.$file); ?>`)" style="font-size:40px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/pancard/'.$file)); ?>`)"  style="font-size:40px;"  class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
											<div class="m-2"><a href="javascript:void(0)" onclick="ShowLargeImage(`<?php echo base_url('uploads/merchant/pancard/'.$file); ?>`)" style="font-size:40px;"  class="text-primary"><i class="fa fa-image" aria-hidden="true"></i></a></div>
									<?php }}} ?>
								<?php } ?>
							  </td>
							  <td><?php echo $applicant->name; ?></td>
							  <td><?php echo $applicant->pan_number; ?></td>
							  <td><?php echo $applicant->relationship; ?></td>
							</tr>
							<?php } ?>
							</tbody>
						 </table>
						<?php } ?>
						
						<div class="information">
							<h4>Upload Documents</h4>
							<?php if(!empty($record->pan_number)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Pan No. : <b><?php echo $record->pan_number; ?></b></p> 
									<?php if(!empty($record->pancard_image)){ $imagearray=explode(',',$record->pancard_image); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/pancard/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/pancard/'.$file)); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/pancard/'.$file); ?>"/></a></div>
									<?php }}} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->gst_number)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>GST No. : <b><?php echo $record->gst_number; ?></b></p> 
									<?php if(!empty($record->gstproof_image)){ $imagearray=explode(',',$record->gstproof_image); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/gst/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/gst/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/gst/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php }} ?>
							<?php if(!empty($record->business_address)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Business Address : <b><?php echo $record->business_address; ?></b></p> 
									<?php if(!empty($record->business_address_proof)){  $imagearray=explode(',',$record->business_address_proof); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/business/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/business/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/business/'.$file); ?>"/></a></div>
									<?php }}} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->resident_address)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Residence Address : <b><?php echo $record->resident_address; ?></b></p> 
									<?php if(!empty($record->resident_address_proof)){ $imagearray=explode(',',$record->resident_address_proof); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/resident/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/resident/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/resident/'.$file); ?>"/></a></div>
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
							<?php if(!empty($record->ownership_proof)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Ownership Proof:</p> 
									<?php $imagearray=explode(',',$record->ownership_proof); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/ownership/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/ownership/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/ownership/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->partnership_deal)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Partnership Deed Proof:</p> 
									<?php $imagearray=explode(',',$record->partnership_deal); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/partnership/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/partnership/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/partnership/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->tan_image)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>MOA/AOA:</p> 
									<?php $imagearray=explode(',',$record->tan_image); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/tan/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/tan/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/tan/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->coi_image)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>COI Proof:</p> 
									<?php $imagearray=explode(',',$record->coi_image); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/coi/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/coi/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/coi/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->boardresolution)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Board Resolution:</p> 
									<?php $imagearray=explode(',',$record->boardresolution); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/boardresolution/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){
										 ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/boardresolution/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/boardresolution/'.$file); ?>"/></a></div>
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
							<?php if(!empty($record->additional_docs)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Additional Docs:</p> 
									<?php $imagearray=explode(',',$record->additional_docs); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/addition_docs/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){
										 ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/addition_docs/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/addition_docs/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if($record->business_type=='PVT .ltd'){ ?>
								<H3>Director Documents </H3>
							<?php }elseif($record->business_type=='Partnership'){ ?>
								<H3>Partner Documents </H3>
							<?php } ?>
							<?php if(!empty($record->partner)){ foreach($record->partner as $pt){ ?>
							<div class="row quote-imgs-thumbs">
								<div class="col-md-4">
									<div class="photodocument">
										<span><b> <?php echo $pt->name; ?> </b></span> 
										<?php if(!empty($pt->director_partner_proof)){ $array=explode(',',$pt->director_partner_proof); foreach($array as $file){ ?>
											<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
												<a style="font-size:50px;" href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/other/'.$file); ?>`)" class="text-danger img-fluid"><i class="fa fa-file-pdf"></i></a>
											<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
												<a style="font-size:50px;"  href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/other/'.$file)); ?>`)"  class="text-primary img-fluid"><i class="fa fa-file-word"></i></a>
											<?php }else{ ?> 
												<a href="javascript::void(0)"><img onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/other/'.$file); ?>" class="img-fluid partnerimg"/></a>
											<?php } ?>
										<?php  }} ?>
									</div>
								</div>
								<div class="col-md-4">
									<div class="photodocument">
									<span><b> <?php echo $pt->pan_number; ?> </b></span>
									<?php $array=explode(',',$pt->pancard_image); foreach($array as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<a style="font-size:50px;"  href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/other/'.$file); ?>`)" class="text-danger img-fluid"><i class="fa fa-file-pdf"></i></a>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<a style="font-size:50px;" href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/other/'.$file)); ?>`)" class="text-primary img-fluid"><i class="fa fa-file-word"></i></a>
										<?php }else{ ?> 
											<a href="javascript::void(0)"><img onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/other/'.$file); ?>" class="img-fluid"/></a>
										<?php  }} ?>
									</div>
									
								</div>
								<div class="col-md-4">
									<div class="photodocument">
										<span><b> <?php echo $pt->address; ?> </b></span>
										<?php $array=explode(',',$pt->address_proof); foreach($array as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<a style="font-size:50px;"  href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo base_url('uploads/merchant/other/'.$file); ?>`)" class="text-danger"><i class="fa fa-file-pdf"></i></a>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<a style="font-size:50px;"  href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(base_url('uploads/merchant/other/'.$file)); ?>`)" class="text-primary"><i class="fa fa-file-word"></i></a>
										<?php }else{ ?>  
											<a href="javascript::void(0)"><img onclick="ShowLargeImage(this.src)" src="<?php echo base_url('uploads/merchant/other/'.$file); ?>" class="img-fluid"/></a>
										<?php  }} ?>
									</div>
								</div>
							</div>
							<hr>
							<?php } } ?>
						</div>
						<div class="information">
							<h4>Trade Reference</h4>
							  <ul>
								<li><span>Reference Name:</span> <?php echo $record->reference; ?></li>
								<li><span>Reference mobile number:</span> <?php echo $record->reference_number; ?></li>
							</ul>
						</div>
						
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

