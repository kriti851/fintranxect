<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Api Management</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Api Management</a></li>
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
                            <h3 class="text-left">Api Management
                                <div class="float-right">
                                    <h5>
                                        
                                    </h5>
                                </div>
                            </h3>
                            <div class="information">
                                <ul>
                                    <li><span>Secret Key:</span> <?php echo $profile->secret_key; ?> 
                                        <i data-toggle="modal" data-target="#KeyConfirmModal" class="fa fa-key"></i>
                                    </li>
                                </ul>
                            </div>
                            <div class="information">
                                <ul>
                                    <?php 
                                        $first_ip_id=0;
                                        $first_ip="";
                                        if(!empty($ip) && isset($ip[0])){ 
                                            $first_ip_id=$ip[0]->id;
                                            $first_ip=$ip[0]->ip_address;
                                        }
                                        $secondip_id=0;
                                        $second_ip="";
                                        if(!empty($ip) && isset($ip[1])){ 
                                            $secondip_id=$ip[1]->id;
                                            $second_ip=$ip[1]->ip_address;
                                        }
                                    ?>
                                    <li><span>White List Ip 1</span> <?php echo $first_ip; ?>
                                        <i onclick="ChangeIpModal(`<?= $first_ip_id ?>`,`<?= $first_ip ?>`)" class="fa fa-edit"></i>
                                    </li>
                                    <li><span>White List Ip 2</span> <?php echo $second_ip; ?>
                                        <i onclick="ChangeIpModal(`<?= $secondip_id ?>`,`<?= $first_ip ?>`)" class="fa fa-edit"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="KeyConfirmModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Secret Key</h4>
            </div>
            <div class="modal-body" >
                <p>
                    Are You Sure You want to change secret key ?
                </p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo dsa_url('api/generate_key'); ?>" class="btn btn-primary">Yes</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade" id="IpModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Whitelist Ip</h4>
            </div>
            <div class="modal-body" >
                <div class="form-group">
                    <input type="hidden" id="ip_id" value="">
                    <label>Ip Address</label>
                    <small class="text-danger" id="ip_error"></small>
                    <input type="text" id="ip_address" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="SubmitIp()" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 