<style>
    #progressbar li {
        width:20% !important;
    }
    .job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.job-list .content { width: 100%;}
.mobile { float: right;font-size: 15px;}
.job-list .body .content .info span { margin-right: 20px; border-right: 1px solid #ccc; padding-right: 20px;}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Lender Comments</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Lender Comments</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>
            <?php $this->load->view('lender/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <div class="comments-area mb40">
                                <h3 class="comments-title">Comments
                                    <div class="float-right">
                                        <div class="buttons">
                                            <?php /* if($record->verify_status!="APPROVED" && $record->verify_status!="DISBURSED"){ ?>
                                                <a href="<?php echo lender_url('merchant/approve/'.$record->user_id); ?>" class="button viewbutton">Approve</a> 
                                            <?php }elseif($record->verify_status=="APPROVED"){ ?>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#DisbursedModel" class="button viewbutton">Disburse</a> 
                                            <?php } ?>
                                            <?php if($record->verify_status!="APPROVED" && $record->verify_status!='DISBURSED'){ ?>
                                                <a href="<?php echo lender_url('merchant/reject/'.$record->user_id); ?>" class="button viewbutton">Reject</a> 
                                            <?php } */ ?>
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
                                                    <a href="#"><b>Email:</b> <?php echo $record->email; ?></a>
                                                </span>
                                                
                                                <span class="company">
                                                    <a href="#"><b>Mob:</b> +91 <?php echo $record->mobile_number; ?></a>
                                                </span>
                                                <span class="company">
                                                    <a href="#"><b>Type of employement:</b> <?php if($record->employment_type){ echo $record->employment_type; }elseif(!empty($record->loan_type)){ echo $record->loan_type; }; ?></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php if(!empty($comments)){ foreach($comments as $comment){ ?>
                                <ul class="comment-list listnone">
                                    <li class="comment">
                                        <div class="comment-body mb30">
                                            <div class="">
                                                <div class="">
                                                    <div class="comment-header">
                                                        <?php if($comment->commented_by=='SUPER-ADMIN'){ ?>
                                                            <h4 class="user-title">Admin</h4>
                                                        <?php }else{ ?>
                                                            <h4 class="user-title">You</h4>
                                                        <?php } ?>
                                                        <div class="comment-meta">
                                                            <span class="comment-meta-date"><?php echo  date('d M Y h:i A',strtotime($comment->created_at)); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="comment-content" style="width: 70%;">
                                                        <?php if($comment->is_resolved!=""){ ?>
                                                        <div class="user-title">
                                                            <b>Resolved </b>:<?php echo ucfirst($comment->is_resolved); ?>
                                                            <b>Resolved By </b>:<?php if($comment->resolved_by=='LENDER'){ echo 'You'; }elseif($comment->resolved_by=='SUPER-ADMIN'){ echo 'Admin'; } ?>
                                                        <?php } ?>
                                                        <p>
                                                            <?php echo $comment->comment; ?>
                                                        </p>
                                                        
                                                    </div>
                                                    <?php if($comment->is_resolved==""){ ?>
                                                    <div class="buttons float-right">
                                                        <button style="margin-top:-120px;" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Resolved <span class="sr-only"></span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?php echo lender_url('merchant/resolved/'.$comment->comment_id.'/yes');  ?>">Yes</a>
                                                            <a class="dropdown-item" href="<?php echo lender_url('merchant/resolved/'.$comment->comment_id.'/no');  ?>">No</a>
                                                        </div>
                                                    </div>
                                                    <?php  }  ?>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </li>
                                </ul>
                                <?php }} ?>
                            </div>

                            <div class="leave-comments pinside30 bg-primary mb30">
                                <div class="proceedwork">
                                    <input type="hidden" id="assign_id" value="<?php echo $record->assign_id; ?>">
                                    <h3 class="text-white">Leave A Comments</h3>
                                    <!-- <div class="chiller_cb">
                                        <input type="radio" name="verify_status" <?php //if($record->verify_status=='APPROVED'){ echo "checked"; } ?> onclick="BtnEnabled()" id="approved" value="APPROVED" name="radio-group" />
                                        <label for="approved" class="text-white">Approved</label>
                                    </div>
                                    <div class="chiller_cb">
                                        <input type="radio" name="verify_status"  <?php //if($record->verify_status=='REJECTED'){ echo "checked"; } ?> onclick="BtnEnabled()" value="REJECTED" id="reject" name="radio-group" />
                                        <label for="reject" class="text-white">Reject</label>
                                    </div>
                                    <div class="chiller_cb">
                                        <input type="radio" name="verify_status" onclick="BtnEnabled()"  <?php //if($record->verify_status=='PENDING'){ echo "checked"; } ?> value="PENDING" id="missing" name="radio-group" />
                                        <label for="missing" class="text-white">Missing Paper work</label>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="control-label" for="message"> </label>
                                        <textarea class="form-control" id="message" onkeyup="BtnEnabled()" rows="7" name="message" placeholder="Enter your Message"></textarea>
                                    </div> 
                                    <button id="singlebutton" onclick="SubmitComment()" disabled type="button" name="singlebutton" class="btn btn-secondary">
                                        leave comments
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <input type="number" id="disbursed_amount"  placeholder="Disburse Amount" class="multisteps-form__input form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="DisbursedSubmit" class="btn btn-primary" >Save</button>
            </div>
        </div>
    </div>
</div>


