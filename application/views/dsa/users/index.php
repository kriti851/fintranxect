<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Users</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Users</a></li>
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
                        <div class="col-sm-12 mt-4 text-left">
                            <h3 class="text-left">Users
                                <div class="float-right">
                                    <h5>
                                        <a href="<?php echo dsa_url('permission'); ?>" class="button viewbutton"><i class="fa fa-list"></i> Permission</a>
                                        <a href="javascript:void(0)" onclick="AddUser()" class="button viewbutton"><i class="fa fa-plus"></i> Add Users</a>
                                    </h5>
                                </div>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){
                                
                            ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <small><?php echo $result->file_id; ?>: </small>
                                        <span class="company">
                                            <a href="javascript:void(0)"><b><?php echo $result->full_name; ?></b></a>
                                        </span>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Email :</b><?php echo $result->email;?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Mobile Number :</b><?php echo "+91 ".$result->mobile_number;?></a>
                                            </span><br>
                                            <span class="company">
                                                <a><b>Address :</b><?php echo $result->address;?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Created At :</b><?php echo date('d M Y H:i A',strtotime($result->created_at));?></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="more">
                                        <div class="buttons">
                                            <a href="javascript:void(0)" onclick="UpdateUser(<?php echo $result->user_id; ?>)" class="button viewbutton" ><i class="far fa-edit"></i>Edit</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="usermodal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        
    </div>
</div>