<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
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
    <script>
       var SiteUrl='<?php echo site_url('merchant/'); ?>'; 
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
        <?php $this->load->view('merchant/'.$content);  ?>
        <?php $this->load->view('layout/footer');  ?>
        <?php $this->load->view('layout/tinyfooter');  ?>
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <?php if(!empty($script)){ 
        $this->load->view('merchant/'.$script);
    } ?>
</body>
</html>