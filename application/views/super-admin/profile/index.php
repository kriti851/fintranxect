<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Profile Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Profile Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    
                </div>
            </div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                
                <div class="dashboard-box-right">  
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Profile
                                <div class="float-right">
                                    <div class="buttons">
                                        <h5>
                                            <?php if(SubPermission(52)){ ?>
                                                <a class="button viewbutton" data-toggle="modal" data-target="#AddProfileModal"  href="#"><i class="fa fa-plus"></i> Add Profile</a>
                                            <?php } ?>
                                            <?php if(SubPermission(56)){ ?>
                                                <a class="button viewbutton" href="<?php echo admin_url('users'); ?>"><i class="fa fa-list"></i> Users</a>
                                            <?php } ?>
                                        </h5>
                                    </div>
                                </div>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){  ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
										<span class="company">
                                            <a style="color:#007bff"><b><?php echo $result->title; ?></b></a>
                                        </span></br>
                                    </div>
                                    <?php if(SubPermission(53)){ ?>
                                    <div class="more">
                                        <div class="buttons">
                                            <a href="#" class="button viewbutton" onclick="EditProfile(`<?php echo $result->profile_id; ?>`)"><i class="far fa-edit"></i> Edit Profile</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php }}else{ ?>
                                <h3 class="text-center">No Record Found</h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddProfileModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-12 col-sm-12">
                        <label>Title</label>
                        <small class="text-danger invalid"></small>
                        <input class="multisteps-form__input form-control" type="text" id="add_title" placeholder="Profile Title" value="" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm-12">
                        <small class="text-danger" id="add_permission_error"></small>
                        <div class="table-responsive" style="overflow:hidden;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="25">Permission</th>
                                        <th width="75">Sub Permission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($permission_list as $plist){ ?>
                                    <tr>
                                        
                                        <td>
                                            <div class="chiller_cb">
                                                <input class="checkbox_lender" id="select-permission-<?php echo $plist->id; ?>" name="main_permission[]" value="<?php echo $plist->id; ?>" <?php if($plist->is_checked){ echo "checked"; } ?> type="checkbox" />
                                                <label for="select-permission-<?php echo $plist->id; ?>"></label>
                                                <span><?php  echo $plist->title; ?></span>
                                            </div>
                                        </td>
                                        <td>
                                        <?php
                                            if(!empty($plist->sub_permission)){ ?>
                                            
                                                <div class="row">
                                                    <?php    foreach($plist->sub_permission as $splist){ ?>
                                                    <div class="col-md-3">
                                                        <div class="chiller_cb">
                                                            <input class="checkbox_lender" id="select-sub-p-<?php echo $splist->sub_id; ?>" name="sub_permission[]" value="<?php echo $splist->sub_id; ?>" <?php if($splist->is_checked){ echo "checked"; } ?>  type="checkbox" />
                                                            <label for="select-sub-p-<?php echo $splist->sub_id; ?>"></label>
                                                            <span><?php echo $splist->title; ?></span>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                           
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="AddProfile()" class="btn btn-primary">SAVE</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EditProfileModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit-profile-form">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <div id="button_edit">
                </div>
            </div>
        </div>
    </div>
</div>