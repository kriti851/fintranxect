<style>
.job-list .body {
    width: calc(100% - 0px);
}
</style>
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
                <h2>Case Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Case Reports Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    
                    <form action="#" class="form-inline">
                        <?php  if(!empty($this->input->get('type'))){ ?>
                            <input type="hidden" name="type" value="<?php echo $this->input->get('type'); ?>">
                        <?php } ?>
                        <input type="hidden" name="record_type" value="<?php if($this->input->get('record_type')){ echo $this->input->get('record_type'); }else{ echo 'current'; } ?>">
                        <div class="row">
                           
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="type" title="Status" class="formselect">
                                    <?php if(SubPermission(1)){ ?>
                                    <option value="" >ALL STATUS</option>
                                    <?php } ?>
                                    <?php if(SubPermission(2)){ ?>
                                    <option value="incomplete"  <?php if($this->input->get('type')=='incomplete'){ echo "selected"; } ?>>INCOMPLETE</option>
                                    <?php } ?>
                                    <?php if(SubPermission(4)){ ?>
                                    <option value="received" <?php if($this->input->get('type')=='received'){ echo "selected"; } ?>>RECEIVED</option>
                                    <?php } ?>
                                    <?php if(SubPermission(3)){ ?>
                                    <option value="short_close" <?php if($this->input->get('type')=='short_close'){ echo "selected"; } ?>>SHORT CLOSE</option>
                                    <?php } ?>
                                    <?php if(SubPermission(5)){ ?>
                                    <option value="assigned" <?php if($this->input->get('type')=='assigned'){ echo "selected"; } ?>>ASSIGNED</option>
                                    <?php } ?>
                                    <?php if(SubPermission(6)){ ?>
                                    <option value="logged" <?php if($this->input->get('type')=='logged'){ echo "selected"; } ?>>LOGGED</option>
                                    <?php } ?>
                                    <?php if(SubPermission(7)){ ?>
                                    <option value="pending" <?php if($this->input->get('type')=='pending'){ echo "selected"; } ?>>PENDING</option>
                                    <?php } ?>
                                    <?php if(SubPermission(8)){ ?>
                                    <option value="approved" <?php if($this->input->get('type')=='approved'){ echo "selected"; } ?>>APPROVED</option>
                                    <?php } ?>
                                    <?php if(SubPermission(9)){ ?>
                                    <option value="rejected" <?php if($this->input->get('type')=='rejected'){ echo "selected"; } ?>>REJECTED</option>
                                    <?php } ?>
                                    <?php if(SubPermission(10)){ ?>
                                    <option value="disbursed" <?php if($this->input->get('type')=='disbursed'){ echo "selected"; } ?>>DISBURSED</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
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

            <?php $this->load->view('dsa/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                <?php if($this->input->get('type')=='assigned'){ ?>
                                   Assigned Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='logged'){ ?>
                                    Logged Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='approved'){ ?>
                                    Approved Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='disbursed'){ ?>
                                    Disbursed Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='rejected'){ ?>
                                    Rejected Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='pending'){ ?>
                                    Pending Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='active'){ ?>
                                    Cases Report <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='incomplete'){ ?>
                                    Incomplete Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='received'){ ?>
                                    Received Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }elseif($this->input->get('type')=='short_close'){ ?>
                                    Short Close Cases <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php }else{ ?>
                                    Cases Report <?php if(!empty($total_rows)){ echo '('.$total_rows.')'; }else{ echo '(0)'; } ?>
                                <?php  } ?>
                                <div class="float-right">
                                    <h5>
                                        <?php if(SubPermission(12)){ ?>
                                        <a href="<?php echo dsa_url('merchant/add'); ?>" class="button viewbutton"><i class="fa fa-plus"></i> Create New Case</a>
                                        <?php } ?>
                                        <?php if(SubPermission(13)){ ?>
                                        <a class="button viewbutton" href="<?php echo dsa_url('excel/add'); ?>"  class="ediprofile-button"><i class="fa fa-upload"></i> Upload Cases</a>
                                        <?php } ?>
                                        <?php if(SubPermission(14)){ ?>
                                        <a class="button viewbutton" href="javascript:void(0)"  data-toggle="modal" data-target="#ExcelExportModal" class="ediprofile-button"><i class="fa fa-download"></i> Download Cases</a>
                                        <?php } ?>
                                    </h5>
                                </div>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){
                                $count=$this->common_model->CountResults('comments',['merchant_id'=>$result->user_id,'comment_by'=>$this->session->userdata('user_id'),'comment_for'=>'PARTNER','is_read'=>0]);
                            ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a <?php if(SubPermission(15)){ ?> href="<?php echo dsa_url('merchant/edit/'.$result->user_id); ?>" <?php } ?>><b><?php if(!empty($result->company_name)){ echo $result->company_name; }else{ echo $result->full_name; } ?></b></a>
                                        </span>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Created At :</b><?php echo date('d M Y H:i A',strtotime($result->created_at));?></a>
                                            </span>
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
                                                    }elseif($status=='logged'  && $result->logged_time!=""){
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
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="more">
                                        <div class="buttons">
                                            <?php if(SubPermission(16) && SubPermission(18)){ ?>
                                            <a href="<?php echo dsa_url('merchant/detail/'.$result->user_id); ?>" class="button viewbutton" ><i class="far fa-eye"></i> View Now <?php if(!empty($count)){ ?><span class="badge badge-light"><?php echo $count; ?></span> <?php } ?></a>
                                            <?php }else{ ?>
                                                <a href="<?php echo dsa_url('merchant/detail/'.$result->user_id); ?>" class="button viewbutton" ><i class="far fa-eye"></i> View Now</a>
                                            <?php } ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <?php }}else{ ?>
                                <hr>
                                <div class="text-center">
                                    <h3>No Record Found</h3>
                                </div>
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

<div class="modal fade" id="viewdetail" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Applicants Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="user_detail">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <div id="button_user">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ExcelExportModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo dsa_url('merchant/ExportCasesByFilter'); ?>" id="filter_case_form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Excel Export Filter</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-6 col-sm-6 mt-4 mt-sm-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filter_type[]" value="Business" class="custom-control-input" id="business-checkbox">
                                <label class="custom-control-label" for="business-checkbox"></label>
                                <span class="ml-4"> Business</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 mt-4 mt-sm-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="filter_type[]" value="Salaried" class="custom-control-input" id="salaried-checkbox">
                                <label class="custom-control-label" for="salaried-checkbox"></label>
                                <span class="ml-4"> Salaried</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                            <input type="text" name="date_range" required class="multisteps-form__input form-control" title="Date Range" placeholder="Date Range">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                            <select name="status" title="Status" required class="multisteps-form__input form-control">
                                <option value="ALL">ALL STATUS</option>
                                <option value="INCOMPLETE">INCOMPLETE</option>
                                <option value="SHORTCLOSE">SHORTCLOSE</option>
                                <option value="RECEIVED">RECEIVED</option>
                                <option value="ASSIGNED">ASSIGNED</option>
                                <option value="LOGGED">LOGGED</option>
                                <option value="PENDING">PENDING</option>
                                <option value="APPROVED">PENDING</option>
                                <option value="REJECTED">REJECTED</option>
                                <option value="DISBURSED">DISBURSED</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="ApplyDownload()" class="btn btn-primary">Apply</button>
                    <button type="button" style="background:black;color:white;" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>   
        </div>
    </div>
</div>