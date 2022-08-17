<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Dsa Loan</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Dsa Loan Application</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>

            <?php $this->load->view('merchant/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12 mt-4 text-left">
                                <h3 class="text-left">Personal Info</h3>

                                <form id="msform">
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active">Persoanl info</li>
                                        <li>Business info</li>
                                        <li>Co-Applicants</li>
                                        <li>Upload documents</li>
                                    </ul>
                                    <!-- fieldsets -->
                                    <fieldset>
                                        <h3 class="multisteps-form__title">Persoanl info</h3>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <small class="text-danger" id="first_name_error"></small>
                                                <input class="multisteps-form__input form-control" id="first_name" value="<?php echo explode(' ',$result->full_name)[0]; ?>" type="text" placeholder="First Name" />
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <small class="text-danger" id="last_name_error"></small>
                                                <input class="multisteps-form__input form-control" id="last_name" value="<?php $ecp =explode(' ',$result->full_name); echo end($ecp); ?>" type="text" placeholder="Last Name" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-12">
                                                <small class="text-danger" id="email_error"></small>
                                                <input class="multisteps-form__input form-control" id="email" type="email" value="<?php echo $result->email; ?>" placeholder="Email" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <small class="text-danger" id="phone_error"></small>
                                                <input class="multisteps-form__input form-control" maxlength="10" disabled id="phone" value="<?php echo $result->mobile_number; ?>" maxlength="10" type="text" placeholder="Phone number" />
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <small class="text-danger" id="age_error"></small>
                                                <input class="multisteps-form__input form-control" value="<?php echo $result->age; ?>" id="age" type="number" placeholder="Age" />
                                            </div>
                                        </div>


                                        <input type="button" id="next-1" name="next" class="next action-button btn btn-primary" value="Next" />
                                    </fieldset>

                                    <fieldset>
                                        <h3 class="multisteps-form__title">Business info</h3>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-12">
                                                <small class="text-danger" id="business_name_error"></small>
                                                <input class="multisteps-form__input form-control" value="<?php echo $result->company_name; ?>" id="business_name" type="text" placeholder="Business name" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col">
                                                <small class="text-danger" id="address1_error"></small>
                                                <input class="multisteps-form__input form-control" value="<?php echo $result->address1; ?>" id="address1" type="text" placeholder="Address 1" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <small class="text-danger" id="vintage_error"></small>
                                                <input class="multisteps-form__input form-control" id="vintage" value="<?php echo $result->vintage; ?>" type="text" placeholder="Vintage" />
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <small class="text-danger" id="turn_over_error"></small>
                                                <input class="multisteps-form__input form-control" type="number" value="<?php echo $result->turn_over; ?>" id="turn_over" placeholder="Turn over" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <small class="text-danger" id="gst_number_error"></small>
                                                <input class="multisteps-form__input form-control" type="text" id="gst_number" value="<?php echo $result->gst_number; ?>" placeholder="GST No./ Services Tax number" />
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <small class="text-danger" id="pan_number_error"></small>
                                                <input class="multisteps-form__input form-control" type="text" value="<?php echo $result->pan_number; ?>" id="pan_number" placeholder="Pan number" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <input class="multisteps-form__input form-control" id="reference" type="text" value="<?php echo $result->reference; ?>" placeholder="Reference" />
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-12"><h5>Select Constitution of Business</h5></div>
                                            <div class="col-12 col-sm-6">
                                                <select class="multisteps-form__select form-control" onchange="CheckDPBtn(this.value)" id="business_type">
                                                    <option value="PVT .ltd" <?php if($result->business_type=='PVT .ltd'){ echo  "selected"; } ?>>PVT .ltd</option>
                                                    <option value="Partnership" <?php if($result->business_type=='Partnership'){ echo  "selected"; } ?>>Partnership</option>
                                                    <option value="Proprietor" <?php if($result->business_type=='Proprietor'){ echo  "selected"; } ?>>Proprietor</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h3 class="multisteps-form__title">
                                            <button type="button" id="add_director_partner_btn" class="btn btn-primary btn-sm float-right" onclick="AddMoreDirectorPartner()"><i class="fa fa-plus"></i> Add</button>
                                        </h3>
                                        <div class="form-row mt-2">
                                            <div class="col-12 col-sm-12" id="change_partner_type_text">
                                                <h5>Director KYC</h5>
                                            </div>
                                        </div>
                                        <?php if(empty($result->partner)){   ?>
                                            <div class="form-row mt-4">
                                                <div class="col-12 col-sm-6">
                                                    <input class="multisteps-form__input form-control" name="other_pannumber[]" type="text" placeholder="Pan" />
                                                </div>
                                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                    <input class="multisteps-form__input form-control" name="other_phone_number[]" type="text" placeholder="Phone number" />
                                                </div>
                                            </div>
                                            <div class="form-row mt-1">
                                                <div class="col">
                                                    <input class="multisteps-form__input form-control" name="other_office_address[]" type="text" placeholder="Office Address" />
                                                </div>
                                            </div>
                                            <div class="form-row mt-2">
                                                <div class="col">
                                                    <input class="multisteps-form__input form-control" name="other_home_address[]" type="text" placeholder="Home Address" />
                                                </div>
                                            </div>
                                            <hr>
                                        <?php }  ?>

                                        <div id="add_more_html">
                                            <?php if(!empty($result->partner)){  foreach($result->partner as $partner){ ?>
                                            <div>
                                                <button type="button" onclick="DeleteRow(this)" class="btn btn-danger float-right">Delete</button>
                                                <div class="form-row mt-4">
                                                    <div class="col-12 col-sm-6">
                                                        <input class="multisteps-form__input form-control" value="<?php echo $partner->pan_number; ?>" name="other_pannumber[]" type="text" placeholder="Pan" />
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                        <input class="multisteps-form__input form-control" value="<?php echo $partner->phone_number; ?>" name="other_phone_number[]" type="text" placeholder="Phone number" /></div>
                                                </div>
                                                <div class="form-row mt-1">
                                                    <div class="col"><input class="multisteps-form__input form-control" value="<?php echo $partner->office_address; ?>" name="other_office_address[]" type="text" placeholder="Office Address" /></div>
                                                </div>
                                                <div class="form-row mt-2">
                                                    <div class="col"><input class="multisteps-form__input form-control" value="<?php echo $partner->home_address; ?>"  name="other_home_address[]" type="text" placeholder="Home Address" /></div>
                                                </div>
                                                <hr class="text-primary" />
                                            </div>
                                            <?php }}  ?>
                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                                        <input type="button" id="next-2" name="next" class="next action-button btn btn-primary" value="Next" />
                                    </fieldset>

                                    <fieldset>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-12">
                                                <h3>
                                                    Co-Applicants
                                                    <button type="button" id="add_co_applicant_btn" onclick="AddCoApplicant()" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add</button>
                                                </h3>
                                            </div>
                                        </div>
                                        <div id="add_co_applicant">
                                            <?php if(!empty($result->applicant)){  foreach($result->applicant as $applicant){ ?>
                                                <div>
                                                    <hr />
                                                    <button type="button" onclick="DeleteRow(this)" class="btn btn-danger float-right mt-2">Delete</button>
                                                    <div class="form-row mt-4">
                                                        <div class="col-12 col-sm-6">
                                                            <input class="multisteps-form__input form-control" type="text" name="co_name[]" value="<?php echo $applicant->name; ?>" placeholder="Name" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                            <input class="multisteps-form__input form-control" type="text" name="co_relationship[]" value="<?php echo $applicant->relationship; ?>" placeholder="Relationship" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-4">
                                                        <div class="col-12 col-sm-6"><input class="multisteps-form__input form-control" value="<?php echo $applicant->pan_number; ?>" name="co_pan_number[]" type="text" placeholder="Pan" /></div>
                                                    </div>
                                                </div>
                                            <?php }}else{ ?>
                                            <div class="form-row mt-4">
                                                <div class="col-12 col-sm-6">
                                                    <input class="multisteps-form__input form-control" type="text" name="co_name[]" placeholder="Name" />
                                                </div>
                                                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                    <input class="multisteps-form__input form-control" type="text" name="co_relationship[]" placeholder="Relationship" />
                                                </div>
                                            </div>
                                            <div class="form-row mt-4">
                                                <div class="col-12 col-sm-6">
                                                    <input class="multisteps-form__input form-control" name="co_pan_number[]" type="text" placeholder="Pan" />
                                                </div>
                                            </div>
                                            <?php  } ?>
                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                                        <input type="button" name="next" id="next-3" class="next action-button btn btn-primary" value="Next" />
                                    </fieldset>

                                    <fieldset>
                                        <h3 class="multisteps-form__title">Upload Documents</h3>
                                        <div class="form-row mt-4">
                                            <div class="col-12 col-sm-6">
                                                <small class="text-danger" id="pan_image_error"></small>
                                                <div class="fileUpload blue-btn btn width100">
                                                    <span>Upload Pan Card</span>
                                                    <input type="file" accept=".png, .jpeg, .pjp" id="pancard_image" class="uploadlogo" />
                                                </div>
                                                <div id="showpanimage">
                                                    <img src="<?php echo base_url('uploads/merchant/pancard/'.$result->pancard_image); ?>" >
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                                <small class="text-danger" id="adhar_image_error"></small>
                                                <div class="fileUpload blue-btn btn width100">
                                                    <span>Upload Aadhar Card</span>
                                                    <input type="file" accept=".png, .jpeg, .pjp" id="adharcard_image" class="uploadlogo" />
                                                </div>
                                                <div id="showadharimage">
                                                    <img src="<?php echo base_url('uploads/merchant/adharcard/'.$result->adharcard_image); ?>" >
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Previous" />
                                        <input  type="button" name="submit" id="next-4" class="next submit action-button btn btn-primary" value="Submit" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="OpenOtpModel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-center"><h3>Processing...</h3></div>
            </div>
            <div class="modal-body">
                <div class="progress" style="height: 40px;">
                    <div style="font-size: 30px;" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        '0%
                    </div>
                    <div id="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>
