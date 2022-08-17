<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>
<style>
.breadcrumb-form form {
    max-width: 550px;
    position: relative;
    margin-left: 0px;
    float: right;
    display: block;
    width: 100%;
}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Partner Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Partner Reports Detail</a></li>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" autocomplete="off"  value="<?php echo $this->input->get('date_range'); ?>" name= "date_range" placeholder="Date Range" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text"  value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
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
                     <div class="row d-block">
					 <div class="col-sm-12">
                        </div>
                       <div class="dashboard-section user-statistic-block">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="user-statistic">
                                    <h3><?php echo $mtd_partner; ?></h3>
                                    <span>MTD Partners</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="user-statistic">
                                    <h3><?php echo $ytd_partner; ?></h3>
                                    <span>YTD Partners</span>
                                </div>
                            </div>
                        </div>
					 </div>   
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if(!empty($results)){ foreach($results as $result){  ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small> <?php echo $result->file_id; ?>:  </small>
										<span class="company">
                                            <a style="color:#007bff"><b></b> <?php echo $result->company_name; ?></a>
                                        </span>
                                    </div>
                                    <div class="more">
                                        <div class="buttons">
                                            <?php if(SubPermission(12)){ ?>
                                                <a href="#" onclick="GetUserDetail(`<?php echo $result->user_id; ?>`)" class="button viewbutton" ><i class="far fa-eye"></i> View Profile</a>
                                            <?php } ?>
                                            <?php if(SubPermission(13)){ ?>
                                                <a href="#" onclick="AssignRmModal(`<?php echo $result->user_id; ?>`)" class="button viewbutton" ><i class="fa fa-user-plus"></i> RM</a>
                                            <?php } ?>
                                        </div>
                                        <?php if(SubPermission(14)){ ?>
                                        <div class="buttons mr-2">
                                            <a href="<?php echo base_url('super-admin/dsa/associate_merchants/'.$result->user_id); ?>" class="button viewbutton" ><i class="fa fa-user-plus"></i> View Cases</a>
                                        </div>
                                        <?php } ?>
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

            <div class="modal-body" id="dsa_user_detail">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <div id="button_dsa">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rmassign" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Assign RM</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="rm-body">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <div id="button_rm">
                    
                </div>
            </div>
        </div>
    </div>
</div>
