<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h2>Upload Cases Exce</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Upload Cases Excel</a></li>
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="text-left">Upload Excel For Update Cases
                                    <div class="float-right">
                                        <h5>
                                            <a download class="button viewbutton" href="<?php echo base_url('uploads/excel/demo/Fintranxect-Business-Type.xlsx'); ?>">Business Type Template</a>
                                            <a download class="button viewbutton" href="<?php echo base_url('uploads/excel/demo/Fintranxect-Salaried-Type.xlsx'); ?>">Salaried Type Template</a>
                                        </h5>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-md-12 mt-2 text-left">
                                <div class="form-group">
                                    <label class="">Loan Type</label>
                                    <select class="form-control" name="occupationtype">
                                        <option value="Business">Business</option>
                                        <option value="Salaried">Salaried</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2 text-left">
                                <small class="text-danger" id="file_error"><?php if(!empty($message_error)){ echo $message_error; } ?></small>
                                <div class="fileUpload blue-btn btn width100">
                                    <span>Upload Excel</span><input type="file" onchange="ShowImage(this)" name="csvexcel"  id="selectlogo" class="uploadlogo" />
                                </div>
                                <div id="showfile"></div>
                            </div>
                            <div class="col-md-12 mt-2 text-left">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
