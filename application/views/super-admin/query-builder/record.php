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
.checkbox-tools:not(:checked) + label {
    background-color: #fff;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    color: #000;
    border: 1px solid #ccc;
}
.checkbox-tools:checked + label, .checkbox-tools:not(:checked) + label {
    position: relative;
    display: inline-block;
    padding: 10px 30px;
    width: auto;
    font-size: 13px;
    line-height: 16px;
    letter-spacing: 0px;
    margin: 0 auto;
    margin-left: 0px;
    margin-right: 5px;
    margin-bottom: 4px;
    text-align: center;
    border-radius: 100px;
    overflow: hidden;
    cursor: pointer;
    text-transform: uppercase;
    color: #fff;
    -webkit-transition: all 300ms linear;
    transition: all 300ms linear;
}
.checkbox-tools:checked + label::before, .checkbox-tools:not(:checked) + label::before {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 4px;
    z-index: -1;
}
.checkbox-tools:not(:checked) + label {
    background-color: #fff;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    color: #000;
    border: 1px solid #ccc;
}
.checkbox-tools:checked + label {
    background: hsl(211deg 100% 55%);
    background: linear-gradient(180deg, hsl(211deg 100% 55%) 0%, hsl(211deg 100% 56%) 100%);
    background: -moz-linear-gradient(180deg, hsla(0, 100%, 36%, 1) 0%, hsla(0, 100%, 50%, 1) 100%);
    background: -webkit-linear-gradient(90deg, hsl(211deg 100% 55%) 0%, hsl(211deg 100% 70%) 100%);
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    border: 1px solid hsl(211deg 100% 55%);
}
[type="radio"]:checked, [type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
    width: 0;
    height: 0;
    visibility: hidden;
}
[type="radio"]:checked + label:after, [type="radio"]:not(:checked) + label:after {
    background: transparent;
}
.dashboard-box-right {
    margin-top: 20px;
}
.dashaboard-leftbar {
    margin-top: 20px;
}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Query Builder</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Query Builder</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">					
                </div>
            </div>
            
            <?php $this->load->view('super-admin/layout/sidebar'); ?>
           
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Query Builder
                                <div class="float-right">
                                    <div class="buttons">
                                        <h5>
                                            <a class="button viewbutton" href="<?php echo admin_url('querybuilder/downloads?'.http_build_query($this->input->get())); ?>" class="ediprofile-button"> Download</a>
                                            <a class="button viewbutton" href="<?php echo admin_url('querybuilder'); ?>" class="ediprofile-button"> Clear</a>
                                        </h5>
                                    </div>
                                </div>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){
                                $lender_id="";
                                if(!empty($result->lender_id)){
                                    $lender_id=$result->lender_id;
                                }
                                $count=$this->common_model->CountResults('comments',['merchant_id'=>$result->user_id,'admin_read'=>0]);
                                $lender=$this->query_builder_model->GetLender($result->user_id);
                            ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a href="<?php echo admin_url('merchant/edit/'.$result->user_id); ?>"><b><?php if(!empty($result->company_name) && $result->loan_type=='Business'){ echo $result->company_name; }else{ echo $result->full_name; } ?></b></a>
                                            <?php if($result->total_assigned>1){ ?>
                                                <span class="badge badge-danger">M</span>
                                            <?php } ?>
                                        </span>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Partner Id :</b><?php if(!empty($result->dsa_name)){ echo $result->dsa_id; } ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Partner :</b><?php if(!empty($result->dsa_name)){ echo $result->dsa_name; } ?></a>
                                            </span>
                                            <br>
                                            <span class="company">
                                                <a><b>Created At :</b><?php echo date('d M Y h:i A',strtotime($result->created_at)); ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Updated At :</b><?php echo date('d M Y h:i A',strtotime($result->updated_at)); ?></a>
                                            </span>
                                            <?php if(!empty($lender)){ foreach($lender as $len){ ?>
                                                <br>
                                                    <span class="company">
                                                        <a>
                                                            <b>Lender : </b>  <?php echo $len->lender_name; ?>
                                                        </a>
                                                    </span>
                                                    <span class="company">
                                                        <a><b>Status : <?php echo strtolower($len->status); ?></b>
                                                            - <?php 
                                                            if($len->status=='ASSIGNED' && $len->assigned_time!=""){
                                                                echo date('d M Y h:i A',strtotime($len->assigned_time));
                                                            }elseif($len->status=='LOGGED'  && $len->logged_time!=""){
                                                                echo date('d M Y h:i A',strtotime($len->logged_time));
                                                            }elseif($len->status=='PENDING' && $len->pending_time!=""){
                                                                echo date('d M Y h:i A',strtotime($len->pending_time));
                                                            }elseif($len->status=='APPROVED' && $len->approved_time!=""){
                                                                echo date('d M Y h:i A',strtotime($len->approved_time));
                                                            }elseif($len->status=='REJECTED' && $len->reject_time!=""){
                                                                echo date('d M Y h:i A',strtotime($len->reject_time));
                                                            }elseif($len->status=='DISBURSED' && $len->disbursed_time!=""){
                                                                echo date('d M Y h:i A',strtotime($len->disbursed_time));
                                                            }
                                                        ?>
                                                        </a>
                                                    </span>
                                            <?php }}else{ ?>
                                            <br>
                                                <span class="company">
                                                    <a><b>Status :</b>
                                                        <?php $status=""; if(!empty($result->lender_status)){ echo $status = strtolower($result->lender_status); }elseif($result->status=="INCOMPLETE"){ echo $status='incomplete'; }else{ echo $status='received'; } ?>
                                                        : <?php 
                                                        if($status=='incomplete'){
                                                            echo date('d M Y h:i A',strtotime($result->created_at));
                                                        }elseif($status=='shortclose' && $result->short_close_time!=""){
                                                            echo date('d M Y h:i A',strtotime($result->short_close_time));
                                                        }elseif($status=='received' && $result->received_time!=""){
                                                            echo date('d M Y h:i A',strtotime($result->received_time));
                                                        }elseif($status=='assigned' && $result->assigned_time!=""){
                                                            echo date('d M Y h:i A',strtotime($result->assigned_time));
                                                        }elseif($status=='rejected' && $result->reject_time!=""){
                                                            echo date('d M Y h:i A',strtotime($result->reject_time));
                                                        }
                                                    ?>
                                                    </a>
                                                </span>
                                            <?php } ?>
                                            <?php if($result->comment_time){ ?>
                                            <br>
                                            <span class="company">
                                                <a><b>Comment At :</b><?php echo date('d M Y h:i A',strtotime($result->comment_time)); ?></a>
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
    document.getElementById("builder-li").classList.add("active");
</script>