<style>
.breadcrumb-form form {
    max-width: 934px;
    position: relative;
    margin-left: 0px;
    float: right;
    display: block;
    width: 100%;
}
.formselect{
    width: 100%;
    border: 0;
    border-radius: 0;
    border-bottom: 2px solid rgba(36, 109, 248, 0.2);
    background: transparent;
    outline: none;
    height: 50px;
    padding: 0;
    -webkit-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Cases Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Merchant Reports Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#" class="form-inline">
                        <?php  if(!empty($this->input->get('type'))){ ?>
                            <input type="hidden" name="type" value="<?php echo $this->input->get('type'); ?>">
                        <?php } ?>
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="type" title="Status" class="formselect">
                                    <option value="" >ALL STATUS</option>
                                    <option value="logged" <?php if($this->input->get('type')=='logged'){ echo "selected"; } ?>>LOGGED</option>
                                    <option value="pending" <?php if($this->input->get('type')=='pending'){ echo "selected"; } ?>>PENDING</option>
                                    <option value="approved" <?php if($this->input->get('type')=='approved'){ echo "selected"; } ?>>APPROVED</option>
                                    <option value="rejected" <?php if($this->input->get('type')=='rejected'){ echo "selected"; } ?>>REJECTED</option>
                                    <option value="disbursed" <?php if($this->input->get('type')=='disbursed'){ echo "selected"; } ?>>DISBURSED</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="formselect" title="Loan Type" name= "loan_type">
                                        <option value="">Loan Type</option>
                                        <option value="Salaried" <?php if($this->input->get('loan_type')=='Salaried'){ echo "selected"; } ?>>Salaried</option>
                                        <option value="Business" <?php if($this->input->get('loan_type')=='Business'){ echo "selected"; } ?>>Business</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </div>                       
                    </form>
                </div>
            </div>

            <?php $this->load->view('lender/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">Cases List
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){
                                $count=$this->common_model->CountResults('comments',['merchant_id'=>$result->user_id,'comment_by'=>$this->session->userdata('user_id'),'comment_for'=>'LENDER','is_read'=>0]);
                            ?>
                            <div class="job-list">
                                <div class="body">
                                <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a href="javascript:void(0)"><b><?php if(!empty($result->company_name)){ echo $result->company_name; }else{ echo $result->full_name; } ?></b></a>
                                        </span>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Assigned At :</b><?php echo date('d M Y h:i A',strtotime($result->created_at)); ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Status :</b><?php  $status=""; if(!empty($result->lender_status)){ echo $status=strtolower($result->lender_status); } ?></a>
                                                <?php 
                                                    if($status=='logged'  && $result->logged_time!=""){
                                                        echo date('d M Y h:i A',strtotime($result->logged_time));
                                                    }elseif($status=='pending' && $result->pending_time!=""){
                                                        echo date('d M Y h:i A',strtotime($result->pending_time));
                                                    }elseif($status=='approved' && $result->approved_time!=""){
                                                        echo date('d M Y h:i A',strtotime($result->approved_time));
                                                    }elseif($status=='rejected' && $result->reject_time!=""){
                                                        echo date('d M Y h:i A',strtotime($result->reject_time));
                                                    }elseif($status=='disbursed' && $result->disbursed_time!=""){
                                                        echo date('d M Y h:i A',strtotime($result->disbursed_time));
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="more">
                                        <div class="buttons">
                                            <a href="<?php echo lender_url('merchant/detail/'.$result->user_id); ?>" class="button viewbutton" ><i class="far fa-eye"></i> View Now <?php if(!empty($count)){ ?><span class="badge badge-light"><?php echo $count; ?></span> <?php } ?></a>
                                        </div>
                                    </div>
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


