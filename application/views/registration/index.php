<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 offset-md-1 col-md-10 col-sm-12 col-12">
                <div class="login-box-right">
                    <div class="st-tabs">
                        <div class="text-success" id="success_message">
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-1" data-toggle="tab" href="#service1" role="tab" aria-controls="service1" aria-selected="true">Register As Partner</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2" data-toggle="tab" href="#service2" role="tab" aria-controls="service2" aria-selected="false">Register As Lender</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="service1">
                                <form id="DsaFrom" method ="post" enctype="multipart/form-data">
                                    <h3>Register As Partner</h3>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <small id="dsa_username_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_username" title="Trade Name" type="text" placeholder="Trade Name" />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="dsa_company_name_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_company_name" type="text" title="Company name" placeholder="Company name" />
                                            
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="dsa_full_name_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_full_name" type="text" title="Name of Contact Person"  placeholder="Name of Contact Person" />
                                            
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="dsa_address_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_address" type="text" title="Address"  placeholder="Address" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="dsa_mobile_numbere_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_mobile_number" maxlength="10"  title="Mobile number" type="text" placeholder="Mobile number" />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <small id="dsa_email_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_email" title="Email" type="text" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="dsa_website_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_website" title="Website" type="text" placeholder="Website" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="dsa_gst_number_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="dsa_gst_number" title="PAN/GST Number" type="text" placeholder="PAN/GST Number" />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="dsa_password_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" maxlength="12" id="dsa_password" type="password" title="Password (Maximum 12 characters)" placeholder="Password (Maximum 12 characters)" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="dsa_cpassword_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" maxlength="12" id="dsa_cpassword" type="password" title="Confirm Password" placeholder="Confirm Password" />
                                        </div>
                                    </div>
    
                                    <h3 class="mt20">Upload any of the following doc</h3>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-12">
                                            <small id="dsa_doc_error" class="text-danger"></small>
                                            <div class="fileUpload blue-btn btn width100">
                                                <span>Upload PAN/GST Doc</span>
                                                <input type="file" name="dsa_doc" multiple accept=".jpg, .png, .jpeg, .pdf, .doc, .docx" onchange="ReadFile(this)" id="dsa_doc" class="uploadlogo" />
                                            </div>
                                        </div>
                                        <div style="width:100%" id="uploaded_image" aria-live="polite">
                                        </div>
                                    </div>
                                    <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                                        <!--<button type="submit" class="btn btn-secondary register-button mt20">Submit</button> -->
                                        <button type="button" onclick="SubmitDsaForm()" class="btn btn-secondary register-button mt20">Register <span id="dsa_loader"></span></a>
                                    </div>
                                </form>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="service2">
                                 <form id="LenderFrom" method ="post" enctype="multipart/form-data">
                                    <h3>Register As Lender</h3>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="company_name_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="company_name" type="text" title="Company Name" placeholder="Company name" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="full_name_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="full_name" type="text" title="Name of Contact Person" placeholder="Name of Contact Person" />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="address_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="address" type="text" title="Address" placeholder="Address" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="mobile_number_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="mobile_number" maxlength="10" type="text" title="Mobile number" placeholder="Mobile number" />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="email_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="email" type="text" title="Email" placeholder="Email" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="gst_number_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="gst_number" type="text" title="GST No." placeholder="GST No." />
                                        </div>
                                    </div>
                                    <div class="form-row mt-4">
                                        <div class="col-12 col-sm-6">
                                            <small id="password_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" maxlength="12" id="password" type="password" title="Password (Maximum 12 characters)" placeholder="Password (Maximum 12 characters)" />
                                        </div>
                                        <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                                            <small id="cpassword_error" class="text-danger"></small>
                                            <input class="multisteps-form__input form-control" id="confirm_password" type="password" title="Confirm Password" placeholder="Confirm Password" />
                                        </div>
                                    </div>
    
                                    <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                                        <!--<button type="submit" class="btn btn-secondary register-button mt20">Submit</button> -->
                                        <button type="button" onclick="SubmitLenderForm()" class="btn btn-secondary register-button mt20">Register <span id="lender_loader"></span></button>
                                    </div>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter Otp</h4>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12">
                    <small id="dsa_otp_errorr" class="text-danger"></small>
                    <input class="multisteps-form__input form-control" id="dsa_otp" type="text" placeholder="Enter Otp Here" />
                </div>
            </div>

            <div class="modal-footer">
                <a onclick="SubmitOtp()" class="btn btn-primary">Verify Otp <span id="dsa_loader_"></span></a>
                <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="OpenLenderOtpModel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter Otp</h4>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-12">
                    <small id="lender_otp_errorr" class="text-danger"></small>
                    <input class="multisteps-form__input form-control" id="lender_otp" type="text" placeholder="Enter Otp Here" />
                </div>
            </div>

            <div class="modal-footer">
                <a onclick="SubmitLenderOtp()" class="btn btn-primary text-warning">Verify Otp <span id="lender_loader_"></span></a>
                <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="LargeImageModel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="modal_content">
                <div class="modal-body">
                    <div class="col-12 col-sm-12">
                        <img id="to-large-image" src="#">
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>