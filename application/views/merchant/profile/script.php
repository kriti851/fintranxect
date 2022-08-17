<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script>
    "use strict";
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
    //if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
    var currentid=$(this).attr('id');
    if(currentid=='next-1'){
        $('#first_name_error').html('');
        $('#last_name_error').html('');
        $('#email_error').html('');
        $('#phone_error').html('');
        $('#age_error').html('');
        var first_name=$('#first_name').val();
        if(first_name==""){
            $('#first_name_error').html('The First Name Field Required');
            return false;
        }
        var last_name=$('#last_name').val();
        if(last_name==""){
            $('#last_name_error').html('The Last Name Field Required');
            return false;
        }
        var age=$('#age').val();
        if(age==""){
            $('#age_error').html('The Age Field Required');
            return false;
        }else if(age>=80){
            $('#age_error').html('Please Enert Correct Age');
            return false;
        }
        var email=$('#email').val();
        var ajax1=$.ajax({
            url: SiteUrl+"profile/email_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"email":email},
            success: function(result){
                if(result.status=="fail"){
                    $('#email_error').html(result.message);
                    return false;
                }              
            }
        });
        $.when(ajax1).done(function(a1){
            console.log(a1);
            if(a1.status=="success"){
               $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        	
            	//show the next fieldset
            	next_fs.show(); 
            	//hide the current fieldset with style
            	current_fs.animate({opacity: 0}, {
            		step: function(now, mx) {
            			//as the opacity of current_fs reduces to 0 - stored in "now"
            			//1. scale current_fs down to 80%
            			scale = 1 - (1 - now) * 0.2;
            			//2. bring next_fs from the right(50%)
            			left = (now * 50)+"%";
            			//3. increase opacity of next_fs to 1 as it moves in
            			opacity = 1 - now;
            			current_fs.css({'transform': 'scale('+scale+')'});
            			next_fs.css({'left': left, 'opacity': opacity});
            		}, 
            		duration: 200, 
            		complete: function(){
            			current_fs.hide();
            			animating = false;
            		}, 
            		//this comes from the custom easing plugin
            		easing: 'easeOutQuint'
            	});
            }
        });
    }else if(currentid=='next-2'){
        $('#business_name_error').html('');
        $('#vintage_error').html('');
        $('#address1_error').html('');
        $('#turn_over_error').html('');
        $('#pan_number_error').html('');
        $('#gst_number_error').html('');
        var business_name=$('#business_name').val();
        if(business_name==""){
            $('#business_name_error').html('The Business Name Field Required');
            return false;
        }
        var address1=$('#address1').val();
        if(address1==""){
            $('#address1_error').html('The Address Field Required');
            return false;
        }
        var vintage=$('#vintage').val();
        if(vintage==""){
            $('#vintage_error').html('The Vintage Field Required');
            return false;
        }
        var turn_over=$('#turn_over').val();
        if(turn_over==""){
            $('#turn_over_error').html('The Turn Over Field Required');
            return false;
        }
        var pan_number=$('#pan_number').val();
        if(pan_number==""){
            $('#pan_number_error').html('The Pan Number Field Required');
            return false;
        }
        var gst_number=$('#gst_number').val();
        if(gst_number==""){
            $('#gst_number_error').html('The Gst Number Field Required');
            return false;
        }
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        	
        	//show the next fieldset
        	next_fs.show(); 
        	//hide the current fieldset with style
        	current_fs.animate({opacity: 0}, {
        		step: function(now, mx) {
        			//as the opacity of current_fs reduces to 0 - stored in "now"
        			//1. scale current_fs down to 80%
        			scale = 1 - (1 - now) * 0.2;
        			//2. bring next_fs from the right(50%)
        			left = (now * 50)+"%";
        			//3. increase opacity of next_fs to 1 as it moves in
        			opacity = 1 - now;
        			current_fs.css({'transform': 'scale('+scale+')'});
        			next_fs.css({'left': left, 'opacity': opacity});
        		}, 
        		duration: 200, 
        		complete: function(){
        			current_fs.hide();
        			animating = false;
        		}, 
        		//this comes from the custom easing plugin
        		easing: 'easeOutQuint'
        	});
    } else if(currentid=='next-3'){
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        	
        	//show the next fieldset
        	next_fs.show(); 
        	//hide the current fieldset with style
        	current_fs.animate({opacity: 0}, {
        		step: function(now, mx) {
        			//as the opacity of current_fs reduces to 0 - stored in "now"
        			//1. scale current_fs down to 80%
        			scale = 1 - (1 - now) * 0.2;
        			//2. bring next_fs from the right(50%)
        			left = (now * 50)+"%";
        			//3. increase opacity of next_fs to 1 as it moves in
        			opacity = 1 - now;
        			current_fs.css({'transform': 'scale('+scale+')'});
        			next_fs.css({'left': left, 'opacity': opacity});
        		}, 
        		duration: 200, 
        		complete: function(){
        			current_fs.hide();
        			animating = false;
        		}, 
        		//this comes from the custom easing plugin
        		easing: 'easeOutQuint'
        	});
    }else if(currentid=='next-4'){
        $('#pan_image_error').html('');
        $('#adhar_image_error').html('');
        var pancard_image=$('#pancard_image').val();
        if(pancard_image!=''){
            var ext = $('#pancard_image').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                $('#pan_image_error').html('Only png,jpg,jpeg file Allowed');
            return false;
            }
        }
        
        var adharcard_image=$('#adharcard_image').val();
        if(adharcard_image!=''){
            var ext = $('#adharcard_image').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                $('#adhar_image_error').html('Only png,jpg,jpeg file Allowed');
                return false;
            }
        }
        $('#OpenOtpModel').modal('show');   
        SublitLoan();
    }else{
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        	
        	//show the next fieldset
        	next_fs.show(); 
        	//hide the current fieldset with style
        	current_fs.animate({opacity: 0}, {
        		step: function(now, mx) {
        			//as the opacity of current_fs reduces to 0 - stored in "now"
        			//1. scale current_fs down to 80%
        			scale = 1 - (1 - now) * 0.2;
        			//2. bring next_fs from the right(50%)
        			left = (now * 50)+"%";
        			//3. increase opacity of next_fs to 1 as it moves in
        			opacity = 1 - now;
        			current_fs.css({'transform': 'scale('+scale+')'});
        			next_fs.css({'left': left, 'opacity': opacity});
        		}, 
        		duration: 200, 
        		complete: function(){
        			current_fs.hide();
        			animating = false;
        		}, 
        		//this comes from the custom easing plugin
        		easing: 'easeOutQuint'
        	});
    }
});

$(".previous").click(function(){
	//if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 200, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

/*$(".submit").click(function(){
	return false;
})*/

/* $(document).ready(function() {
    $('select').material_select();
  });*/

 
$("fieldset").delegate(".removeOrder", "click", function () {  
    $(this).closest('.card').remove();
  }
);  

function SublitLoan(){
    var formData = new FormData();
    formData.append('first_name', $('#first_name').val());
    formData.append('last_name', $('#last_name').val());
    formData.append('email', $('#email').val());
    formData.append('age', $('#age').val());
    formData.append('gst_number', $('#gst_number').val());
    formData.append('business_name', $('#business_name').val());
    formData.append('address1', $('#address1').val());
    formData.append('vintage', $('#vintage').val());
    formData.append('turn_over', $('#turn_over').val());
    formData.append('business_type', $('#business_type').val());
    formData.append('pan_number', $('#pan_number').val());
    formData.append('reference', $('#reference').val());

    var other_pannumber=document.getElementsByName('other_pannumber[]');
    for (var i = 0; i <other_pannumber.length; i++) {
        formData.append('other_pannumber[]',other_pannumber[i].value);
    }

    var other_phone_number=document.getElementsByName('other_phone_number[]');
    for (var i = 0; i <other_phone_number.length; i++) {
        formData.append('other_phone_number[]',other_phone_number[i].value);
    }

    var other_office_address=document.getElementsByName('other_office_address[]');
    for (var i = 0; i <other_office_address.length; i++) {
        formData.append('other_office_address[]',other_office_address[i].value);
    }

    var other_home_address=document.getElementsByName('other_home_address[]');
    for (var i = 0; i <other_office_address.length; i++) {
        formData.append('other_home_address[]',other_home_address[i].value);
    }

    var co_name=document.getElementsByName('co_name[]');
    for (var i = 0; i <co_name.length; i++) {
        formData.append('co_name[]',co_name[i].value);
    }

    var co_relationship=document.getElementsByName('co_relationship[]');
    for (var i = 0; i <co_relationship.length; i++) {
        formData.append('co_relationship[]',co_relationship[i].value);
    }

    var co_pan_number=document.getElementsByName('co_pan_number[]');
    for (var i = 0; i <co_pan_number.length; i++) {
        formData.append('co_pan_number[]',co_pan_number[i].value);
    }
    
    formData.append('pancard_image', document.getElementById("pancard_image").files[0]);
    formData.append('adharcard_image', document.getElementById("adharcard_image").files[0]);
    var bar= $('.progress-bar');
    var percent= $('.progress-bar');
    $.ajax({
        type: "POST",
        url: SiteUrl+"profile/update_profile",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (request, xhr) {
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        success: function(response) {
            if(response['status']=="success"){
                window.location.href=SiteUrl+"profile";
            }else{
                //$('#lender_otp_errorr').html('Failure');
            }
        },
        xhr: function(){
             var xhr = $.ajaxSettings.xhr() ;
             xhr.upload.onprogress = function(data){
                var perc = Math.round((data.loaded / data.total) * 100);
                $('.progress-bar').text(perc + '%');
                $('.progress-bar').css('width',perc + '%');
             };
             return xhr ;
        },
    });
}

function AddMoreDirectorPartner(){
    var html='<div><hr class="text-primary">'+
        '<button type="button" onclick="DeleteRow(this)" class="btn btn-danger float-right mt-2">Delete</button>'+
        '<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<input class="multisteps-form__input form-control" name="other_pannumber[]" type="text" placeholder="Pan" />'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<input class="multisteps-form__input form-control" name="other_phone_number[]" type="text" placeholder="Phone number" />'+
            '</div>'+
        '</div>'+
        '<div class="form-row mt-1">'+
            '<div class="col">'+
                '<input class="multisteps-form__input form-control" name="other_office_address[]" type="text" placeholder="Office Address" />'+
            '</div>'+
        '</div>'+
        '<div class="form-row mt-2">'+
            '<div class="col">'+
                '<input class="multisteps-form__input form-control" name="other_home_address[]" type="text" placeholder="Home Address" />'+
            '</div>'+
        '</div></div>'
    $('#add_more_html').append(html);
}
function CheckDPBtn(value){
    if(value=='Proprietor'){
        $('#add_director_partner_btn').hide();
        $('#change_partner_type_text').html('<h5>Proprietor</h5>');
        var html='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<input class="multisteps-form__input form-control" name="other_pannumber[]" type="text" placeholder="Pan" />'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<input class="multisteps-form__input form-control" name="other_phone_number[]" type="text" placeholder="Phone number" />'+
            '</div>'+
        '</div>'+
        '<div class="form-row mt-1">'+
            '<div class="col">'+
                '<input class="multisteps-form__input form-control" name="other_office_address[]" type="text" placeholder="Office Address" />'+
            '</div>'+
        '</div>'+
        '<div class="form-row mt-2">'+
            '<div class="col">'+
                '<input class="multisteps-form__input form-control" name="other_home_address[]" type="text" placeholder="Home Address" />'+
            '</div>'+
        '</div>'
        $('#add_more_html').html('');
        $('#add_more_html').append(html);
    }else{
        if(value=="Partnership"){
            $('#change_partner_type_text').html('<h5>Partner KYC</h5>');
        }else{
            $('#change_partner_type_text').html('<h5>Director KYC</h5>'); 
        }
        $('#add_director_partner_btn').show();
    }
}
function AddCoApplicant(){
    var html='<div><hr>'+
    '<button type="button" onclick="DeleteRow(this)" class="btn btn-danger float-right mt-2">Delete</button>'+
    '<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
        '<input class="multisteps-form__input form-control" type="text" name="co_name[]" placeholder="Name"/>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
        '<input class="multisteps-form__input form-control" type="text" name="co_relationship[]" placeholder="Relationship"/>'+
        '</div>'+
    '</div>'+
    '<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
        '<input class="multisteps-form__input form-control" name="co_pan_number[]" type="text" placeholder="Pan"/>'+
        '</div>'+
    '</div></div>';
    $('#add_co_applicant').append(html);
}

function readPancardURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#pancard_image_src').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function readAdharcardURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#adhar_image_src').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#pancard_image").change(function(){
    $('#showpanimage').html('<img id="pancard_image_src" src="">');
    readPancardURL(this);
});
$("#adharcard_image").change(function(){
    $('#showadharimage').html('<img id="adhar_image_src" src="">');
    readAdharcardURL(this);
});
function DeleteRow(e){
    e.parentNode.parentNode.removeChild(e.parentNode);
}

</script>