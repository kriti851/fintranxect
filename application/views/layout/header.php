<style>
.max-width100 { max-width: 100%;}
#navbar {
    background-color: #fff !important;
    padding: 25px 10px;
    transition: 0.4s;
    /* position: fixed; */
    width: 100%;
    top: 0;
    z-index: 99;
}
.header-topbar {
    position: relative;
    z-index: 9;
    width: 100%;
	border-bottom: none;
}
.navbar {
    padding: 0px 0px;
    box-shadow: 0px 1px 9px #c3c3c3;
	
}
.navbar-light .navbar-nav .nav-link:hover {
    color: rgb(199, 0, 0);
    border-bottom: 2px solid rgb(199, 0, 0);
}
.navbar-light .navbar-nav .active>.nav-link, .navbar-light .navbar-nav .nav-link.active {
    color: rgb(165 41 45);
    border-bottom: 2px solid #a5292d;
}
.navbar-expand-lg .navbar-nav .nav-link {
    padding-right: 1.2rem;
    padding-left: 1.2rem;
    text-transform: capitalize;
    font-size: 15px;
    font-weight: 600;
	border-bottom: 2px solid #fff;
}
.navbar-expand-lg .navbar-nav .dropdown-menu {
    position: absolute;
    float: left;
    left: 0px;
    right: 0px;
}

.btn-secondary {
    background-color: #a1252b;
    color: #fff;
    border-color: #a1252b;
}
.btn-secondary:hover {
    color: #fff;
    background-color: #ec1e1e;
    border-color: #a1252c;
}
.navbar-light .navbar-nav .nav-link:hover, .navbar-nav .dropdown-item:hover, .navbar-nav .dropdown-menu .dropdown-item .dropdown-link:hover {
    color: #a1262b;
}

.footer {
    background-color: rgb(199, 0, 0);padding-bottom: 15px;
}
.tiny-footer {
    background-color: rgb(199, 0, 0);
    padding-top: 20px;
    padding-bottom: 15px;
}

</style> 

 <?php  
        $controller =$this->router->fetch_class();
        $method=$this->router->fetch_method();
    ?>
    <?php if(!empty($showheader) && $showheader=='No'){  }else{ ?>
    <div class="header-topbar" id="navbar" >       
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container top-full-width max-width100">
                <a href="<?php echo site_url(); ?>" class="navbar-brand" id="logo">
				<img src="<?php echo base_url('assets/img/home-newimg/new-logo-header.png'); ?>" alt="" /></a>
                
				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar top-bar mt-0"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" id="home-active" href="<?php echo base_url(); ?>"> HOME</a></li>
						<li class="nav-item"><a class="nav-link" id="about-active" href="<?php  echo site_url('about'); ?>"> ABOUT US</a></li>
						<li class="nav-item"><a class="nav-link"  id="service-active" href="<?php  echo site_url('service'); ?>"> SERVICES</a></li>
						<li class="nav-item"><a class="nav-link" id="conatct-active" href="<?php  echo site_url('contact'); ?>"> CONTACT US</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="term-privacy-active" href="#!" id="navbarBlog" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                PRIVACY POLICY
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarBlog">
                                <a class="dropdown-item" id="privacy-active" href="<?php  echo site_url('privacy-policy'); ?>">Privacy Policy</a>
                                <a class="dropdown-item" id="terms-active" href="<?php  echo site_url('terms-of-use'); ?>">Terms of Use</a>
                            </div>
                        </li>
                        <?php if(!$this->session->userdata('user_id')){ ?>
                        <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#myModal" href="">PARTNER WITH US</a></li>
                        <?php } ?>
                    </ul>
                    
                </div>
			   
			</div>
        </nav>
    </div>
    <?php } ?>
    <?php if(!empty($showPartnerHeader) && $showPartnerHeader=='Yes'){ ?>
    <div class="header-topbar" id="navbar">       
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container top-full-width max-width100">
                <a href="javascript:void(0)" class="navbar-brand" id="logo">
                    <?php if(!empty($logoagent->logo)){ ?>
                        <img src="<?php echo base_url('uploads/logo/'.$logoagent->logo); ?>" alt=""></a>
                    <?php } ?>
                </a>
                
			</div>
        </nav>
    </div>
    <?php } ?>
	<script> var fn; </script>
	
	
	
	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Partner With Us</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <br>
        <strong class="text-center" id="show_message"></strong>
		
      </div>
      <div class="modal-body">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <small class="text-danger invalid-str"></small>
                <input id="partner_name" type="text" title="Name" placeholder="Name" class="form-control input-md">
            </div>
			<div class="form-group">
                <small class="text-danger invalid-str"></small>
                <input id="partner_email" type="email" title="Email" placeholder="Email*" class="form-control input-md" >
            </div>
			 <div class="form-group">
                <small class="text-danger invalid-str"></small>
                <input id="partner_mobile_number" title="Mobile Number" type="text" placeholder="Mobile Number" class="form-control input-md" >
            </div>
			<div class="form-group">
                <small class="text-danger invalid-str"></small>
                <input id="partner_business_url" title="Business URL" type="text" placeholder="Business URL" class="form-control input-md">
            </div>
			 <div class="form-group">
                <small class="text-danger invalid-str"></small>
                <textarea id="partner_comments" title="Comments" placeholder="Tell us about your business needs, and we will get back to you with solutions." class="form-control input-md" style="height:100px;"></textarea>
            </div>
		</div>
		<div class="col-md-12 col-sm-12 col-12">
            <button type="button" onclick="SubmitPartnerWithUs()" class="btn btn-secondary view-loan-button">SEND</button> 
        </div> 
		
      </div>
    </div>

  </div>
</div>
<?php if(!empty($showPartnerHeader) && $showPartnerHeader=='Yes'){ ?>
	<script>
    document.getElementById("navbar").style.padding = "0px 10px";
    document.getElementById("logo").style.width = "160px";
</script>
<?php }else{ if(!empty($showheader)){ }else{  ?>
    <script>
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
            document.getElementById("navbar").style.padding = "10px 10px";
            document.getElementById("logo").style.width = "160px";
        } else {
            document.getElementById("navbar").style.padding = "30px 10px";
            document.getElementById("logo").style.width = "220px";
        }
    }
    </script>
<?php }} ?>
