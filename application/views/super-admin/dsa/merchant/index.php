<div class="section-space40 bg-white">
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
                    <form action="#">
                        <input type="text" onchange="this.form.submit()" value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
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
                                Cases Report
                                <div class="float-right">
                                
                                </div>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){
                                $lender_id="";
                                if(!empty($result->lender_id)){
                                    $lender_id=$result->lender_id;
                                }
                                $lender=$this->merchant_model->GetAssignedLender($result->user_id,$lender_id);
                                $partner=$this->common_model->GetRow(TBL_USERS,['user_id'=>$result->created_by],'file_id');
                                $count=$this->common_model->CountResults('comments',['merchant_id'=>$result->user_id,'admin_read'=>0]);
                            ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a href="<?php echo admin_url('merchant/edit/'.$result->user_id); ?>"><b><?php echo $result->company_name; ?></b></a>
                                        </span>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Partner Id :</b><?php echo $partner->file_id; ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Status :</b><?php if(!empty($lender)  && !empty($lender->status)){ echo ucfirst($lender->status); }else{ if(!empty($result->status)){ echo ucfirst($result->status); }elseif($result->case_status!=""){ echo $result->case_status; }else{ echo "Received"; } } ?></a>
                                            </span>
                                            <?php if(!empty($lender)){ ?>
                                            <span class="company">
                                                <a><b>Lender :</b><?php echo $lender->full_name; ?></a>
                                            </span>
                        
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="more">
                                        <div class="buttons">
                                            <a href="<?php echo admin_url('merchant/detail/'.$result->user_id); ?>" class="button viewbutton"><i class="far fa-eye"></i> View Now <?php if(!empty($count)){ ?><span class="badge badge-light"><?php echo $count; ?></span> <?php } ?></a>
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
