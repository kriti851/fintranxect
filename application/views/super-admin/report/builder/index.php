<style>
.breadcrumb-form form {
    max-width: 934px;
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
.job-list .body {
    padding-left: 30px;
    width: calc(100% - 30px);
}
.viewbutton-new {
    background: #1787ff;
    color: #fff !important;
    padding: 5px 10px;
    display: inline-block;
    border-radius: 5px;
    width: 130px;
    text-align: center;
    position: relative;
    top: 15px;
}
</style>

<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Case Report Detail</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Cases Reports Detail</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">
                    <form action="#" class="form-inline">
                                            
                    </form>
                </div>
            </div>
            
            <?php $this->load->view('super-admin/layout/sidebar'); ?>
           
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div class="md-input">
                                    <input type="text" class="md-form-control" required >
                                    <label>Name</label>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
