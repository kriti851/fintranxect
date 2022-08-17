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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" autocomplete="off"  value="<?php if(!empty($this->input->get('date_range'))){ echo $this->input->get('date_range'); }else{ echo date('m/01/Y').' - '.date('m/t/Y'); } ?>" name= "date_range" placeholder="Date Range" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="type" title="Status" class="formselect">
                                    <option value="all"  <?php if($this->input->get('type')=='all'){ echo "selected"; } ?>>ALL</option>
                                    <option value="received" <?php if($this->input->get('type')=='received'){ echo "selected"; } ?>>RECEIVED</option>
                                    <option value="assigned" <?php if($this->input->get('type')=='assigned'){ echo "selected"; } ?>>ASSIGNED</option>
                                    <option value="logged" <?php if($this->input->get('type')=='logged'){ echo "selected"; } ?>>LOGGED</option>
                                    <option value="pending" <?php if($this->input->get('type')=='pending'){ echo "selected"; } ?>>PENDING</option>
                                    <option value="approved" <?php if($this->input->get('type')=='approved'){ echo "selected"; } ?>>APPROVED</option>
                                    <option value="rejected" <?php if($this->input->get('type')=='rejected'){ echo "selected"; } ?>>REJECTED</option>
                                    <option value="disbursed" <?php if($this->input->get('type')=='disbursed'){ echo "selected"; } ?>>DISBURSED</option>
                                </select>
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
                                Partner Wise Report <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <div class="float-right">
                                    <div class="buttons">
                                        <h5>
                                            <?php if(SubPermission(25)){ ?>
                                                <a class="button viewbutton" data-toggle="modal" data-target="#ExcelExportModal" href="javascript:void(0)"><i class="fa fa-download"></i> Download Cases</a>
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
<div class="modal fade" id="ExcelExportModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo admin_url('partner_wise_report'); ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Partner wise Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                            <select name="status" title="Status" required class="multisteps-form__input form-control">
                                <option value="all">ALL STATUS</option>
                                <option value="received">RECEIVED</option>
                                <option value="assigned">ASSIGNED</option>
                                <option value="logged">LOGGED</option>
                                <option value="pending">PENDING</option>
                                <option value="approved">PENDING</option>
                                <option value="rejected">REJECTED</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-md-12">
                            <label>Partner List</label>
                            <small class="text-danger" id="partner_error"></small>
                            <div class="chiller_cb">
                                <input class="checkbox_lender" id="select-all"  type="checkbox">
                                <label for="select-all"><span>All</span></label>
                            </div>
                        </div>
                        <?php foreach($dsalist as $dsa){ ?>
                            <div class="col-md-6">
                                <div class="chiller_cb">
                                    <input class="checkbox_lender" id="select-<?php echo $dsa->user_id; ?>" name="multi_id[]" value="<?php echo $dsa->user_id; ?>" type="checkbox">
                                    <label for="select-<?php echo $dsa->user_id; ?>"><span> <?php echo $dsa->company_name ?></span></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <button type="button" style="background:black;color:white;" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>   
        </div>
    </div>
</div>
<script>
 document.getElementById("reports-li").classList.add("active");
 document.getElementById("report-partnerwise-li").classList.add("active");

</script>