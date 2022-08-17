<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Lender List</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Lender List</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#">
                        <input type="text" name="keyword" value="<?php echo $this->input->get('keyword'); ?>" placeholder="Enter Keywords" />
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <input type="hidden" id="merchant_id" value="<?php echo $merchant_id; ?>">
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">Lender List</h3>
                            <div class="card-body landerbox">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Select</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Company name</th>
                                                <th class="text-center">Mobile</th>
                                                <th class="text-center">Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $lender_array=[];
                                                if(!empty($merchant_lender)){
                                                    $lender_array = array_column((array)$merchant_lender, 'lender_id');
                                                    ?>
                                                    <input type="hidden" id="logged_Type" value="extra-lender">
                                                    <?php
                                            
                                                }else{
                                                    echo '<input type="hidden" id="logged_Type" value="">';
                                                }
                                            ?>
                                            <?php foreach($results as $result){ ?>
                                            <tr>
                                                <td>
                                                    <div class="chiller_cb">
                                                        <input class="checkbox_lender" <?php if(!empty($lender_array) && in_array($result->user_id,$lender_array)){ echo "disabled"; }?> id="select-<?php echo $result->user_id; ?>" name="multi_user_id[]" value="<?php echo $result->user_id; ?>" type="checkbox" />
                                                        <label for="select-<?php echo $result->user_id; ?>"></label>
                                                        <span></span>
                                                    </div>
                                                </td>
                                                <td><?php echo $result->full_name; ?></td>
                                                <td><?php echo $result->company_name; ?></td>
                                                <td><?php echo $result->mobile_number; ?></td>
                                                <td><?php echo $result->email; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                            <button type="submit" id="assign_btn" disabled class="btn btn-secondary register-button mt20">Assign</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
