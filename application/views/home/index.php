<style>
.header-topbar {
    background-color: transparent !important;
    position: absolute;
    z-index: 9;
    width: 100%;
	border-bottom: none;
}
.h-65 {height: 65px;}
.slider-title { font-size: 38px;}
.loop-default-list .image-overlay { padding: 10px;}
.loop-default-list .content-wrap { border: 1px solid #fff;}
.loop-default-list .image-overlay {  background: rgba(0, 0, 0, 0.8);}
.content-wrap ul {list-style: none; padding-left: 0px;font-size: 16px; text-align: center;}
.content-wrap ul li { margin-bottom:15px;line-height: 20px;}
.loop-default-list h3 { margin-bottom: 20px; text-align: center;}
@media only screen and (max-width: 460px) {
.slider-title { font-size: 24px; line-height: initial;}
}
@media screen and (min-width: 568px) and (max-width: 767px) {
.slider-captions { bottom: 0px;}

}
</style>

<script>
	document.getElementById('home-active').classList.add("active");
</script>
<div class="slider" id="slider">
    <!-- slider -->
    <div class="slider-img">
        <img src="<?php echo base_url('assets/img/newhomeimg/slider-1.jpg'); ?>" alt="" class="" />
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="slider-captions">
                        <!-- slider-captions -->
                        <h1 class="slider-title">Enabling Lives Digitally</h1>
                        <p class="slider-text d-none d-xl-block d-lg-block d-sm-block h-65">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br /></p>
                       <!-- <a href="<?php echo site_url('/login'); ?>" class="btn btn-secondary">GET LOAN</a>-->
                    </div>
                    <!-- /.slider-captions -->
                </div>
            </div>
        </div>
    </div>
    <!-- <div>
        <div class="slider-img">
            <img src="<?php echo base_url('assets/img/slider-1.jpg'); ?>" alt="" class="" />
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="slider-captions">
                            <h1 class="slider-title">Home Loan to Suit Your Needs.</h1>
                            <p class="slider-text d-none d-xl-block d-lg-block d-sm-block">The low rate you need for the need you want! Call<br /></p>
                            <a href="<?php echo site_url('loan'); ?>" class="btn btn-secondary">GET LOAN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="slider-img">
            <img src="<?php echo base_url('assets/img/slider-1.jpg'); ?>" alt="" class="" />
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="slider-captions">
                            <h1 class="slider-title">Business Loan to Suit Your Needs.</h1>
                            <p class="slider-text d-none d-xl-block d-lg-block d-sm-block">The low rate you need for the need you want! Call<br /></p>
                            <a href="<?php echo site_url('loan'); ?>" class="btn btn-secondary">GET LOAN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>



<!--<div class="section-space80">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="<?php echo base_url('/login') ?>" class="article-thumb" style="background-image: url('assets/img/newhomeimg/loan-img.jpg')">
							<div class="image-overlay">
								
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="<?php echo base_url('/registration') ?>" class="article-thumb" style="background-image: url('assets/img/newhomeimg/upi.jpg')">
							<div class="image-overlay">
	
							</div>
						</a>
					</div>
				</div>
				
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/pos-img.jpg')">
							<div class="image-overlay">
								
							</div>
						</a>
					</div>
				</div>
				
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/aeps-img.jpg')">
							<div class="image-overlay">
								
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/bbps.jpg')">
							<div class="image-overlay">
								
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/bill-payment-recharge-img.jpg')">
							<div class="image-overlay">
								
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/loyalty-img.jpg')">
							<div class="image-overlay">
								
							</div>
						</a>
					</div>
				</div>
				
            </div>
        </div>
    </div>-->







   <div class="section-space80">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="<?php echo site_url('/login') ?>" class="article-thumb" style="background-image: url('assets/img/newhomeimg/loan-new-01.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>Loans</h3>
									<ul>
									  <li>Personal loans with No Collateral</li>
									  <li>Unsecured No collateral Business Loans</li>
									  <li>Min. KYC & documentation</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/up-new--2.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>UPI</h3>
									<ul>
									  <li>IMPS based instant transfer</li>
									  <li>Pay for utility bills</li>
									  <li>OTC payments</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/pos-new-03.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>POS</h3>
									<ul>
									  <li>All cards accepted</li>
									  <li>3rd party integration</li>
									  <li>Paperless invoicing</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/insurance-new-04.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>Insurance</h3>
									<ul>
									  <li>Wide variety of insurance types</li>
									  <li>Health, Auto, Property – all covered</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/aeps-new-05.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>AEPS</h3>
									<ul>
									  <li>Cash withdrawal & deposit</li>
									  <li>Aadhaar to Aadhaar fund transfer</li>
									  <li>Balance Enquiry</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/bbps-new--6.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>BBPS</h3>
									<ul>
									  <li>BBPS| DMT | IRCTC | RECHARGES</li>
									  <li>Utility bill payments</li>
									  <li>Rail tickets, Domestic money transfer</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 loop-default-list">
                    <div class="loop-article">
						<a href="#" class="article-thumb" style="background-image: url('assets/img/newhomeimg/loyalty--new-07.jpg')">
							<div class="image-overlay">
								<div class="content-wrap">
									<h3>Loyalty</h3>
									<ul>
									  <li>Points based</li>
									  <li>UPI supported</li>
									  <li>Prepaid cards & vouchers</li>
									</ul>
								</div>
							</div>
						</a>
					</div>
				</div>
				
            </div>
        </div>
    </div>


<!--<div class="section-space80">
    <div class="container mobile-width97">
       
        <div class="row">
            <div class="service" id="service">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon mb40"><i class="fas fa-landmark fa-2x"></i></div>
                        <h2><a href="#!" class="title">Loans</a></h2>
                        <p>Lorem ipsum dolor sit ameectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque</p>
                        <a href="#!" class="btn-link">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon"><i class="fab fa-accusoft fa-2x"></i></div>
                        <h2><a href="#!" class="title">UPI Payments</a></h2>
                        <p>Sed ut perspiciatis unde omnis rror sit voluptatem accusan tium dolo remque laudantium, totam rem aperiam, eaque ipsa</p>
                        <a href="#!" class="btn-link">&nbsp; &nbsp;</a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon"><i class="fas fa-funnel-dollar fa-2x"></i></div>
                        <h2><a href="#!" class="title">Domestic Money Transfer</a></h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elmodo ligula eget. Cum sociis natoque</p>
                        <a href="#!" class="btn-link">&nbsp; &nbsp;</a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon"><i class="fas fa-charging-station fa-2x"></i></div>
                        <h2><a href="#!" class="title">Recharge</a></h2>
                        <p>Lorem ipsum dolor sit nean commodo ligula eget dolor simple dummyum sociis natoque.amet, consectetuer adipiscing elit.</p>
                        <a href="#!" class="btn-link">&nbsp; &nbsp;</a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon"><i class="fas fa-file-invoice-dollar fa-2x"></i></div>
                        <h2><a href="#!" class="title">Bill Payments</a></h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque.</p>
                        <a href="#!" class="btn-link">&nbsp; &nbsp;</a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon"><i class="fas fa-award fa-2x"></i></div>
                        <h2><a href="#!" class="title">Loyalty and rewards</a></h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque.</p>
                        <a href="#!" class="btn-link">&nbsp; &nbsp;</a>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="bg-white pinside40 service-block outline mb30 feature-icon-style">
                        <div class="feature-icon"><i class="fas fa-user-shield fa-2x"></i></div>
                        <h2><a href="#!" class="title">Insurance</a></h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque.</p>
                        <a href="#!" class="btn-link">&nbsp; &nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
--->


<?php //$this->load->view('layout/help'); ?>