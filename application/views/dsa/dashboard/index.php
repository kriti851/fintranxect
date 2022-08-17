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
                            <div onclick="Redirect(`<?php echo dsa_url('merchant'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Total Cases</h3>
                                        <span class="data-spanneweft"> MTD <BR> <?php echo $total_cases_in_month; ?> </span>
                                        <span class="data-spannewright"> YTD <BR> <?php echo $total_cases_in_year; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=incomplete'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Incomplete Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $incomplete_cases_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $incomplete_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($incomplete_cases_in_month-$incomplete_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=short_close'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Short Close Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $short_close_cases_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $shortclose_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($short_close_cases_in_month-$shortclose_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=received'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Received Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $received_case_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $received_total; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($received_case_in_month-$received_total); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=assigned'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Assigned Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $assigned_case_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $assigned_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($assigned_case_in_month-$assigned_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=logged'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Logged Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $logged_cases_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $logged_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($logged_cases_in_month-$logged_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=pending'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Pending Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $pending_case_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $pending_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($pending_case_in_month-$pending_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=approved'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Approved Cases</h3>
                                        <span class="data-spanneweft"> TOTAL <BR> <?php echo $approved_case_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $approved_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($approved_case_in_month-$approved_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=rejected'); ?>`)" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Rejected Cases</h3>
                                        <span class="data-spanneweft"> MTD <BR> <?php echo $reject_case_in_month; ?> </span>
                                        <span class="data-spannewright"> CURRENT <BR> <?php echo $reject_current; ?> </span>
                                        <span class="data-next"> MOVED <BR> <?php echo ($reject_case_in_month-$reject_current); ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <a href="javascript::void(0)">
                                    <div onclick="Redirect(`<?php echo dsa_url('merchant?type=disbursed'); ?>`)" class="user-statistic">
                                        <h3>Disbursed Cases</h3>
                                        <span class="data-spanneweft"> MTD <BR> <?php echo $disbursed_case_month; ?> </span>
                                        <span class="data-spannewright"> YTD <BR> <?php echo $disbursed_case_year; ?> </span>
                                        <span class="data-next"> TOTAL <BR> <?php echo $total_disbursed_; ?> </span>
                                    </div>
                                </a>
                            </div>
                            <div onclick="Redirect(`<?php echo dsa_url('merchant?type=disbursed'); ?>`)" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <a href="javascript::void(0)">
                                    <div class="user-statistic">
                                        <h3>Disbursed Amount</h3>
                                        <span class="data-spanneweft"> MTD <BR> <?php if(!empty($businessvolume_in_month->disbursed_amount)){ echo $businessvolume_in_month->disbursed_amount; }else{ echo '0'; } ?> </span>
                                        <span class="data-spannewright"> YTD <BR> <?php if(!empty($businessvolume_in_year->disbursed_amount)){ echo $businessvolume_in_year->disbursed_amount; }else{ echo '0'; } ?> </span>
                                        <span class="data-next"> TOTAL <BR> <?php if(!empty($total_businessvolume_->disbursed_amount)){ echo $total_businessvolume_->disbursed_amount; }else{ echo '0'; } ?> </span>
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
<script>
    function Redirect(url){
        window.location=url;
    }
</script>
