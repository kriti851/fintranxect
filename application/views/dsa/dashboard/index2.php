<style>
.data-next{  float: none; display: inline-flex;  padding-right: 10px;  margin-left: 10px;  border-left: 1px solid #fff;  /* margin-right: 6px; */ padding-left: 10px;
}
@media (min-width: 768px) and (max-width: 991px) {
.user-statistic-block .user-statistic h3 {
    font-size: 17px;
}
.container, .container-md, .container-sm {
    max-width: 100%;
}
.user-statistic-block .user-statistic span {
    font-size: 15px;
}
}


</style>

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
            <?php $this->load->view('dsa/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">Dashboard</h3>
                        </div>
                        
                        <div class="dashboard-section user-statistic-block">
                            <?php if(SubPermission(1)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant'); ?>">
                                    <div class="user-statistic">
                                        <h3>Total Cases</h3>
                                        <span><?php echo $total_cases_in_year; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(2)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=incomplete'); ?>">
                                    <div class="user-statistic">
                                        <h3>Incomplete Cases</h3>
                                        <span><?php echo $incomplete_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(3)){ ?>
                            <div  class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=short_close'); ?>">
                                    <div class="user-statistic">
                                        <h3>Short Close Cases</h3>
                                        <span ><?php echo $shortclose_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(4)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=received'); ?>">
                                    <div class="user-statistic">
                                        <h3>Received Cases</h3>
                                        <span><?php echo $received_total; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(5)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=assigned'); ?>">
                                    <div class="user-statistic">
                                        <h3>Assigned Cases</h3>
                                        <span ><?php echo $assigned_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(6)){ ?>
                            <div  class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=logged'); ?>">
                                    <div class="user-statistic">
                                        <h3>Logged Cases</h3>
                                        <span> <?php echo $logged_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(7)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=pending'); ?>">
                                    <div class="user-statistic">
                                        <h3>Pending Cases</h3>
                                        <span> <?php echo $pending_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(8)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=approved'); ?>">
                                    <div class="user-statistic">
                                        <h3>Approved Cases</h3>
                                        <span ><?php echo $approved_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(9)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=rejected'); ?>">
                                    <div class="user-statistic">
                                        <h3>Rejected Cases</h3>
                                        <span><?php echo $reject_current; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(10)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=disbursed'); ?>">
                                    <div  class="user-statistic">
                                        <h3>Disbursed Cases</h3>
                                        <span ><?php echo $total_disbursed_; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                            <?php if(SubPermission(11)){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="<?php echo dsa_url('merchant?type=disbursed'); ?>">
                                    <div class="user-statistic">
                                        <h3>Disbursed Amount</h3>
                                        <span> <?php if(!empty($total_businessvolume_->disbursed_amount)){ echo "&#8377 ". $total_businessvolume_->disbursed_amount; }else{ echo '&#8377 0'; } ?> </span>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

