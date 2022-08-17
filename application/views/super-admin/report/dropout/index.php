<style>
.breadcrumb-form form {
    max-width: 300px;
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
.job-list .body {
    padding-left: 30px;
    width: calc(100% - 30px);
}
.viewbutton-new {
    background: #1787ff;
    color: #fff !important;
    padding: 5px 10px;
    display: inline-block;
    border-radius: 5px;
    width: 130px;
    text-align: center;
    position: relative;
    top: 15px;
}
</style>

<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Case Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Cases Reports Detail</a></li>
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
                                Dropout Report
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){
                                $lender_id="";
                                if(!empty($result->lender_id)){
                                    $lender_id=$result->lender_id;
                                }
                                $lender=$this->merchant_model->GetAssignedLender($result->user_id);
                                $partner=$this->common_model->GetRow(TBL_USERS,['user_id'=>$result->created_by],'file_id');
                                $count=$this->common_model->CountResults('comments',['merchant_id'=>$result->user_id,'admin_read'=>0]);
                            ?>
                            
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a href="<?php echo admin_url('merchant/edit/'.$result->user_id); ?>"><b><?php if(!empty($result->company_name)){ echo $result->company_name; }else{ echo $result->full_name; } ?></b></a>
                                        </span>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Partner Id :</b><?php if(!empty($partner->file_id)){ echo $partner->file_id; } ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Status :</b><?php $status=""; if(!empty($lender)  && !empty($lender->status)){ echo $status=strtolower($lender->status); }else{ if(!empty($result->status)){ echo $status=strtolower($result->status); }else{ echo $status="received"; } } ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Status At:</b><?php 
                                                    if($status=='incomplete'){
                                                        echo date('d M Y h:i A',strtotime($result->created_at));
                                                    }elseif($status=='chortclose'){
                                                        echo date('d M Y h:i A',strtotime($result->short_close_time));
                                                    }elseif($status=='received'){
                                                        echo date('d M Y h:i A',strtotime($result->received_time));
                                                    }elseif($status=='assigned'){
                                                        echo date('d M Y h:i A',strtotime($result->assigned_time));
                                                    }elseif($status=='logged'){
                                                        echo date('d M Y h:i A',strtotime($result->logged_time));
                                                    }elseif($status=='pending'){
                                                        echo date('d M Y h:i A',strtotime($result->pending_time));
                                                    }elseif($status=='approved'){
                                                        echo date('d M Y h:i A',strtotime($result->approved_time));
                                                    }elseif($status=='rejected'){
                                                        echo date('d M Y h:i A',strtotime($result->rejected_time));
                                                    }elseif($status=='disbursed'){
                                                        echo date('d M Y h:i A',strtotime($result->disbursed_time));
                                                    }
                                                ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Created At :</b><?php echo date('d M Y h:i A',strtotime($result->created_at)); ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Updated At :</b><?php echo date('d M Y h:i A',strtotime($result->updated_at)); ?></a>
                                            </span>
                                            <?php if(!empty($lender) && !empty($lender->full_name)){ ?>
                                            <span class="company">
                                                <a><b>Lender :</b><?php echo $lender->full_name; ?></a>
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="more">
                                        <div class="buttons">
                                            <a href="<?php echo admin_url('merchant/detail/'.$result->user_id); ?>" class="button viewbutton-new"><i class="far fa-eye"></i> View Now <?php if(!empty($count)){ ?><span class="badge badge-light"><?php echo $count; ?></span> <?php } ?></a>
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
<script>
document.getElementById("dropout-li").classList.add("active");
</script>