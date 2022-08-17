<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>User Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">User Reports Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#">
                        <input type="text" onchange="this.form.submit()" value="<?php echo $this->input->get('keyword'); ?>" name= "keyword" placeholder="Enter Keywords" />
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
                            <h3 class="text-left">User List
                                <?php if(SubPermission(54)){ ?>
                                    <div class="buttons float-right">
                                        <a href="javascript::void(0)"  data-toggle="modal" data-target="#edit-popup" class="button viewbutton"><i class="fa fa-plus"></i> Add User</a>  
                                    </div>
                                <?php } ?>
                            </h3>
                            <?php if(!empty($results)){ foreach($results as $result){  ?>
                            <div class="job-list">
                                <div class="body">
                                    <div class="content">
                                        <!-- <small>Lender ID: <?php //echo $result->file_id; ?></small> -->
                                        <h4><a style="color:#007bff"><?php echo $result->full_name; ?></a></h4>
                                        <div class="info">
                                            <span class="company">
                                                <a><b>Mob:</b> +91 <?php echo $result->mobile_number; ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Email:</b><?php echo $result->email; ?></a>
                                            </span>
                                            <span class="company">
                                                <a><b>Address:</b><?php echo $result->address; ?></a>
                                            </span>
                                        </div>
                                    </div>
                                    <?php if(SubPermission(55)){ ?>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button viewbutton" onclick="GetUserDetail(`<?php echo $result->user_id; ?>`)"><i class="far fa-eye"></i> View Profile</a>
                                            </div>
                                        </div>
                                    <?php } ?>
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
<div class="modal fade" id="edit-popup" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
            <div class="form-row">
				<div class="col-12 col-sm-12">
				<label>Contact person name</label>
                <small class="text-danger invalid"></small>
				<input class="multisteps-form__input form-control" type="text" id="add_full_name" placeholder="Name of Contact Person" value="" />
			  </div>
		    </div>	
		 
            <div class="form-row mt-4">
				
				<div class="col-12 col-sm-6">
					<label>Mobile number</label>
                    <small class="text-danger invalid"></small>
				     <input class="multisteps-form__input form-control" maxlength="10" id="add_mobile_number" type="text" placeholder="Mobile number" value=""/>
			    </div>
                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                    <label>Email</label>
                    <small class="text-danger invalid"></small>
                    <input class="multisteps-form__input form-control"  id="add_email" type="text" placeholder="Email" value=""/>
                </div>
		    </div>
		
		<div class="form-row mt-4">
            <div class="col-12 col-sm-6">
                <label>Address</label>
                <small class="text-danger invalid"></small>
                <input class="multisteps-form__input form-control" id="add_address" type="text" placeholder="Address" value=""/>
            </div>
			<div class="col-12 col-sm-6 mt-4 mt-sm-0">
				<label>Pan no</label>
                <small class="text-danger invalid"></small>
				 <input class="multisteps-form__input form-control" type="text" id="add_pan_number" placeholder="Pan no"  value="" />
			</div>
        </div>
        <div class="form-row mt-4">
            <div class="col-12 col-sm-6">
                <label>Permission</label>
                <small class="text-danger invalid"></small>
                <select class="multisteps-form__input form-control" id="add_permission">
                    <option value="">Super Admin</option>
                    <?php foreach($permission as $per){ ?>
                        <option value="<?php echo $per->profile_id ?>"><?php echo $per->title; ?></option>
                    <?php } ?>        
                </select>
            </div>
			<div class="col-12 col-sm-6 mt-4 mt-sm-0">
				<label>Password</label>
                <small class="text-danger invalid"></small>
				 <input class="multisteps-form__input form-control" type="password" id="add_password" placeholder="Password"/>
			</div>
        </div>
        <div class="form-row mt-4">
            <div class="col-md-12">
                <label>Partner List</label>
                <small class="text-danger" id="partner_error"></small>
                <div class="chiller_cb">
                    <input class="checkbox_lender" id="select-all"  type="checkbox">
                    <label for="select-all"><span>All</span></label>
                </div>
            </div>
            <?php foreach($dsalist as $dsa){ ?>
                <div class="col-md-6">
                    <div class="chiller_cb">
                        <input class="checkbox_lender" id="select-<?php echo $dsa->user_id; ?>" name="multi_dsa_id[]" value="<?php echo $dsa->user_id; ?>" type="checkbox">
                        <label for="select-<?php echo $dsa->user_id; ?>"><span> <?php echo $dsa->company_name ?></span></label>
                    </div>
                </div>
            <?php } ?>
		</div>
       </div>
	  
      <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" onclick="AddUser()" class="btn btn-primary">SAVE CHANGES <span id="add_loader"></span></button>
      </div>
    </div>
  </div>
</div> 