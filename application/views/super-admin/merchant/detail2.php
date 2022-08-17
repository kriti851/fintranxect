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

.li-new-width{
	width:33% !important;
}


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
	font-size: 13px;
    background: #1787ff;
    color: #fff;
    padding: 10px;
    position: fixed;
    right: 0px;
    bottom: 10%;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
.fixedRemark {
	font-size: 13px;
    background: #1787ff;
    color: #fff;
    padding: 10px;
    position: fixed;
    right: 0px;
    bottom: 20%;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
.fixedFollwup {
	font-size: 13px;
    background: #1787ff;
    color: #fff;
    padding: 10px;
    position: fixed;
    right: 0px;
    bottom: 30%;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
.fixedchecklist{
	font-size: 13px;
    background: #1787ff;
    color: #fff;
    padding: 10px;
    position: fixed;
    right: 0px;
    bottom: 40%;
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



#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    counter-reset: step;
    padding-left: 0px;
}
#progressbar li {
    list-style-type: none;
    color: #040404;
    text-transform: capitalize;
    font-size: 12px;
    width: 12%;
    float: left;
    position: relative;
    letter-spacing: 1px;
    margin-top: 20px;
}
#progressbar li.active:before, #progressbar li.active:after {
    background: #16549a;
    color: white;
}
#progressbar li:before {
    content: counter(step);
    counter-increment: step;
    width: 20px;
    line-height: 20px;
    display: block;
    font-size: 10px;
    color: #333;
    background: #d0cece;
    border-radius: 9px;
    margin: 0 auto 5px auto;
    z-index: 2;
    position: relative;
}
#progressbar li:after {
    content: '';
    width: 100%;
    height: 1px;
    background: #d0cece;
    position: absolute;
    left: -50%;
    top: 9px;
    z-index: 1;
}
.dropbtn {
  border: none;
}

.dropup {
  position: relative;
  display: inline-block;
}

.dropup-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  bottom: 33px;
  z-index: 1;
}

.dropup-content a {
  color: black;
  text-decoration: none;
  display: block;
}

.dropup-content a:hover {background-color: #ccc}

.dropup:hover .dropup-content {
  display: block;
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
<span onclick="OpenChecklist()"><i class="fixedchecklist">Check List</i></span>
	<div id="checkListSidebar" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeChecklist()">
			<i class="far fa-arrow-alt-circle-right" style="font-size: 30px;"></i>
		</a>
		<div class="box-body" style="height:100% !important;">  
			<div class="col-md-12">
				<div class="md-input">
					<input type="text" title="Name On Pan Card" value="<?php echo $record->full_name; ?>" class="md-form-control" required="">
					<label>Name On Pan Card</label>
				</div>
			</div>
			<div class="col-md-12">
				<div class="md-input">
					<input type="text" title="Age" oninput="this.value = Math.abs(this.value)" value="<?php echo $record->age; ?>" class="md-form-control" required="">
					<label>Age</label>
				</div>
			</div>
			<div class="col-md-12">
				<div class="md-input">
					<input type="text" title="Mobile Number"  value="<?php echo $record->mobile_number; ?>" class="md-form-control" required="">
					<label>Mobile Number</label>
				</div>
			</div>
			<div class="col-md-12">
				<div class="md-input">
					<input type="text" title="Email" value="<?php echo $record->email; ?>" class="md-form-control" required="">
					<label>Email</label>
				</div>
			</div>
			<div class="col-md-12">
				<div class="md-input">
					<input type="text" title="Loan Requirement" value="<?php if(!empty($checklist->loan_requirement)){ echo $checklist->loan_requirement; } ?>" class="md-form-control" required="">
					<label>Loan Requirement</label>
				</div>
			</div>
		</div>
	</div>
<?php if(SubPermission(35)){ ?>
	<span onclick="openRemarkNav()"><a href="javascript:void(0)"><i class="fixedRemark">Remark</i></a></span>

	<div id="myRemarkSidenav" class="sidenav">
	<a href="javascript:void(0)" class="closebtn" onclick="closeRemarkNav()">
		<i class="far fa-arrow-alt-circle-right" style="font-size: 30px;"></i>
	</a>
	
	<div class="box-body">  
		<div class="direct-chat-messages remarkstyle" id="style-4">
			<?php foreach($remarks as $remark){ ?>
			<div class="direct-chat-msg right">
			<div class="direct-chat-info clearfix"> 
				<span class="direct-chat-name pull-right">
					You
				</span> 
			<span class="direct-chat-timestamp pull-right"><?php echo  date('d M Y h:i A',strtotime($remark->created_at)); ?></span> </div> 
			<div class="direct-chat-text"><?php echo $remark->comments; ?></div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="textarea" style="width: 21%;">
		<small class="text-danger" style="margin-left:14px;" id="remark_comment_error"></small>
		<input type="hidden" id="remark_merchant_id" value="<?php echo $record->user_id; ?>">		
		<textarea id="remark_comments" placeholder="Enter your comment"></textarea>
		<div class="col-md-12">
			<span style="font-size: 13px">Set Follow up</span>
			<span style="float:right;"> 
				<label class="switch">
				<input type="checkbox" id="remarkswitch">
				<span class="slider round"></span>
				</label>
			</span>
		</div>
		<div id="remarkdatetime"class="col-md-12">
		</div> 
		<button type="button" onclick="RemarkSubmit()" style="margin-left:14px;" class="d-inline-block btn btn-secondary btn-sm partnerbtn">
			Remark
		</button>
	</div>
	</div>
<?php } ?>
<?php if(SubPermission(33)){ ?>
	<span onclick="openFollowUpNav()"><a href="javascript:void(0)"><i class="fixedFollwup">Follow Up</i></a></span>
	<div id="openFollowUpNav" class="sidenav">
	<a href="javascript:void(0)" class="closebtn" onclick="closeFollowUpNav()">
		<i class="far fa-arrow-alt-circle-right" style="font-size: 30px;"></i>
	</a>
	<div class="box-body">  
		<div class="direct-chat-messages followupstyle" id="style-8">
		</div>
	</div>
	</div>
<?php } ?>
<?php if(SubPermission(34)){ ?>
<!-- COMMENTS OPTION START -->
<span onclick="openNav()"><i class="fixedcomment">Comments</i></span>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
     <i class="far fa-arrow-alt-circle-right" style="font-size: 30px;"></i>
  </a>
   
 <div class="box-body">  
    <div class="direct-chat-messages commentstyle" id="style-4">
		<?php foreach($comments as $comment){ ?>
        <div class="direct-chat-msg <?php if($comment->commented_by=='SUPER-ADMIN'){ echo 'right'; } ?>">
           <div class="direct-chat-info clearfix"> 
		   	<span class="direct-chat-name <?php if($comment->commented_by=='SUPER-ADMIN'){ echo 'pull-right'; }else{ echo 'pull-left'; } ?>">
				<?php if($comment->commented_by=='SUPER-ADMIN'){ ?> You : <?php echo strtolower($comment->comment_for).'-'.$comment->company_name; }else{
					echo strtolower($comment->comment_for).'-'.$comment->company_name; } ?>: You
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
	<button onclick="SubmitComment(`<?php echo $record->created_by; ?>`,`PARTNER`,`<?php echo $record->dsa->company_name; ?>`)" type="button" style="margin-left:14px;" class="d-inline-block btn btn-secondary btn-sm partnerbtn">
		 <small style="font-size: 66%;"><i class="fas fa-reply" style="font-size: 13px;"></i> Partner </small>
	</button>
		<?php if(!empty($record->assign->lender_id)){ 
			$multiLenders = $this->merchant_model->GetMultipleAssignedLender($record->user_id);
		?>
			<div class="dropup">
			<button style="margin-left:14px;" type="button"  class="dropbtn d-inline-block btn btn-secondary btn-sm partnerbtn">
				<small style="font-size: 66%;">Lender <i class="fas fa-share" style="font-size: 13px;"></i></small>
			</button>
			<div class="dropup-content">
				<?php foreach($multiLenders as $len){ ?>
					<a style="font-size:15px;" href="javascript:void(0)" onclick="SendLenderComment(`<?php echo $len->lender_id; ?>`,`<?php echo $len->company_name; ?>`)"><?php echo $len->company_name; ?></a>
				<?php }  ?>
				</div>
			</div>
	<?php } ?>
  </div>
</div>
<?php } ?>

<div class="section-space40 bg-white" style="padding-bottom:0px;">
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

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
						<H3 class="text-left">Personal Detail
							<?php if(!empty($record->user_id)){ ?>
								<div class="float-right">
									<div class="buttons">
										<h5>
										<?php if(SubPermission(29)){ ?>
											<a style="display:none;" id="extra-log-cases" href="<?php echo admin_url('merchant/lender_assign/'.$record->user_id); ?>" class="button viewbutton">Logged</a>
										<?php } ?>
										<?php if($record->status!='INCOMPLETE'){ ?>
											<?php if((!empty($record->assign) && $record->assign->status=='ASSIGNED')){ ?>
												<?php if(SubPermission(29)){ ?>
													<a href="<?php echo admin_url('merchant/lender_assign/'.$record->user_id); ?>" class="button viewbutton">Logged</a>
												<?php } ?>
											<?php } ?>
											<?php
												if($record->total_assigned=="" && empty($record->assign)){ ?>
												<?php if(SubPermission(28)){ ?>
													<a href="<?php echo admin_url('merchant/assign_case/'.$record->user_id); ?>" class="button viewbutton">Assign Lender</a>
												<?php } ?>
												<?php if(SubPermission(30)){ ?>
													<a href="javascript:void(0)" onclick="RejectCaseModal(`<?php echo $record->user_id; ?>`,``)" class="button viewbutton">Reject</a>
												<?php } ?>
											<?php }
											
											if(($record->total_assigned!="" && $record->total_assigned==$record->total_reject )|| (!empty($record->assign)) && $record->assign->status=='REJECTED'){ ?>
												<?php if(SubPermission(36)){ ?>
													<a href="javascript:void(0)" onclick="ActivateCaseModal(`<?php echo $record->user_id; ?>`)" class="button viewbutton">Reactive</a>
												<?php }	?>
											<?php }	?>
											
											<?php if(SubPermission(38)){ ?>
												<a href="<?php echo admin_url('merchant/DownloadApplicant/'.$record->user_id); ?>" class="button viewbutton"><i class="fa fa-download"></i>Export</a>
											<?php } ?>
											<?php if($record->status=='' && empty($record->assign)){ ?>
												<?php if(SubPermission(33)){ ?>
													<a href="<?php echo admin_url('merchant/incompletecase/'.$record->user_id); ?>" class="button viewbutton">Incomplete</a>
												<?php } ?>
											<?php } ?>
											<?php $newgrowth=$this->common_model->GetRow('newgrowth_lead',['user_id'=>$record->user_id]);
												if(!empty($newgrowth)){
											?>
												<a href="javascript:void(0)" class="button viewbutton" onclick="GetNewGrowthStatus(`<?php echo $newgrowth->lead_id; ?>`)">Neogrowth Detail</a>
											<?php }else{ ?>
												<a href="javascript:void(0)" class="button viewbutton" onclick="showNewgrowthModel()">Neogrowth Register</a>
											<?php } ?>
										<?php }else{ ?>
											<?php if(empty($record->assign) || (!empty($record->assign) && $record->assign->status!='SHORTCLOSE')){ ?>
													<?php if(SubPermission(27)){ ?>
														<a href="<?php echo admin_url('merchant/shortclose/'.$record->user_id); ?>" class="button viewbutton"><?php echo "Short Close"; ?></a>
													<?php } ?>
											<?php } ?>
											<?php if((!empty($record->assign) && $record->assign->status=='SHORTCLOSE')){ ?>
												<?php if(SubPermission(36)){ ?>
													<a href="<?php echo admin_url('merchant/reactive/'.$record->user_id); ?>" class="button viewbutton"><?php echo "Reactive"; ?></a>
												<?php } ?>
											<?php } ?>
										<?php } ?>
										<?php if(SubPermission(39)){ ?>
											<a href="<?php echo admin_url('merchant/edit/'.$record->user_id); ?>" class="button viewbutton"><i class="fa fa-edit"></i>Edit</a>
										<?php } ?>
										</h5>
									</div>
								</div>
							<?php }  ?>
						</H3>
						<hr>
						
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
												<a href="#"><b>Created At: </b><?php echo date('d M Y h:i A',strtotime($record->created_at)); ?></a>
											</span>
										</div>
									</div>
							   </div>
						  </div>
						  <div class="information">
						 		<?php if(($record->total_assigned!="" && $record->total_assigned>$record->total_reject) || (!empty($record->assign) && $record->assign->lender_id!="")){  ?>
									<h4>Assigned Lender</h4>
									<?php if(SubPermission(29)){ ?>
										<script>document.getElementById("extra-log-cases").style = "";</script>
									<?php } ?>
									<?php
										$multipleLender = $this->merchant_model->GetMultipleAssignedLender($record->user_id);
										foreach($multipleLender as $singelLender){  ?>
										<ul>
											<li class="li-new-width"><span>Lender :</span> <?php echo $singelLender->company_name; ?></li>
											<li class="li-new-width"><span>Status :</span> <?php echo $singelLender->status; ?></li>
											<?php  if($singelLender->status=='DISBURSED'){ ?>
												<li class="li-new-width"><span>Disbursed Amount :</span> <?php echo $singelLender->disbursed_amount; ?></li>
											<?php }else{ ?>
												<?php
													$is_permission_=false;
													$seigleStatus="";
													if($singelLender->status=='LOGGED' || $singelLender->status=='PENDING'){ 
														if(SubPermission(31)){
															$is_permission_=true;
														}
														$seigleStatus='approve';
													}elseif($singelLender->status=='APPROVED'){ 
														if(SubPermission(32)){
															$is_permission_=true;
														}
														$seigleStatus='disburse';
													} 
													if($seigleStatus!='disburse' && $singelLender->status!='REJECTED'){
												?>
													<li class="li-new-width">
														<div class="buttons mt-4" ><h5>
															<?php if($is_permission_){ ?>
																<a class="button viewbutton" href="<?php echo admin_url('merchant/'.$seigleStatus.'/'.$record->user_id.'/'.$singelLender->lender_id); ?>"><?php echo ucfirst($seigleStatus); ?></a>
															<?php } ?>
															<?php if(SubPermission(30)){ ?>
																<a class="button viewbutton" href="javascript:void(0)" onclick="RejectCaseModal(`<?php echo $record->user_id; ?>`,`<?php echo $singelLender->lender_id ?>`)">Reject</a>
															<?php } ?>
														</h5></div>
													</li>
												<?php }elseif($seigleStatus=='disburse' && $is_permission_==true){ ?>
													<li class="li-new-width">
														<div class="buttons mt-4" ><h5>
															<a class="button viewbutton" href="javascript:void(0)" onclick="DisbursedModal(`<?php echo $record->user_id; ?>`,`<?php echo $singelLender->lender_id ?>`)">Disburse</a>
														</h5></div>
													</li>
												<?php } ?>
											<?php } ?>
										</ul>
									<?php 	} ?>
								
								<?php }else{
									if(!empty($record->assign) && $record->assign->status=='ASSIGNED'){ ?>
									<h4>Status: Assigned</h4>
									<?php
									}elseif(!empty($record->assign) && $record->assign->status=='SHORTCLOSE'){ ?>
										<h4>Status: Shortclose</h4>
									<?php
									}elseif(!empty($record->assign) && $record->assign->status=='REJECTED'){ ?>
										<h4>Status: Rejected</h4>
									<?php }else{
								?>
								<h4>Status: <?php if($record->status==null){ echo "Received"; }else{ echo "Incomplete"; } ?></h4>
							<?php }} ?>
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
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/pancard/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/pancard/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/pancard/'.$file); ?>"/></a></div>
									<?php }}} ?>
								</div>
							<?php } ?>
                            <?php if(!empty($record->aadhar_number)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Aadhar No. : <b><?php echo $record->aadhar_number; ?></b></p> 
									<?php if(!empty($record->aadhar_image)){ $imagearray=explode(',',$record->aadhar_image); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/aadharcard/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/aadharcard/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/aadharcard/'.$file); ?>"/></a></div>
									<?php }}} ?>
								</div>
							<?php } ?>
                            <?php if(!empty($record->salery_slip)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
                                    <p>Salary Silp : </p>
									<?php if(!empty($record->salery_slip)){ $imagearray=explode(',',$record->salery_slip); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/salery_slip/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/salery_slip/'.$file)); ?>`)"  class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/salery_slip/'.$file); ?>"/></a></div>
									<?php }}} ?>
								</div>
							<?php } ?>							
							<?php if(!empty($record->bank_statement)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>6 Month bank statement: <?php if(!empty($record->bankstatement_password)){ echo '( Password :- '.$record->bankstatement_password.' )'; } ?></p> 
									<?php $imagearray=explode(',',$record->bank_statement); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/bankstatement/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/bankstatement/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/bankstatement/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->residence_address_proof)){  ?>
                                <div style="width:100%" class="quote-imgs-thumbs">
                                    <p>Address Proof:</p> 
                                    <?php if(!empty($record->residence_address_proof)){ $imagearray=explode(',',$record->residence_address_proof); foreach($imagearray as $file){ ?>
                                        <?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/resident/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
                                        <?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){ ?>
                                            <div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/resident/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
                                    <?php }else{ ?>
                                        <div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/resident/'.$file); ?>"/></a></div>
                                    <?php }}} ?>
                                </div>
                            <?php } ?>
							<?php if(!empty($record->itr_docs)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>ITR:</p> 
									<?php $imagearray=explode(',',$record->itr_docs); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/itr/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){
										 ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/itr/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/itr/'.$file); ?>"/></a></div>
									<?php }} ?>
								</div>
							<?php } ?>
							<?php if(!empty($record->cheque_docs)){  ?>
								<div style="width:100%" class="quote-imgs-thumbs">
									<p>Cancelled Cheque Docs:</p> 
									<?php $imagearray=explode(',',$record->cheque_docs); foreach($imagearray as $file){ ?>
										<?php if(pathinfo($file,PATHINFO_EXTENSION) == 'pdf'){ ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`<?php echo s3_url('uploads/merchant/canceled_cheque/'.$file); ?>`)" style="font-size:60px;" class="text-primary"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></div>
										<?php }elseif(pathinfo($file,PATHINFO_EXTENSION) == 'doc' || pathinfo($file,PATHINFO_EXTENSION) == 'docx'){
										 ?>
											<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" onclick="ShowLargeDoc(`https://view.officeapps.live.com/op/embed.aspx?src=<?php echo urlencode(s3_url('uploads/merchant/canceled_cheque/'.$file)); ?>`)"  style="font-size:60px;" class="text-primary"><i class="fa fa-file-word" aria-hidden="true"></i></a></div>
									<?php }else{ ?>
										<div class="m-2"><a href="javascript::void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" src="<?php echo s3_url('uploads/merchant/canceled_cheque/'.$file); ?>"/></a></div>
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
						<?php if(!empty($rejectedcase)){ ?>
							<div class="information">
								<h4>Reject & Activate Status Detail</h4>
								<?php foreach($rejectedcase as $reject){ ?>
								<ul>
									<li><span>Time:</span> <?php echo date('d M Y h:i A',strtotime($reject->created_at)); ?></li>
									<li><span>Status:</span> <?php echo $reject->status; ?></li>
									<li><span>Rejected BY:</span><?php echo $reject->reject_by ?></li>
									<?php if(!empty($reject->comments)){ ?>
										<li><span>Comments: </span><?php echo $reject->comments ?></li>
									<?php } ?>
									<?php if($reject->reject_by=='LENDER'){
										$lendername=$this->common_model->GetRow('users',['user_id'=>$reject->rejector_id],'full_name,company_name');
									?>
										<li><span>Lender Name:</span><?php echo $lendername->full_name; ?></li>
									<?php } ?>
								</ul>
								<?php } ?>
							</div>
						<?php } ?>
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
						<input type="hidden" id="reject_lender_id" >
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
<div class="modal fade" id="ActivatCaseModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Activate Case
			</div>
			<div class="modal-body">
				<div class="form-row mt-3">
					Are you sure ? You want to activate this case.
				</div>
				<input type="hidden" id="activate_user_id" >
			</div>
			<div class="modal-footer">
				<button type="button" onclick="ActivateCase()" class="btn btn-primary">Confirm</button>
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
<div class="modal fade" id="newgrowthModel" data-backdrop="static" data-keyboard="false">
   
</div>


