<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <!--<h2>Candidates Dashboard</h2>-->
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Dashboard</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    
                </div>
            </div>
            <?php $this->load->view('lender/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">Dashboard</h3>
                        </div>
                        <div class="dashboard-section user-statistic-block">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant'); ?>">
                                    <div class="user-statistic">
                                        <h3>Total Cases</h3>
                                        <span><?php echo $total_cases_; ?></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=assigned'); ?>">
                                    <div class="user-statistic">
                                        <h3>Total Cases Assigned</h3>
                                        <span><?php echo $assigned_case_; ?> </span>
                                    </div>
                                </a>
                            </div>   
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=logged'); ?>">
                                    <div class="user-statistic">
                                        <h3>Logged Cases</h3>
                                        <span><?php echo $logged_case_; ?></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=pending'); ?>">
                                    <div class="user-statistic">
                                        <h3>Pending Cases</h3>
                                        <span><?php echo $pending_case_; ?></span>
                                    </div>
                                </a>
                            </div>
                            <div  class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=approved'); ?>">
                                    <div class="user-statistic">
                                        <h3>Approved Cases</h3>
                                        <span><?php echo $approved_case_; ?></span>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=rejected'); ?>">
                                    <div class="user-statistic">
                                        <h3>Rejected Cases</h3>
                                        <span><?php echo $reject_case_; ?></span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=disbursed'); ?>">
                                    <div  class="user-statistic">
                                        <h3>Disbursed Cases</h3>
                                        <span><?php echo $disbursed_case_; ?></span>
                                    </div>
                                </a>
                            </div>                     
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <a href="<?php echo lender_url('merchant?type=disbursed'); ?>">
                                    <div class="user-statistic">
                                        <h3>Disbursed Amount</h3>
                                        <span> &#8377; <?php if(!empty($total_disbursed_->amount)){ echo $total_disbursed_->amount; }else{ echo '0'; } ?> </span>
                                    </div>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
