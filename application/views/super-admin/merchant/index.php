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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="type" title="Status" class="formselect">
                                    <?php if(SubPermission(1)){ ?>
                                    <option value="" >ALL STATUS</option>
                                    <?php } if(!empty($disabled_incomplete)){}else{  if(SubPermission(2)){ ?>
                                        <option value="incomplete"  <?php if($this->input->get('type')=='incomplete'){ echo "selected"; } ?>>INCOMPLETE</option>
                                    <?php }} if(!empty($disabled_received)){}else{ if(SubPermission(3)){ ?>
                                        <!--<option value="received" <?php if($this->input->get('type')=='received'){ echo "selected"; } ?>>RECEIVED</option>-->
                                        <option value="received" <?php if($this->input->get('type')=='received'){ echo "selected"; } ?>>CLOSED</option>
                                        <?php } if(SubPermission(4)){ ?>
                                        <option value="short_close" <?php if($this->input->get('type')=='short_close'){ echo "selected"; } ?>>SHORT CLOSE</option>
                                        <?php } if(SubPermission(5)){ ?>
                                            <option value="assigned" <?php if($this->input->get('type')=='assigned'){ echo "selected"; } ?>>ASSIGNED</option>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if(SubPermission(6)){ ?>
                                    <option value="logged" <?php if($this->input->get('type')=='logged'){ echo "selected"; } ?>>LOGGED</option>
                                    <?php } if(SubPermission(7)){ ?>
                                    <option value="pending" <?php if($this->input->get('type')=='pending'){ echo "selected"; } ?>>PENDING</option>
                                    <?php } if(SubPermission(8)){ ?>
                                    <option value="approved" <?php if($this->input->get('type')=='approved'){ echo "selected"; } ?>>APPROVED</option>
                                    <?php } if(SubPermission(9)){ ?>
                                    <option value="rejected" <?php if($this->input->get('type')=='rejected'){ echo "selected"; } ?>>REJECTED</option>
                                    <?php } if(SubPermission(10)){ ?>
                                    <option value="disbursed" <?php if($this->input->get('type')=='disbursed'){ echo "selected"; } ?>>DISBURSED</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="formselect" title="Incomplete Status" name="title">
                                        <option value="">INCOMPLETE STATUS</option>
                                        <option value="1" <?php if($this->input->get('title')=='1'){ echo "selected"; } ?>>Open</option>
                                        <option value="2" <?php if($this->input->get('title')=='2'){ echo "selected" ;}?>>kYC Verification</option>
                                        <option value="3"<?php if($this->input->get('title')=='3'){ echo "selected" ;}?>>Credit Documents</option>
                                        <option value="4"<?php if($this->input->get('title')=='4'){echo "selected";}?>>Completed</option>
                                        <option value="7"<?php if($this->input->get('title')=="7"){ echo "selected" ;}?>>Personal Info</option>
                                        <option value="8"<?php if($this->input->get('title')=="8"){ echo "selected" ;}?>>Employment Info</optio>
                                        <option value="9"<?php if($this->input->get('title')=="9"){ echo "selected" ; }?>>Salary Detail</option>
                                        <option value="10"<?php if($this->input->get('title')=="10"){ echo "selected" ;}?>>Residence Detail</option>
                                        <option value="11"<?php if($this->input->get('title')=="11"){ echo "selected" ;}?>>Reference</option>
                                        <option value="12"<?php if($this->input->get('title')=="12"){ echo "selected" ;}?>>Business Info</option>
                                        <option value="13"<?php if($this->input->get('title')=="13"){ echo "selected" ;}?>>Co-applicants</option>
                                    </select>
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="formselect" title="Order BY" name= "order_by">
                                        <option value="">Sort</option>
                                        <option value="Status" <?php if($this->input->get('order_by')=='Status'){ echo "selected"; } ?>>Status</option>
                                        <option value="Update"  <?php if($this->input->get('order_by')=='Update' || $this->input->get('order_by')==''){ echo "selected"; } ?>>Update</option>
                                        <option value="Comment" <?php if($this->input->get('order_by')=='Comment'){ echo "selected"; } ?>>Comment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="formselect" title="Remark" name= "remark">
                                        <option value="">Remark</option>
                                        <option value="no remark" <?php if($this->input->get('remark')=='no remark'){ echo "selected"; } ?>>no remark</option>
                                        <option value="3 days"  <?php if($this->input->get('remark')=='3 days'){ echo "selected"; } ?>>3 days</option>
                                        <option value="5 days" <?php if($this->input->get('remark')=='5 days'){ echo "selected"; } ?>>5 days</option>
                                        <option value="10 days" <?php if($this->input->get('remark')=='10 days'){ echo "selected"; } ?>>10 days</option>
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
                                    <div class="buttons">
                                    <h5>
                                    <?php if(!empty($is_add)){ ?>
                                        <?php if(SubPermission(18)){ ?>
                                            <a class="button viewbutton" href="<?php echo admin_url('merchant/add'); ?>" class="ediprofile-button"><i class="fa fa-plus"></i> Add Cases</a>
                                        <?php } ?>
                                    <?php }if(!empty($is_download)){ ?>
                                            <?php if(SubPermission(20)){ ?>
                                            <a class="button viewbutton" href="javascript:void(0)"  data-toggle="modal" data-target="#ExcelExportModal" class="ediprofile-button"><i class="fa fa-download"></i> Download Cases</a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if(!empty($is_uplod)){ ?>
                                            <?php if(SubPermission(19)){ ?>
                                                <a class="button viewbutton" href="<?php echo admin_url('excel/add') ?>" class="ediprofile-button"><i class="fa fa-upload"></i> Upload Cases</a>
                                            <?php } ?>
                                            <?php if(SubPermission(21)){ ?>
                                                <a class="button viewbutton" href="<?php echo admin_url('excel/upload') ?>"  class="ediprofile-button"><i class="fa fa-upload"></i> Update Cases</a>
                                            <?php } ?>
                                        <?php } ?>
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
                                $lender=$this->merchant_model->GetLender($result->user_id);
                            ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a <?php if(SubPermission(22)){ ?> href="<?php echo admin_url('merchant/edit/'.$result->user_id); ?>" <?php } ?>><b><?php if(!empty($result->company_name) && $result->loan_type=='Business'){ echo $result->company_name; }else{ echo $result->full_name; } ?></b></a>
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
                                                        <?php $status=""; if(!empty($result->lender_status)){ echo $status = strtolower($result->lender_status); }elseif($result->status=="INCOMPLETE"){ echo $status='incomplete'; }else{ echo $status='closed'; } ?>
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
                                    <?php if(SubPermission(23)){ ?>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo admin_url('merchant/ExportCasesByFilter'); ?>" id="filter_case_form" method="post">
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
                            <input type="text" name="rangepicker" required class="multisteps-form__input form-control" title="Date Range" placeholder="Date Range">
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
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-12">
                            <small class="text-danger" id="first_name_error"></small>
                            <select class="multisteps-form__input form-control" name="dsa_id" title="Select Partner" placeholder="Select Partner">
                                <option value="">All Partner</option>
                                <?php if(!empty($dsa)){ foreach($dsa as $d){ ?>
                                <option value="<?php echo $d->user_id; ?>"><?php echo $d->company_name; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                            <select class="multisteps-form__input form-control" name="lender_id" title="Select Lender" placeholder="Select Lender">
                                <option value="">All Lender</option>
                                <?php if(!empty($lenderlist)){ foreach($lenderlist as $l){ ?>
                                <option value="<?php echo $l->user_id; ?>"><?php echo $l->company_name; ?></option>
                                <?php }} ?>
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
<script>
<?php if(!empty($case_report)){ ?>
 document.getElementById("merchant-li").classList.add("active");
<?php }elseif(!empty($lender_case)){ ?>
    document.getElementById("lender-li").classList.add("active");
<?php  }elseif(!empty($dsa_case)){ ?>
    document.getElementById("dsa-li").classList.add("active");
<?php  } ?>
</script>