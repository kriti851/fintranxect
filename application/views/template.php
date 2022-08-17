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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
      .header-topbar {
		padding-top: 0px;
		padding-bottom: 0px;
		background-color: #15549a;
		font-size: 12px;
		color: #83bcfa;
		font-weight: 500;
		text-transform: uppercase;
	}
    </style>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MRHF8XQL6T"></script>
    <script>
       var SiteUrl='<?php echo site_url(); ?>'; 
        window.dataLayer = window.dataLayer || [];
        function gtag(){
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-MRHF8XQL6T');
    </script>
    <?php  
        $controller =$this->router->fetch_class();
        $method=$this->router->fetch_method();
    ?>
    <?php if($controller=="welcome" && $method=="index"){}else{ ?>
        <style>
        .navbar {
            padding: 0px;
            box-shadow: 0px 1px 9px #c3c3c3;
        }
        </style>
    <?php } ?>
</head>

<body>
    <?php  
        $controller =$this->router->fetch_class();
        $method=$this->router->fetch_method();
    ?>
    <div class="sticky-top">
        <?php $this->load->view('layout/header'); ?>
        <?php $this->load->view($content);  ?>
        <?php $this->load->view('layout/footer');  ?>
        <?php $this->load->view('layout/tinyfooter');  ?>
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/partner-with-us.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/notify.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <?php if($controller=='welcome' && $method=="loan"){ if(!empty($is_script) && $is_script=='No'){}else{ ?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script src="<?php echo base_url('assets/js/step-script.js?v='.time()); ?>"></script>
     <?php }} ?>
     <?php if($controller=='welcome' && $method=="registration"){ ?>
        <script src="<?php echo base_url('assets/js/registration.js?v='.time()); ?>"></script>
     <?php } ?>
      <?php if($controller=='welcome' && $method=="login"){ ?>
        <script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
     <?php } ?>
     <?php if(!empty($scripts)){ 
        $this->load->view($scripts);
    } ?>
     <?php if(!empty($this->session->flashdata('message') && !empty($this->session->flashdata('message_type')))){  ?>
    <script>
        $.notify('<?php echo $this->session->flashdata('message'); ?>','<?php echo $this->session->flashdata('message_type'); ?>');
    </script>
    <?php } ?>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
     
</body>
</html>