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
                <h2>Partner Comments</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Partner Comments</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>
            <?php $this->load->view('dsa/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <div class="comments-area mb40">
                                <h3 class="comments-title">Comments</h3>
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
                                                    <a href="#"><b>Type of employement:</b> <?php echo $record->employment_type; ?></a>
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
                                                            <b>Resolved By </b>:<?php if($comment->resolved_by=='PARTNER'){ echo 'You'; }elseif($comment->resolved_by=='SUPER-ADMIN'){ echo 'Admin'; } ?>
                                                        </div>
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
                                                            <a class="dropdown-item" href="<?php echo dsa_url('merchant/resolved/'.$comment->comment_id.'/yes');  ?>">Yes</a>
                                                            <a class="dropdown-item" href="<?php echo dsa_url('merchant/resolved/'.$comment->comment_id.'/no');  ?>">No</a>
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
                                <h2 class="reply-title text-white">Leave A Comment</h2>
                                <form class="reply-form">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <input type="hidden" id="merchant_id" value="<?php echo $record->user_id; ?>">
                                            <div class="form-group">
                                                <label class="sr-only control-label" for="comments"></label>
                                                <small class="text-danger" id="comment_error"></small>
                                                <textarea class="form-control border-0" id="comments" name="textarea" rows="6" placeholder="Comments"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <button id="singlebutton" onclick="SubmitComment()" type="button" name="singlebutton" class="btn btn-secondary">
                                                    leave comments
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

