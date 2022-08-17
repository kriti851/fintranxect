<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet"/>

<style>

.section-space80 {
    padding-top: 35px;
    padding-bottom: 35px;
}

.P-left-0 { padding-left:0px;}
.p-right-0 { padding-right:0px;}
.loop-default-list .article-thumb {
    margin: 0.5px;
}

.loop-default-list .loop-article:before {
    content: "";
    display: block;
    padding-top: 120%;
}
.loop-default-list .content-wrap {
    display: table-cell;
    text-align: center;
    vertical-align: middle;
    padding: 72px 40px;
}
.h-65 {height: 65px;}
.loop-default-list .image-overlay { padding: 0px;}
.loop-default-list .image-overlay { background: transparent;}
.content-wrap ul {list-style: none; padding-left: 0px;font-size: 16px; text-align: center;}
.content-wrap ul li {
    margin-bottom: 6px;
    line-height: normal;
    font-size: 22px;
}
.content-wrap ul li b {
    font-weight:700;
}
.loop-default-list h3 {
    font-size: 32px;
    text-align: center;
    margin-bottom: 20px;
    font-weight: 700;
}
.feature-icon-style .feature-icon {
    margin: 0 auto 0px auto;
    background-color: #fff;
    width: 170px;
    height: 100px;
    border-radius: 0px;
    padding: 0px;
    text-align: center;
    color: #007bff;
}
.owl-carousel .feature-icon img {
    width: 100%;
    object-fit: contain;
    height: 100px;
}
::-webkit-input-placeholder {
    color:white;
}

::-moz-placeholder {
    color:white;
}

::-ms-placeholder {
    color:white;
}

::placeholder {
    color:white;
}

.carousel {
    position: relative;
    margin-top: 120px;
}
#carousel .carousel-item {
  height: 100vh;
  width: 100%;
  min-height: 350px;
  background: no-repeat center center scroll;
  background-size: cover;
}

#carousel .carousel-inner .carousel-item {
  transition: -webkit-transform 2s ease;
  transition: transform 2s ease;
  transition: transform 2s ease, -webkit-transform 2s ease;
}

#carousel .carousel-item .caption {
    background-color: TRANSPARENT;
    color: white;
    TEXT-ALIGN: CENTER;
}
.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
    height: 75vh;
}
#carousel .caption h2 {
  animation-duration: 1s;
  animation-delay: 2s;
  COLOR:#fff;
  font-size: 54px;
    text-transform: uppercase;
    line-height: normal;
    font-weight: 900;
}

#carousel .caption p {
  animation-duration: 1s;
  animation-delay: 2s;
  color: #fff;
    font-size: 22px;
}

#carousel .caption a {
  animation-duration: 1s;
  animation-delay: 2s;
}

/* Button */
.delicious-btn {
  display: inline-block;
  min-width: 160px;
  height: 60px;
  color: #ffffff;
  border-color: #a1252b;
  border-radius: 0;
  padding: 0 30px;
  font-size: 16px;
  line-height: 58px;
  font-weight: 600;
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  text-transform: capitalize;
  background-color: #a1252b;
}

.delicious-btn.active, .delicious-btn:hover, .delicious-btn:focus {
  font-size: 16px;
  font-weight: 600;
  color: #ffffff;
  background-color: #ec1e1e;
  border-color: #a1252c;
}
.carousel-indicators li {
    width: 12px;
    height: 12px;
    margin-right: 8px;
    margin-left: 8px;
    background-color: #fff;
    border-top: none;
    border-bottom: none;
    border-radius: 100px;
}
.h-100 {
    height: 87%!important;
}
@media screen and (min-width: 568px) and (max-width: 767px) {

}

@media screen and (min-width: 320px) and (max-width: 568px) {
.loop-default-list .content-wrap {
    padding: 30px 20px;
}
.content-wrap ul li {
    font-size: 16px;
}
.loop-default-list h3 {
    font-size: 26px;
    margin-bottom: 10px;
}
.img-btn {
    font-size: 13px;
    line-height: normal;
    padding: 15px 20px;
    margin-top: 0px;
}
}

@media (min-width: 1536px){
.container-newwidth {
    width: 1280px;
}
}

@media screen and (max-width: 1366px){

}

@media screen and (max-width: 1700px) and (min-width: 1400px){

}
@media screen and (max-width: 2000px) and (min-width: 1701px){

}
</style>
<script>
	document.getElementById('home-active').classList.add("active");
</script>
<div id="carousel" class="carousel slide hero-slides" data-ride="carousel">
  <ol class="carousel-indicators">
    <li class="active" data-target="#carousel" data-slide-to="0"></li>
    <li data-target="#carousel" data-slide-to="1"></li>
    <li data-target="#carousel" data-slide-to="2"></li>
	<li data-target="#carousel" data-slide-to="3"></li>
    <li data-target="#carousel" data-slide-to="4"></li>
	<li data-target="#carousel" data-slide-to="5"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active" style="background-image: linear-gradient(rgba(0, 0, 0, 0.37) 0%, rgba(0, 0, 0, 0.37) 100%), url('<?php echo base_url('assets/img/home-newimg/slider-2.jpg'); ?>')">
      <div class="container h-100 d-md-block">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <h2 class="animated fadeIn">Enabling Lives Digitally</h2>
              <p class="animated fadeIn">FinTranxect</p>
              <a class="animated fadeIn btn delicious-btn" href="#">SERVICES</a>
            </div>
          </div>
        </div>
      </div>
    </div>

	<div class="carousel-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.37) 0%, rgba(0, 0, 0, 0.37) 100%), url('<?php echo base_url('assets/img/home-newimg/slider-3.jpg'); ?>')">
      <div class="container h-100 d-md-block">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <h2 class="animated fadeIn">Aadhaar Enabled Payment System</h2>
              <p class="animated fadeIn">Cash Withdrawal & Deposit</p>
              <a class="animated fadeIn btn delicious-btn" href="#">LEARN MORE</a>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div class="carousel-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.37) 0%, rgba(0, 0, 0, 0.37) 100%), url('<?php echo base_url('assets/img/home-newimg/slider-6.jpg'); ?>')">
      <div class="container h-100 d-md-block">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <h2 class="animated fadeIn">Insurance</h2>
              <a class="animated fadeIn btn delicious-btn" href="#">GET IN TOUCH</a>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div class="carousel-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.37) 0%, rgba(0, 0, 0, 0.37) 100%), url('<?php echo base_url('assets/img/home-newimg/slider-4.jpg'); ?>')">
      <div class="container h-100 d-md-block">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <h2 class="animated fadeIn">Loans</h2>
              <p class="animated fadeIn">Personal Loans /  Business Loans</p>
              <a class="animated fadeIn btn delicious-btn" href="#">GET IN TOUCH</a>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div class="carousel-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.37) 0%, rgba(0, 0, 0, 0.37) 100%), url('<?php echo base_url('assets/img/home-newimg/slider-5.jpg'); ?>')">
      <div class="container h-100 d-md-block">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <h2 class="animated fadeIn">POINT OF SALE</h2>
              <a class="animated fadeIn btn delicious-btn" href="#">MORE INFO</a>
            </div>
          </div>
        </div>
      </div>
    </div>
	<div class="carousel-item" style="background-image: linear-gradient(rgba(0, 0, 0, 0.37) 0%, rgba(0, 0, 0, 0.37) 100%), url('<?php echo base_url('assets/img/home-newimg/slider-1.jpg'); ?>')">
      <div class="container h-100 d-md-block">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <h2 class="animated fadeIn">UPI</h2>
              <a class="animated fadeIn btn delicious-btn" href="#">MORE INFO</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  
  </div>
</div>



   <div class="section-space80">
        <div class="container container-newwidth p-left24 p-right24">
		   <div class="offset-xl-2 col-xl-8 offset-md-2 col-md-8 offset-md-2 col-md-8 col-sm-12 col-12">
                    <div class="mb30 text-center section-title">
                        <!-- section title start-->
                        <h1 class="services-title">SERVICES</h1>
                    </div>
                    <!-- /.section title start-->
                </div>
		
            <div class="row m-left0 m-right0">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_3.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>LOANS</h3>
									<ul>
									  <li><b>Personal / Business Loan</b></li>
									  <li>No Collateral/Security Required</li>
									  <li>Unsecured No collateral </li>
									</ul>
									<a href="<?php echo site_url('/login') ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_4.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>POS</h3>
									<ul>
									  <li><b> All Cards Accepted</b></li>
									  <li>3rd Party Integration, SMS invoicing,</li>
									  <li>Paperless Invoicing</li>
									</ul>
									<a href="<?php  echo site_url('service'); ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_5.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>UPI</h3>
									<ul>
									  <li><b> IMPS based Instant Transfer </b></li>
									  <li>Pay for Utility Bills OTC Payment</li>
									</ul>
									<a href="<?php  echo site_url('service'); ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_6.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>Insurance</h3>
									<ul>
									  <li><b> Wide variety of Insurance type.</b></li>
									  <li>Health, Auto, Property - All covered</li>
									  <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
									</ul>
									<a href="<?php  echo site_url('service'); ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_7.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>BBPS</h3>
									<ul>
									  <li><b> Bill Payment & Recharge</b></li>
									  <li>Top-u, Postpaid Mobile phone,</li>
									  <li>Utility Bill , Digital TV, Domestic Money Transfer</li>
									</ul>
									<a href="<?php  echo site_url('service'); ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_8.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>AEPS</h3>
									<ul>
									  <li><b> Cash withdrawal & Deposite</b></li>
									  <li>Aadhaar to Aadhaar fund transfer</li>
									  <li>Balance Enquriy</li>
									</ul>
									<a href="<?php  echo site_url('service'); ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list p-left-0 p-right-0">
                    <div class="loop-article">
						<div class="article-thumb" 
						 style="background-image: url('<?php echo base_url('assets/img/home-newimg/Screenshot_9.jpg'); ?>')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>Loyalty</h3>
									<ul>
									  <li><b> Points Based</b></li>
									  <li>UPI Supported</li>
									  <li>Prepaid Cars & Vouchers</li>
									</ul>
									<a href="<?php  echo site_url('service'); ?>" class="img-btn"> LEARN MORE </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
            </div>
        </div>
    </div>
	
	
	
	
	
	<div class="section-space80">
        <div class="container container-newwidth">
		   <div class="offset-xl-2 col-xl-8 offset-md-2 col-md-8 offset-md-2 col-md-8 col-sm-12 col-12">
                    <div class="mb30 text-center section-title">
                        <!-- section title start-->
                        <h1 class="services-title">OUR PARTNERS</h1>
                    </div>
                    <!-- /.section title start-->
                </div>
		
            <div class="row">
            <div class="service" id="service">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white mb30 feature-icon-style">
                        <div class="feature-icon mb40">
						    <img src="<?php echo base_url('assets/img/Partner-Logo/faircent-smo-logo1.png'); ?>" alt="" class="" />
						</div>
                    </div>
                </div>
                
				
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white mb30 feature-icon-style">
                        <div class="feature-icon mb40">
						    <img src="<?php echo base_url('assets/img/Partner-Logo/0.jpg'); ?>" alt="" class="" />
						</div>
                    </div>
                </div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white mb30 feature-icon-style">
                        <div class="feature-icon mb40">
						    <img src="<?php echo base_url('assets/img/Partner-Logo/Lendingkart.jpg'); ?>" alt="" class="" />
						</div>
                    </div>
                </div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white mb30 feature-icon-style">
                        <div class="feature-icon mb40">
						    <img src="<?php echo base_url('assets/img/Partner-Logo/neo.jpg'); ?>" alt="" class="" />
						</div>
                    </div>
                </div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white mb30 feature-icon-style">
                        <div class="feature-icon mb40">
						    <img src="<?php echo base_url('assets/img/Partner-Logo/qrupia.png'); ?>" alt="" class="" />
						</div>
                    </div>
                </div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white mb30 feature-icon-style">
                        <div class="feature-icon mb40">
						    <img src="<?php echo base_url('assets/img/Partner-Logo/download.jpg'); ?>" alt="" class="" />
						</div>
                    </div>
                </div>
				
				
				
            </div>
        </div>
			
        </div>
    </div>
	
	
	
<div class="footer section-space770" style="background-image: url('<?php echo base_url('assets/img/home-newimg/newsletter.jpg'); ?>'); background-position: center; background-size: cover;background-repeat: no-repeat;">
    <!-- footer -->
    <div class="container container-newwidth">
        <div class="row ">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="row ">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="newsletter-title ">SUBSCRIBE</h3>
						<p class="newsletter-p">Sign up to hear our latest news.</p>
                    </div>
                    <div class="col-md-2"></div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 ">
                        <div class="newsletter-form ">
                            <!-- Newsletter Form -->
                            <form action="" method="post">
                                <div class="input-group">
                                    <!--<input type="email" class="form-control border-0 shadow-none" id="newsletter" name="newsletter" placeholder="E-Mail Address" required="" style="color:#fff;">-->
									
									<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
									  <div class="md-input">
										<input class="md-form-control" required="" type="text">
										<label>Email Address</label>
									   </div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
										<span class="input-group-btn">
											<button class="btn btn-secondary" type="submit">SIGN UP</button>
										</span>
									</div>
									
                                </div>
                                <!-- /input-group -->
                            </form>
                        </div>
                        <!-- /.Newsletter Form -->
                    </div>
					<div class="col-md-2"></div>
                </div>
                <!-- /.col-lg-6 -->
            </div>
        </div>
    </div>
</div>
	


 <div class="section-space60">
        <div class="container container-newwidth">
		   <div class="offset-xl-2 col-xl-8 offset-md-2 col-md-8 offset-md-2 col-md-8 col-sm-12 col-12">
                    <div class="mb30 text-center section-title">
                        <!-- section title start-->
                        <h1 class="services-title">CONNECT WITH US</h1>
                    </div>
                    <!-- /.section title start-->
                </div>
		
            <div class="row">
                <p class="text-center social-icon">
				  <a href="" class="mr-10px"><i class="fab fa-facebook" style="font-size: 48px;"></i></a>
				  <a href="" class="mr-10px"><i class="fab fa-linkedin" style="font-size: 48px;"></i></a>
				</p>
				
            </div>
        </div>
    </div>


<?php //$this->load->view('layout/help'); ?>




