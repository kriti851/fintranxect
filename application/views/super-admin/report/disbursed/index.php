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
                        <div class="row">
                            <div class="col-md-6">
                               
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
                                </div>
                            </div>
                            
                            <div class="col-md-2">
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
            
            <?php $this->load->view('super-admin/layout/sidebar'); ?>
           
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Disbursed Report <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <div class="float-right">
                                    <div class="buttons">
                                        <h5>
                                            <?php if(SubPermission(25)){ ?>
                                                <a class="button viewbutton" href="<?php echo admin_url('excel/download_disbursed'); ?>"><i class="fa fa-download"></i> Download Cases</a>
                                            <?php  } ?>
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
                                $lender=$this->report_model->GetLender($result->user_id);
                            
                            ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a <?php if(SubPermission(24)){ ?> href="<?php echo admin_url('merchant/edit/'.$result->user_id); ?>" <?php } ?>><b><?php if(!empty($result->company_name)){ echo $result->company_name; }else{ echo $result->full_name; } ?></b></a>
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
                                                            echo date('d M Y h:i A',strtotime($len->disbursed_time));
                                                        ?>
                                                        </a>
                                                    </span>
                                            <?php }} ?>
                                            <?php if($result->comment_time){ ?>
                                            <br>
                                            <span class="company">
                                                <a><b>Comment At :</b><?php echo date('d M Y h:i A',strtotime($result->comment_time)); ?></a>
                                            </span>
                                            <?php } ?>
                                           
                                        </div>
                                    </div>
                                    <?php  if(SubPermission(26)){ ?>
                                    <div class="more">
                                        <div class="buttons">
                                            <a href="<?php echo admin_url('merchant/detail/'.$result->user_id); ?>" class="button viewbutton-new"><i class="far fa-eye"></i> View Now <?php if(!empty($count)){ ?><span class="badge badge-light"><?php echo $count; ?></span> <?php } ?></a>
                                        </div>
                                    </div>
                                    <?php } ?>
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
 document.getElementById("reports-li").classList.add("active");
 document.getElementById("report-disbursed-li").classList.add("active");
 
</script>