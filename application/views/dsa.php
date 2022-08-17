<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>My loan | Home</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
	<link  href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/owl.carousel.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/owl.theme.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/navbar.css'); ?>" rel="stylesheet">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
       var SiteUrl='<?php echo site_url('dsa/'); ?>'; 
       var BaseUrl='<?php echo base_url(); ?>'; 
    </script>
    <style>
    .navbar {
        padding: 0px;
        box-shadow: 0px 1px 9px #c3c3c3;
    }
    </style>
</head>

<body>
    <?php  
        $controller =$this->router->fetch_class();
        $method=$this->router->fetch_method();
    ?>
    <div class="sticky-top">
        <?php $this->load->view('layout/header'); ?>
        <?php $this->load->view('dsa/'.$content);  ?>
        <?php $this->load->view('layout/footer');  ?>
        <?php $this->load->view('layout/tinyfooter');  ?>
    </div>
    <div class="modal fade" id="OpenOtpModel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Loan Applicant Url</h4>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-sm-12">
                        <div class="col-sm-12 text-left">    
                            <a href="#" id="copy_link" class="copylink"><?php echo base_url().$this->session->userdata('user_name').'/loan'; ?></a>
                        </div>    
                                
                    </div>
                </div>

                <div class="modal-footer">
                <button class="btn btn-secondary btb-m" data-toggle="tooltip" data-placement="top" id="btn_copy" title="Copy to clipboard" onclick="CopyText()" type="button">COPY URL</button>
                    <button type="button" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="YourRmModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Your RM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="rm-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <div id="button_rm">
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <script>
    function CopyText() {
        var copyText = document.getElementById("copy_link");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        document.getElementById('btn_copy').setAttribute('data-tooltip', 'Copied');
        document.getElementById('btn_copy').innerHTML="Copied";
        $('#OpenOtpModel').modal('hide');
    }
    function show_link(){
        $('#OpenOtpModel').modal('show');
    }

    </script>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/notify.js'); ?>"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?php if($controller=='merchant' && ($method=="add" || $method=='edit')){  ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <?php } ?>
    <?php if(!empty($script)){ 
        $this->load->view('dsa/'.$script);
    } ?>
    <?php if(!empty($this->session->flashdata('message') && !empty($this->session->flashdata('message_type')))){  ?>
    <script>
        $.notify('<?php echo $this->session->flashdata('message'); ?>','<?php echo $this->session->flashdata('message_type'); ?>');
    </script>
    <?php } ?>
    <script>
        function GetYourRm(){
            $('#YourRmModal').modal('show');
            $('#rm-body').html('<div class="text-center"><div class="spinner-border text-primary" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div></div>');
                $.ajax({
            url: SiteUrl+"dashboard/GetYourRm",
            method:'POST',
            dataType:"json",
            success: function(result){
                if(result.status=='success'){
                    if(result.data.sales!="" || result.data.operation!=""){
                        var html='';
                        if(result.data.sales!=""){
                            html+='<div class="information">'+
                                '<h4>Sales RM</h4>'+
                            '<ul>'+
                                    '<li><span>Person Name:</span> '+result.data.sales.full_name+'</li>'+
                                    '<li><span>Mobile no:</span> +91 '+result.data.sales.mobile_number+'</li>'+
                                    '<li><span>Email:</span> '+result.data.sales.email+'</li>'+
                                '</ul>'+
                            '</div>';
                        }
                        if(result.data.operation!=""){
                            html+='<div class="information">'+
                                '<h4>Operation RM</h4>'+
                            '<ul>'+
                                    '<li><span>Person Name:</span> '+result.data.operation.full_name+'</li>'+
                                    '<li><span>Mobile no:</span> +91 '+result.data.operation.mobile_number+'</li>'+
                                    '<li><span>Email:</span> '+result.data.operation.email+'</li>'+
                                '</ul>'+
                            '</div>';
                        }
                        $('#rm-body').html(html);
                    }else{
                        $('#rm-body').html('<div class="text-center">No RM assigned yet</div>');
                    }
                }else{
                    $('#rm-body').html('<div class="text-center">No RM assigned yet</div>');
                }
            }
        });
        }
    </script>
    <script>
        $('input[name="date_range"]').daterangepicker({
            <?php if(empty($this->input->get('date_range'))){ ?>
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
            <?php }    ?>
        });
        $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        function RedirectPage(url){
            if($.active==0){
                window.location.href=url;
            }else{
                window.open(url,'_blank');
            }
        }
    </script>
</body>
</html>