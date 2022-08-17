<!DOCTYPE html>
<html lang="en" manifest=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>My loan | Home</title>
    <link href="https://adminlte.io/themes/dev/AdminLTE/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
	<link  href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
   
    <link href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/owl.carousel.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/owl.theme.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/navbar.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/cropper.min.css'); ?>" rel="stylesheet">
    <script>
       var SiteUrl='<?php echo site_url('super-admin/'); ?>'; 
       var BaseUrl='<?php echo s3_url(); ?>';
       var WebUrl='<?php echo site_url(); ?>';
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
        <?php $this->load->view('super-admin/'.$content);  ?>
        <?php $this->load->view('layout/footer');  ?>
        <?php $this->load->view('layout/tinyfooter');  ?>
    </div>
    <div class="modal fade" id="admin-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="basicModal" aria-hidden="true">
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/notify.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/cropper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/admin-main-script.js'); ?>"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?php if($controller=='merchant' && ($method=="edit")){  ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <?php } ?>
    <?php if(!empty($script)){ 
        $this->load->view('super-admin/'.$script);
    } ?>
    <?php if(!empty($this->session->flashdata('message') && !empty($this->session->flashdata('message_type')))){  ?>
    <script>
        $.notify('<?php echo $this->session->flashdata('message'); ?>','<?php echo $this->session->flashdata('message_type'); ?>');
    </script>
    <?php } ?>
    <script>
        $('input[name="date_range"]').daterangepicker({
            <?php if(empty($this->input->get('date_range'))){ ?>
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
            <?php }    ?>
        });
        $('input[name="date"]').daterangepicker({
            autoUpdateInput: true,
            autoApply:true,
            singleDatePicker: true
        });
        $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        
    </script>
    <script>
        if (Notification.permission === "granted") {
            showNotification();
            setInterval(function(){  showNotification(); }, 60*1000); 
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if(permission==="granted"){ 
                    showNotification();
                    setInterval(function(){  showNotification(); }, 60*3000); 
                }
            });
        }
        function showNotification() {
            $.ajax({
                url:SiteUrl+'followup/show_notification',
                method:'GET',
                dataType:'json',
                success:function(response){
                    if(response.status=='success'){
                        random=String(Math.floor(Math.random() * Math.floor()));
                        const notification = new Notification("Folloup "+response.data.full_name, {
                            tag:response.data.file_id+random,
                            body: response.data.file_id+" : "+response.data.full_name+"\n"+response.data.comments,
                            icon: BaseUrl+"assets/img/home-newimg/new-logo-header.png",
                            requireInteraction: true,
                            vibrate: [200, 100, 200]
                        });
                        notification.onclick = (e) => {
                            window.location.href = SiteUrl+'merchant/detail/'+response.data.merchant_id;
                        };
                    }
                }
            });
        }
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