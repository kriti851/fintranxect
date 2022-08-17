<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>

<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Contact Us Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Contact Us</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#" class="form-inline">
                        <input type="text" autocomplete="off"  value="<?php echo $this->input->get('date_range'); ?>" name= "date_range" placeholder="Date Range" />
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
                            <h3 class="text-left">Contact Us
                                <div class="float-right">
                                    <div class="buttons">
                                        <h5>
                                            
                                        </h5>
                                    </div>
                                </div>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){  ?>
                            <div class="job-list">
                                
                                <div class="body">
                                    <div class="info" onclick="RedirectU(`<?php echo admin_url('merchant/detail/'.$result->merchant_id); ?>`)">
                                        <span class="company">
                                            <a href="#"><b></b> <?php echo $result->log_text; ?></a>
                                        </span>
                                        <br>
										<span class="company">
                                            <a><b>Case ID: </b> <?php echo $result->file_id; ?></a>
                                        </span>
                                        <span class="company">
                                            <a><b>Type: </b> <?php echo $result->log_type; ?></a>
                                        </span>
                                        <span class="company">
                                            <a><b>Name: </b> <?php echo $result->full_name; ?></a>
                                        </span>
                                        <span class="company">
                                            <a><b>Change By: </b> <?php echo $result->change_by.'|'.$result->change_by_user_type; ?></a>
                                        </span>
                                        <span class="company">
                                            <a><b>Time: </b> <?php echo date('d M Y h:i:A',strtotime($result->created_at)); ?></a>
                                        </span>
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
    document.getElementById('caselog-li').classList.add("active");
    function RedirectU(url){
        window.location=url;
    }
</script>
