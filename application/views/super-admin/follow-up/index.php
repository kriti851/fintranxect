<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}

.breadcrumb-form form {
    max-width: 800px;
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

.switchToggle input[type=checkbox]{height: 0; width: 0; visibility: hidden; position: absolute; }
.switchToggle label {cursor: pointer; text-indent: -9999px; width: 70px; max-width: 70px; height: 22px; background: #d1d1d1; display: block; border-radius: 100px; position: relative; }
.switchToggle label:after {content: ''; position: absolute; top: 2px; left: 2px; width: 26px; height: 0px; background: #fff; border-radius: 90px; transition: 0.3s; }
.switchToggle input:checked + label, .switchToggle input:checked + input + label  {background: #3e98d3; }
.switchToggle input + label:before, .switchToggle input + input + label:before {content: 'No'; position: absolute; top: 0px; left: 35px; width: 26px; height: 18px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {content: 'Yes'; position: absolute; top: 0px; left: 10px; width: 26px; height: 18px; border-radius: 90px; transition: 0.3s; text-indent: 0; color: #fff; }
.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {left: calc(100% - 2px); transform: translateX(-100%); }
.switchToggle label:active:after {width: 60px; } 
.toggle-switchArea { margin: 10px 0 10px 0; }

</style>

<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Follow Up Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Follow Up</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#" class="form-inline">
                       <div class="row">
                            <div class="col-md-4">
                                <select name="partner" class="formselect">
                                    <option value="">All</option>
                                    <?php foreach($partners as $partner){ ?>
                                    <option value="<?php echo $partner->user_id; ?>" <?php if($this->input->get('partner')==$partner->user_id){ echo "selected"; } ?>><?php echo $partner->company_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="formselect">
                                    <option value="">All</option>
                                    <option value="Pending" <?php if($this->input->get('status')=='Pending'){ echo "selected"; } ?>>Pending</option>
                                    <option value="Resolved" <?php if($this->input->get('status')=='Resolved'){ echo "selected"; } ?>>Resolved</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" autocomplete="off"  value="<?php if($this->input->get('date_range')){ echo $this->input->get('date_range'); }else{ echo date('m/d/Y').' - '.date('m/d/Y'); } ?>" name= "date_range" placeholder="Date Range" />
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">Follow Up (<?php echo $total_rows; ?>)
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
                                    <div class="info" style="width:100%">
                                        <span class="company">
                                            <?php if(SubPermission(40)){ ?>
                                            <a href="<?php echo admin_url('merchant/detail/'.$result->merchant_id); ?>"><b></b> <?php echo $result->comments; ?></a>
                                            <?php }else{ ?>
                                                <a ><b></b> <?php echo $result->comments; ?></a>
                                            <?php } ?>
                                        </span>
                                        <br>
										<span class="company">
                                            <a><b>Case ID: </b> <?php echo $result->file_id; ?></a>
                                        </span>
                                        <span class="company">
                                            <a><b>Name: </b> <?php echo $result->full_name; ?></a>
                                        </span>
                                        <span class="company">
                                            <a><b>Is Resolved: </b><span id="update-resolved-<?php echo $result->remark_id; ?>"> <?php if($result->resolved=='NO' || $result->resolved==''){ echo 'PENDING'; }else{ echo 'RESOLVED'; } ?></a></span>
                                        </span>
                                        <?php if(SubPermission(40)){ ?>
                                        <span class="switchToggle float-right pb-4">
                                            <input type="checkbox" id="isresolved<?php echo $result->remark_id; ?>" onclick="isresolved(`<?php echo $result->remark_id; ?>`)"; value="" <?php if($result->resolved=='NO' || $result->resolved==null){ echo '' ; }else{ echo 'checked'; } ?>>
                                            <label for="isresolved<?php echo $result->remark_id; ?>"></label>
                                        </span>
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
<script>
    document.getElementById('followup-li').classList.add("active");
    function RedirectU(url){
        window.location=url;
    }
</script>
