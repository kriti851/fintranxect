<style>
.job-list .body { padding-left: 0px;width: calc(100% - 0px);}
.more {display: flex;}
.viewbutton { font-size: 13px; margin-left: 10px;}
</style>
<style>
.breadcrumb-form form {
    max-width: 330px;
    position: relative;
    margin-left: 0px;
    float: right;
    display: block;
    width: 100%;
}
label:not(.form-check-label):not(.custom-file-label) {
        font-weight:400 !important;
    }
.md-input .md-form-control {
    width: 100%;
    background-color: #fff;
    color: #555;
    height: 52px;
    border: 2px solid #e6ecef;
	    font-size: 14px;
    padding: 23px 16px 13px 20px;
}
.md-input label {
    color: #656565;
    font-size: 14px;
	top:15px;
}
.md-input .md-form-control:focus ~ label, .md-input .md-form-control:valid ~ label {
    top: 5px;
    font-size: 10px;
    color: #656565;
}
.md-input {
    position: relative;
    margin-bottom: 10px;
}
.md-form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

</style>
<div class="section-space40 bg-white">
    <div class="container top-full-width">            
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Status</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0)">Home</a></li>
                        <li><a href="javascript:void(0)">Setting</a></li>
                        <li class="active"><a href="#!">Status</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                   
                </div>
            </div>

            <?php $this->load->view('super-admin/layout/sidebar'); ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                               Status List
                                <div class="float-right">
                                    <div class="buttons">
                                        <h5>
                                            <?php if(SubPermission(41)){ ?>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#StatusEdit" class="button viewbutton" ><i class="fa fa-plus" aria-hidden="true"></i>Add New</a>
                                            <?php } ?>
                                        </h5>
                                    </div>
                                </div>
                            </h3>
                            <?php if(!empty($results)){ $newresult=array_chunk($results,2); foreach($newresult as $result){  ?>
                            <div class="row">
                                <?php foreach($result as $row){ ?>
                                <div class="col-sm-6">
                                    <div class="job-list">
                                        <div class="body">
                                            <div class="content">
                                                <span class="company">
                                                    <?php echo $row->title; ?>
                                                </span>
                                            </div>
                                            <div class="more">
                                                <div class="buttons mr-2">
                                                    <?php if(SubPermission(42)){ ?>
                                                        <a href="javascript:void(0)"  onclick="StatusEdit(`<?= $row->id; ?>`,`<?= $row->title; ?>`)" class="button viewbutton" ><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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

<div class="modal fade" id="StatusEdit" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-4">
                        <input type="hidden" id="id">
                        <div class="col-12 col-sm-12 mt-4 mt-sm-0">
                            <div class="md-input">
                                <input type="text" required class="md-form-control" id="title" title="Status">
                                <label>Status</label>
                                <small class="text-danger invalid"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="StatusSubmit()" class="btn btn-primary">Submit</button>
                    <button type="button" style="background:black;color:white;" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>   
        </div>
    </div>
</div>
<script>
    document.getElementById("setting-li").classList.add("active");
</script>