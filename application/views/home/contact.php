<style>
.header-topbar {border-bottom: 1px solid #ccc;}
.wrapper-content { margin-top: 0px; margin-bottom: 50px;}
.section-space80 { padding-top:150px; padding-bottom:0px;}
.md-input { width: 100%; margin-bottom: 20px;}
.md-input .md-form-control { background-color: rgb(246, 246, 246); border-color: rgb(218, 218, 218);color: #000;}
.md-input .md-form-control:focus ~ label, .md-input .md-form-control:valid ~ label { color: #404040;}
.md-input label { color: #404040;}
textarea.form-control { background-color: rgb(246, 246, 246);}
.btn-secondary { background-color: #a1252b; border-color: #a1252b;}
</style>


<script>
	document.getElementById('conatct-active').classList.add("active");
</script>
<div class="section-space80">
    <!-- content start -->
    <div class="container">
	
	  <div class="contact-heading mb30"><h1> CONTACT US </h1></div>
	  <p class="contact-heading-p  text-center"> Get in Touch </p>
	  
      <div class="row">
        <div class="col-md-12">
          <div class="wrapper-content bg-white">
            <div class="about-section mt30">
              <div class="row">
			  
			    <div class="col-xl-3"></div>
                <div class="col-sm-6 text-center">
					<strong class="text-success" ><?php if(!empty($success_message)){ echo $success_message; } ?></strong>
                   	<form action="" method="post">
                        <div class="input-group">
							<small class="text-danger"><?php echo form_error('name'); ?></small>
							<div class="md-input">
								<input class="md-form-control" name="name"  type="text">
								<label>Name</label>
							</div>
						</div>
						<div class="input-group">
							<small class="text-danger"><?php echo form_error('email'); ?></small>
							<div class="md-input">
								<input class="md-form-control" name="email" type="text">
								<label>Email*</label>
							</div>
						</div>
						<div class="input-group">
							<small class="text-danger"><?php echo form_error('mobile_number'); ?></small>
							 <div class="md-input">
								<input class="md-form-control" name="mobile_number" type="text">
								<label>Mobile Number</label>
							</div>
						</div>
						<div class="input-group">
							<small class="text-danger"><?php echo form_error('business_url'); ?></small>
							<div class="md-input">
								<input class="md-form-control" name="business_url"  type="text">
								<label>Business URL</label>
							</div>
						</div>
					   <div class="form-group">
					   		<small class="text-danger float-left"><?php echo form_error('comments'); ?></small>
							<textarea name="comments" placeholder="Tell us about your business needs, and we will get back to you with solutions." class="form-control input-md" style="height:140px;"></textarea>
						</div>
					   <div class="col-md-12 col-sm-12 col-12">
						  <button type="submit" class="btn btn-secondary">SEND</button> 
					   </div> 
					   <p class="captch">This site is protected by reCAPTCHA and the Google 
					   <a style="color: #a1252b;font-weight: 700;" target="_blank" href="https://policies.google.com/privacy">Privacy Policy </a> and 
					   <a style="color: #a1252b;font-weight: 700;" target="_blank" href="https://policies.google.com/terms"> Terms of Service</a> apply.</p>
					   
					   
					   <h2 class="mb30 mt30">Communication is the Key</h2>
					   <h4>We strive to stay in communication with our clients. Have a question about our business, or want to see if we match your specific needs? Send us a message, or give us a call. We're always happy to meet new customers!</h4>
					   
					   
					    <h2 class="mb30 mt30">Fintranxect</h2>
					    <h4>Mooz Office Space, 5th Floor, BPTP Park Centra, Sector -30, Gurgaon-122001</h4>
					   	   
                   </form>
                </div>
                <div class="col-xl-3"></div>
               
              </div>
            </div>
          </div>
        </div>
      </div>
	 
    </div>
  </div>




<section class="">
  	<div class="responsive-map-container">
   		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d94392.21469405403!2d76.95152236758162!3d28.453284758873927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d19c4d3c70869%3A0x1e2dd7a39f07603f!2sMooZ%20Offices!5e0!3m2!1sen!2sin!4v1600953277671!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
  	</div>
</section>


 <div class="section-space60">
        <div class="container container-newwidth">
		   <div class="offset-xl-2 col-xl-8 offset-md-2 col-md-8 offset-md-2 col-md-8 col-sm-12 col-12">
                    <div class="mb30 text-center section-title">
                        <!-- section title start-->
                        <h1 class="services-title">SOCIAL</h1>
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