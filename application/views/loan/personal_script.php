<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
"use strict";
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	animating = true;
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
    var currentid=$(this).attr('id');
    if(currentid=='next-1'){
        $('.invalid').html('');
        $('#number_of_kid_error').html('');
        if($('#father_name').val()==''){
            $('#father_name').siblings(".invalid").html("The Father's Name Field is Required");
            document.getElementById("father_name_error").scrollIntoView();
            return false;
        }
        if($('#date_of_birth').val()==''){
            $('#date_of_birth').siblings(".invalid").html("The DOB Field is Required");
            document.getElementById("date_of_birth_error").scrollIntoView();
            return false;
        }
        if($('#gender').val()==''){
            $('#gender').siblings(".invalid").html("The Gender Field is Required");
            document.getElementById("gender_error").scrollIntoView();
            return false;
        } 
        if($('#qualification').val()==''){
            $('#qualification').siblings(".invalid").html("The Qualification Field is Required");
            document.getElementById("qualification_error").scrollIntoView();
            return false;
        }
        if($('#marital_status').val()==''){
            $('#marital_status').siblings(".invalid").html("The Marital Status Field is Required");
            document.getElementById("marital_status_error").scrollIntoView();
            return false;
        }
        if($('#number_of_kids').val()==''){
            $('#number_of_kid_error').html("The Number of Kid's Field is Required");
            document.getElementById("number_of_kid_error").scrollIntoView();
            return false;
        }else if($('#number_of_kids').val()<0){
            $('#number_of_kid_error').html("Please Enter Number of Kid's between 0 or greater");
            document.getElementById("number_of_kid_error").scrollIntoView();
            return false;
        }
        if($('#vehicle_type').val()==''){
            $('#vehicle_type').siblings(".invalid").html("The Vehicle Type Field is Required");
            document.getElementById("vehicle_type_error").scrollIntoView();
            return false;
        }
		nextstep();
    }else if(currentid=='next-2'){
        $('.invalid').html('');
        if($('#employer_name').val()==''){
            $('#employer_name').siblings(".invalid").html("The Name of current employer Field is Required");
            document.getElementById("employer_name_error").scrollIntoView();
            return false;
        }
        if($('#designation').val()==''){
            $('#designation').siblings(".invalid").html("The Designation Field is Required");
            document.getElementById("designation_error").scrollIntoView();
            return false;
        }
        if($('#organization').val()==''){
            $('#organization').siblings(".invalid").html("The No. of years in current organization Field is Required");
            document.getElementById("organization_error").scrollIntoView();
            return false;
        }
        if($('#organization_type').val()==''){
            $('#organization_type').siblings(".invalid").html("The Organization Type Field is Required");
            document.getElementById("organization_type_error").scrollIntoView();
            return false;
        }
        
        if($('#total_experience').val()==''){
            $('#total_experience').siblings(".invalid").html("The Total Experience Field is Required");
            document.getElementById("total_experience_error").scrollIntoView();
            return false;
        }
        if($('#organization_type').val()=='Other'){
            if($('#other_organization').val()==''){
                $('#other_organization').siblings(".invalid").html("The Other Organization Field is Required");
                document.getElementById("other_organization_error").scrollIntoView();
                return false;
            }
        }
        if($('#company_building').val()==''){
            $('#company_building').siblings(".invalid").html("The Building No./Plot No. Field is Required");
            document.getElementById("company_building_error").scrollIntoView();
            return false;
        }
        if($('#company_area').val()==''){
            $('#company_area').siblings(".invalid").html("The Company Area Field is Required");
            document.getElementById("company_area_error").scrollIntoView();
            return false;
        }
        if($('#company_state').val()==''){
            $('#company_state').siblings(".invalid").html("The State Field is Required");
            document.getElementById("company_state_error").scrollIntoView();
            return false;
        }
        if($('#company_city').val()==''){
            $('#company_city').siblings(".invalid").html("The City Field is Required");
            document.getElementById("company_city_error").scrollIntoView();
            return false;
        }else{
            if($('#company_city').val()=='Other'){
                if($('#company_other_city').val()==""){
                    $('#company_other_city').siblings(".invalid").html("The Other City Field is Required");
                    document.getElementById("company_other_city_error").scrollIntoView();
                    return false;
                }
            }
        }
        if($('#company_email').val()==''){
            $('#company_email').siblings(".invalid").html("The Official Email Address Field is Required");
            document.getElementById("company_email_error").scrollIntoView();
            return false;
        }else{
            var valid= validateEmail($('#company_email').val());
            if(!valid){
                $('#company_email').siblings(".invalid").html("Please Enter Valid Email Address");
                document.getElementById("company_email_error").scrollIntoView();
                return false;
            }
        }
        if($('#company_pincode').val()==''){
            $('#company_pincode').siblings(".invalid").html("The Pincode Field is Required");
            document.getElementById("company_pincode_error").scrollIntoView();
            return false;
        }else{
            if($('#company_pincode').val()=='Other'){
                if($('#company_other_pincode').val()==''){
                    $('#company_other_pincode').siblings(".invalid").html("Company Other Pincode field is Required");
                    document.getElementById("company_other_pincode_error").scrollIntoView();
                    return false;
                }else{
                    var valid=PincodeValidation($('#company_other_pincode').val());
                    if(!valid){
                        $('#company_other_pincode').siblings(".invalid").html("Please Enter Valid Pincode");
                        document.getElementById("company_other_pincode_error").scrollIntoView();
                        return false;
                    }
                }
            }
        }

        $.ajax({
            url: SiteUrl+"ajax/checkAddressError",
            dataType:"json",
            method:'POST',
            data:{
                'city':$('#company_city').val(),
                'pincode':$('#company_pincode').val(),
                'state':$('#company_state').val()
            },
            success:function(response){
                if(response.status=='fail' && $('#company_city').val()!='Other'){
                    if(response.city_error!=""){
                        $('#company_city').siblings(".invalid").html(response.city_error);
                        document.getElementById("company_city_error").scrollIntoView();
                        return false;
                    }
                    if(response.pincode_error && $('#company_pincode').val()!='Other'){
                        $('#company_pincode').siblings(".invalid").html(response.pincode_error);
                        document.getElementById("company_pincode_error").scrollIntoView();
                        return false;
                    }
                }
                
                nextstep();
            }
        });
        
    } else if(currentid=='next-3'){
        $('.invalid').html('');
        if($('#salery_inhand').val()==''){
            $('#salery_inhand').siblings(".invalid").html("The Monthly Take Home Field is Required");
            document.getElementById("salery_inhand_error").scrollIntoView();
            return false;
        }
        if($('#salary_mode').val()==''){
            $('#salary_mode').siblings(".invalid").html("The Mode of receiving salary Field is Required");
            document.getElementById("salary_mode_error").scrollIntoView();
            return false;
        }
        nextstep();
    }else if(currentid=='next-4'){
        $('.invalid').html('');
        if($('#residence_building').val()==''){
            $('#residence_building').siblings(".invalid").html("The Flat No./Building No./Street No. Field is Required");
            document.getElementById("residence_building_error").scrollIntoView();
            return false;
        }
        if($('#residence_area').val()==''){
            $('#residence_area').siblings(".invalid").html("Locality/Area Field required");
            document.getElementById("residence_area_error").scrollIntoView();
            return false;
        }
        if($('#residence_state').val()==''){
            $('#residence_state').siblings(".invalid").html("The State Field is Required");
            document.getElementById("residence_state_error").scrollIntoView();
            return false;
        }
        if($('#residence_city').val()==''){
            $('#residence_city').siblings(".invalid").html("The City Field is Required");
            document.getElementById("residence_city_error").scrollIntoView();
            return false;
        }else{
            if($('#residence_city').val()=='Other'){
                if($('#residence_other_city').val()==""){
                    $('#residence_other_city').siblings(".invalid").html("The Other City Field is Required");
                    document.getElementById("residence_other_city_error").scrollIntoView();
                    return false;
                }
            }
        }
        if($('#residence_pincode').val()==''){
            $('#residence_pincode').siblings(".invalid").html("The Pincode Field is Required");
            document.getElementById("residence_pincode_error").scrollIntoView();
            return false;
        }else{
            if($('#residence_pincode').val()=='Other'){
                if($('#residence_other_pincode').val()==""){
                    $('#residence_other_pincode').siblings(".invalid").html("The Other Pincode Field is Required");
                    document.getElementById("residence_other_pincode_error").scrollIntoView();
                    return false;
                }else{
                    var valid=PincodeValidation($('#residence_other_pincode').val());
                    if(!valid){
                        $('#residence_other_pincode').siblings(".invalid").html("Please Enter Valid Pincode");
                        document.getElementById("residence_other_pincode_error").scrollIntoView();
                        return false;
                    }
                }
            }
        }

        $.ajax({
            url: SiteUrl+"ajax/checkAddressError",
            dataType:"json",
            method:'POST',
            data:{
                'city':$('#residence_city').val(),
                'pincode':$('#residence_pincode').val(),
                'state':$('#residence_state').val(),
            },
            success:function(response){
                if(response.status=='fail'){
                    if(response.city_error!="" && $('#residence_pincode').val()!='Other'){
                        $('#residence_city').siblings(".invalid").html(response.city_error);
                        document.getElementById("residence_city_error").scrollIntoView();
                        return false;
                    }
                    if(response.pincode_error && $('#residence_pincode').val()!='Other'){
                        $('#residence_pincode').siblings(".invalid").html(response.pincode_error);
                        document.getElementById("residence_pincode_error").scrollIntoView();
                        return false;
                    }
                }
                if($('#residence_type').val()==''){
                    $('#residence_type').siblings(".invalid").html("The Residence Type Field is Required");
                    document.getElementById("residence_type_error").scrollIntoView();
                    return false;
                }
                if($('#year_at_residence').val()==''){
                    $('#year_at_residence').siblings(".invalid").html("The Number of years at current residence Field is Required");
                    document.getElementById("year_at_residence_error").scrollIntoView();
                    return false;
                }
                UploadPersonalExtraField();
                nextstep();
            }
        });
        
    }else if(currentid=='next-5'){
        $('.invalid').html('');
        $('#pan_image_error').html('');
        $('#bankstatement_error').html('');
        $('#aadhar_image_error').html('');
        $('#salery_slip_error').html('');
        if($('#pan_number').val()==""){
            $('#pan_number').siblings(".invalid").html('The Pan Number Field is Required');
            document.getElementById("pan_number_error").scrollIntoView();
            return false;
        }else{
            var validatepan = ValidatePAN($('#pan_number').val());
            if(!validatepan){
                $('#pan_number').siblings(".invalid").html('Please Enter Valid Pan Number');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }
        }
        var pancard_image=$('[name="base_pancard_[]"]');
        if(pancard_image.length==0){
            $('#pan_image_error').html('Required document not uploaded');
            document.getElementById("pan_image_error").scrollIntoView();
            return false;
        }else{
            var iserror=true;
            pancard_image.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                    $('#pan_image_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                    document.getElementById("pan_image_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        if($('#aadhar_number').val()==""){
            $('#aadhar_number').siblings(".invalid").html('Please Enter Aadhar Number');
             document.getElementById("aadhar_number_error").scrollIntoView();
            return false;
        }
        var aadharcard_image=$('[name="base_aadharcard_[]"]');
        if(aadharcard_image.length==0){
            $('#aadhar_image_error').html('Required document not uploaded');
            document.getElementById("aadhar_image_error").scrollIntoView();
            return false;
        }else{
            var iserror=true;
            aadharcard_image.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                    $('#aadhar_image_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                    document.getElementById("aadhar_image_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        var base_residence_address_proof_=$('[name="base_residence_address_proof_[]"]');
        if(base_residence_address_proof_.length==0){
            $('#redsidence_proof_error').html('Required document not uploaded');
            document.getElementById("redsidence_proof_error").scrollIntoView();
            return false;
        }else{
            var iserror=true;
            base_residence_address_proof_.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                    $('#redsidence_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                    document.getElementById("redsidence_proof_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        var salerysip_image=$('[name="base_salery_slip_[]"]');
        if(salerysip_image.length==0){
            $('#salery_slip_error').html('Required document not uploaded');
            document.getElementById("salery_slip_error").scrollIntoView();
            return false;
        }else{
            var iserror=true;
            salerysip_image.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['pdf']) == -1) {
                    $('#salery_slip_error').html('Only pdf file Allowed');
                    document.getElementById("salery_slip_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        var bankstatement=$('[name="base_bankstatement_[]"]');
        if(bankstatement.length==0){
            $('#bankstatement_error').html('Required document not uploaded');
            document.getElementById("bankstatement_error").scrollIntoView();
            return false;
        }else{
            var iserror=true;
            bankstatement.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['pdf']) == -1) {
                    $('#bankstatement_error').html('Only pdf file Allowed');
                    document.getElementById("bankstatement_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        var base_itr_=$('[name="base_itr_[]"]');
        if(base_itr_.length>0){
            var iserror=true;
            base_itr_.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                    $('#itr_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                    document.getElementById("itr_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        var base_cheque_=$('[name="base_cheque_[]"]');
        if(base_cheque_.length>0){
            var iserror=true;
            base_cheque_.each(function(){
                var ext = $(this).val().split('@kk@').pop().toLowerCase();
                if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                    $('#cheque_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                    document.getElementById("cheque_error").scrollIntoView();
                    iserror=false;
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
        }
        
        UploadFile();
        //nextstep();
    }else if(currentid=='next-6'){
        $('#reference_error').html('');
        $('#refernece_number_error').html('');
        if($('#reference').val()==""){
            $('#reference_error').html('The Refrence Name Field is Required');
            return false;
        }
        if($('#reference_number').val()==""){
            $('#refernece_number_error').html('The Refrence Number Field is Required');
            return false;
        }else{
            var validate =ReferenceValidate();
            if(!validate){
                $('#refernece_number_error').html('Pease Enter Valid Mobile Number');
                return false;
            }
        }
        personal_data();
    }else{ 
        nextstep();
    }
});
function UploadFile(){
    var html='<div class="progress" style="height: 40px;">'+
            '<div style="font-size: 30px;" class="documentbar progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">'+
                '0%'+
            '</div>'+
            '<div id="status"></div>'+
        '</div>';
    $('#showdocumentbar').html(html);
    var formData = new FormData();
    formData.append('mobile_number',$('#phone').val());
    formData.append('pan_number',$('#pan_number').val());
    formData.append('aadhar_number',$('#aadhar_number').val());
    formData.append('bankstatement_password',$('#bankstatement_password').val());
    var base_pancard_=document.getElementsByName('base_pancard_[]');
    for (var i = 0; i <base_pancard_.length; i++) {
        formData.append('base_pancard_[]',base_pancard_[i].value);
    }
    var base_aadharcard_=document.getElementsByName('base_aadharcard_[]');
    for (var i = 0; i <base_aadharcard_.length; i++) {
        formData.append('base_aadharcard_[]',base_aadharcard_[i].value);
    }
    var base_residence_address_proof_=document.getElementsByName('base_residence_address_proof_[]');
    for (var i = 0; i <base_residence_address_proof_.length; i++) {
        formData.append('base_residence_address_proof_[]',base_residence_address_proof_[i].value);
    }
    var base_salery_slip_=document.getElementsByName('base_salery_slip_[]');
    for (var i = 0; i <base_salery_slip_.length; i++) {
        formData.append('base_salery_slip_[]',base_salery_slip_[i].value);
    }
    var base_bankstatement_=document.getElementsByName('base_bankstatement_[]');
    for (var i = 0; i <base_bankstatement_.length; i++) {
        formData.append('base_bankstatement_[]',base_bankstatement_[i].value);
    }
    var base_itr_=document.getElementsByName('base_itr_[]');
    for (var i = 0; i <base_itr_.length; i++) {
        formData.append('base_itr_[]',base_itr_[i].value);
    }
    var base_cheque_=document.getElementsByName('base_cheque_[]');
    for (var i = 0; i <base_cheque_.length; i++) {
        formData.append('base_cheque_[]',base_itr_[i].value);
    }
    
    var bar= $('.documentbar');
    var percent= $('.documentbar');
    $.ajax({
        type: "POST",
        url: SiteUrl+"/ajax/personalDocuments",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (request, xhr) {
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            nextstep();
        },
        success: function(response) {
            setTimeout(function(){ 
                $('#showdocumentbar').html('');              
            }, 2000);
            
        },
        xhr: function(){
             var xhr = $.ajaxSettings.xhr() ;
             xhr.upload.onprogress = function(data){
                var perc = Math.round((data.loaded / data.total) * 100);
                $('.documentbar').text(perc + '%');
                $('.documentbar').css('width',perc + '%');
             };
             return xhr ;
        },
    });
}

function ReferenceValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('reference_number');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
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
 
$("fieldset").delegate(".removeOrder", "click", function () {  
    $(this).closest('.card').remove();
  }
);  

$(function() {
$('input[name="birthday"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1930,
    autoUpdateInput: false,
  });
});
$('input[name="birthday"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY'));
    AutoSave('date_of_birth',picker.startDate.format('MM/DD/YYYY'));
});

$('input[name="birthday"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});
function convertToBase64(fileToLoad,randid) {
    var fileReader = new FileReader();
    var base64;
    fileReader.onload = function(fileLoadedEvent) {
        $('#'+randid).attr('value',fileLoadedEvent.target.result+'@kk@'+fileToLoad.name.split('.').pop().toLowerCase());
    };
    fileReader.readAsDataURL(fileToLoad);
}
function readURL(input,imageid) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#'+imageid).attr('src', e.target.result);
        $('#'+imageid+'image').attr('value', e.target.result+'@kk@'+input.name.split('.').pop().toLowerCase());
    }
    reader.readAsDataURL(input);
}
function ShowSelectImage(image,classid,class_add=""){
    for(var i=0;i<image.files.length;i++){
        $('#'+classid).addClass('quote-imgs-thumbs');
        var extension = image.files[i].name.split('.').pop().toLowerCase()
        if(extension=='doc' || extension=='pdf' || extension=='docx'){
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" ><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+'</a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`'+classid+'`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'" name="'+class_add+'[]"></div>');
            convertToBase64(image.files[i],randid);
        }else if(extension=='png' || extension=='jpg' || extension=='jpeg'){
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2"><a href="javascript:void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" id="'+randid+'"></a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`'+classid+'`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'image" name="'+class_add+'[]"></div></div>');
            readURL(image.files[i],randid);
        }else{
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" ><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+'</a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`'+classid+'`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'" name="'+class_add+'[]"></div>');
            convertToBase64(image.files[i],randid);
        }
    }
    document.getElementById(image.id).value=null;
}
function ShowLargeImage(image){
    $('#to-large-image').attr('src',image);
    $('#LargeImageModel').modal('show');
}

function RemoveFile(elem,parentid){
    $(elem).parent('div').remove();
    var html = $('#'+parentid).html();
    if(html.trim()==""){
        $('#'+parentid).removeClass('quote-imgs-thumbs');
    }
}
function nextstep(){
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	next_fs.show(); 
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			scale = 1 - (1 - now) * 0.2;
			left = (now * 50)+"%";
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 200, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		easing: 'easeOutQuint'
	});
}
function personal_data(){
    var html='<div style="height:14px;width:14px;" class="spinner-border text-light" role="status">'+
        '<span class="sr-only">Loading...</span>'+
    '</div>';
    $('#submitloader').html(html);
    $('#next-6').attr('disabled', 'disabled');
    var clearinterval = setInterval(function(){ 
        if($.active==0){
            getsuccess();
            clearInterval(clearinterval);
        }
     }, 100);
}
function getsuccess() {
    var formData = new FormData();
    formData.append('mobile_number',$('#phone').val());
    formData.append('date_of_birth',$('#date_of_birth').val());
    formData.append('reference',$('#reference').val());
    formData.append('reference_number',$('#reference_number').val());
    $.ajax({
        type: "POST",
        url: SiteUrl+"/ajax/PersonalRegistration",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (request, xhr) {
            
        },
        success: function(response) {
            $('#SuccessModel').modal('show');
        },
        xhr: function(){
             var xhr = $.ajaxSettings.xhr() ;
             xhr.upload.onprogress = function(data){
               
             };
             return xhr ;
        },
    });
}
function AutoSave(key,value){
    $.ajax({
        type: "POST",
        url: SiteUrl+"/ajax/PersonalAutoSave",
        data: {
            'key':key,
            'value':value,
            'mobile_number':$('#phone').val()
        },
        success: function(response) {
            
        }
    });
}
function PincodeValidation(val){
    var pinvalid=/^\d{6}$/;
    if (val.search(pinvalid) == -1) {
        return false;
    }
    return true;
}
function validateEmail(value){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(value) == false) 
    {
        return false;
    }
    return true;
}
function ValidatePAN(val) { 
    var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
    if (val.search(panPat) == -1) {
        return false;
    }
    return true;
}
function OtherOrganization(value){
    if(value=='Other'){
        var html='<div class="md-input" >'+
                '<input class="multisteps-form__input form-control" id="other_organization" onkeyup="AutoSave(this.id,this.value)" type="text" title="Other organization" required="">'+
                '<label>Other organization</label>'+
                '<small class="text-danger invalid" id="other_organization_error"></small></div>';
        $('#filed_other_organization').html(html);
    }else{
        $('#filed_other_organization').html('');
    }
}
function UploadPersonalExtraField(){
    var formData= new FormData();
    formData.append('mobile_number',$('#phone').val());
    formData.append('date_of_birth',$('#date_of_birth').val());
    formData.append('employer_name',$('#employer_name').val());
    formData.append('company_pincode',$('#company_pincode').val());
    formData.append('company_state',$('#company_state').val());
    formData.append('company_city',$('#company_city').val());
    formData.append('residence_pincode',$('#residence_pincode').val());
    formData.append('residence_state',$('#residence_state').val());
    formData.append('residence_city',$('#residence_city').val());
    $.ajax({
        type: "POST",
        url: SiteUrl+"/ajax/UploadPersonalExtraField",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            
        }
    });
}
function GetCompanyCityList(state,city=""){
    if(state!=""){
        $.ajax({
            url: SiteUrl+"/ajax/GetCityList",
            method:'POST',
            data:{"state":state,'city':city},
            success: function(result){
                $('#company_city').html(result);
                CompanyCityLabel();
                if($('#company_city').val()==""){
                    $('#company_other_city_field').html('');
                    $('#company_pincode').html('<option value="">Pincode</option><option value="Other">Other</option>');
                    $('#company_other_pincode_field').html('');
                    $('#company_other_city_field').removeClass('mt-4');
                    $('#company_other_pincode_field').removeClass('mt-4');
                    CompanyPincodeLabel();
                }
            }
        });
    }else{
        $('#company_city').html('<option vlaue="">City</option><option value="Other">Other</option>');
        $('#company_other_city_field').html('');
        $('#company_pincode').html('<option value="">Pincode</option><option value="Other">Other</option>');
        $('#company_other_pincode_field').html('');
        $('#company_other_city_field').removeClass('mt-4');
        $('#company_other_pincode_field').removeClass('mt-4');
        CompanyPincodeLabel();
    }
}
function CheckCompanySelectCity(city,pincode=""){
    if(city=='Other'){
        CompanyOtherCity(city);
    }else{
        $('#company_other_city_field').html('');
        $('#company_other_city_field').removeClass('mt-4');
    }
    $('#company_city_error').html('');
    $.ajax({
        url: SiteUrl+"ajax/CheckSelectCity",
        dataType:'json',
        method:'POST',
        data:{
            'city':city,
            'state':$('#company_state').val(),
            'pincode':pincode,
        },
        success: function(response){
            if(response.status=='fail'){
                $('#company_city_error').html('City does not exists in our record.');
                document.getElementById("company_city_error").scrollIntoView();
            }else{
                $('#company_city_error').html('');
            }
            $('#company_pincode').html(response.pincode);
            CompanyPincodeLabel();
            if($('#company_pincode').val()==""){
                $('#company_other_pincode_field').html('');
                $('#company_other_pincode_field').removeClass('mt-4');
            }
        }
    });
}
function CompanyOtherCity(value){
    if(value=='Other'){
        var html='<div class="col-12 col-sm-6">'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="md-input">'+
                '<input class="md-form-control" value="'+$('#company_other_city_hidden').val()+'" id="company_other_city" type="text" onkeyup="AutoSave(this.id,this.value)" required="" title="Other City" />'+
                '<label>Other City</label>'+
                '<small class="text-danger invalid" id="company_other_city_error"></small>'+
            '</div>'+
        '</div>';
        $('#company_other_city_field').addClass('mt-4');
        $('#company_other_city_field').html(html);
    }else{
        $('#company_other_city_field').removeClass('mt-4');
        $('#company_other_city_field').html('');
    }
}
function ResidenceOtherCity(value){
    if(value=='Other'){
        var html='<div class="col-12 col-sm-6">'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="md-input">'+
                '<input class="md-form-control" value="'+$('#residence_other_city_hidden').val()+'" id="residence_other_city" type="text" onkeyup="AutoSave(this.id,this.value)" required="" title="Other City" />'+
                '<label>Other City</label>'+
                '<small class="text-danger invalid" id="residence_other_city_error"></small>'+
            '</div>'+
        '</div>';
        $('#residence_other_city_field').addClass('mt-4');
        $('#residence_other_city_field').html(html);
    }else{
        $('#residence_other_city_field').removeClass('mt-4');
        $('#residence_other_city_field').html('');
    }
}
function CompanyOtherPincode(value){
    if(value=='Other'){
        var html=
            '<div class="md-input">'+
                '<input class="md-form-control" value="'+$('#company_other_pincode_hidden').val()+'" id="company_other_pincode" type="text" oninput="this.value = Math.abs(this.value);" minlength="6" maxlength="6" onkeyup="AutoSave(this.id,this.value)" required="" title="Other Pincode" />'+
                '<label>Other Pincode</label>'+
                '<small class="text-danger invalid" id="company_other_pincode_error"></small>'+
        '</div>';
        $('#company_other_pincode_field').html(html);
    }else{
        $('#company_other_pincode_field').html('');
    }
}
function ResidenceOtherPincode(value){
    if(value=='Other'){
        var html='<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" value="'+$('#residence_other_pincode_hidden').val()+'" id="residence_other_pincode" oninput="this.value = Math.abs(this.value)" type="text" minlength="6" maxlength="6" onkeyup="AutoSave(this.id,this.value)" required="" title="Other Pincode" />'+
                '<label>Other Pincode</label>'+
                '<small class="text-danger invalid" id="residence_other_pincode_error"></small>'+
            '</div>'+
        '</div>';
        $('#residence_other_pincode_field').addClass('mt-4');
        $('#residence_other_pincode_field').html(html);
    }else{
        $('#residence_other_pincode_field').html('');
        $('#residence_other_pincode_field').removeClass('mt-4');
    }
}
function GetResidenceCityList(state,city=""){
    
    if(state!=""){
        $.ajax({
            url: SiteUrl+"/ajax/GetCityList",
            method:'POST',
            data:{"state":state,'city':city},
            success: function(result){
                $('#residence_city').html(result);
                ResidenceCityLabel();
                if($('#residence_city').val()==""){
                    $('#residence_other_city_field').html('');
                    $('#residence_pincode').html('<option value="">Pincode</option><option value="Other">Other</option>');
                    $('#residence_other_pincode_field').html('');
                    $('#residence_other_city_field').removeClass('mt-4');
                    $('#residence_other_pincode_field').removeClass('mt-4');
                    ResidencePincodeLabel();
                }
            }
        });
    }else{
        $('#residence_city').html('<option value="">City</option><option value="Other">Other</option>');
        $('#residence_other_city_field').html('');
        $('#residence_pincode').html('<option value="">Pincode</option><option value="Other">Other</option>');
        $('#residence_other_pincode_field').html('');
        $('#residence_other_city_field').removeClass('mt-4');
        $('#residence_other_pincode_field').removeClass('mt-4');
        ResidencePincodeLabel();
    }
}
function CheckResidenceCityList(city,pincode=""){
    if(city=='Other'){
        ResidenceOtherCity(city);
    }else{
        $('#residence_other_city_field').html('');
        $('#residence_other_city_field').removeClass('mt-4');
    }
    $('#residence_city_error').html('');
    $.ajax({
        url: SiteUrl+"ajax/CheckSelectCity",
        dataType:'json',
        method:'POST',
        data:{
            'city':city,
            'state':$('#residence_state').val(),
            'pincode':pincode
        },
        success: function(response){
            if(response.status=='fail'){
                $('#residence_city_error').html('City does not exists in our record.');
                document.getElementById("residence_city_error").scrollIntoView();
            }else{
                $('#residence_city_error').html('');
            }
            $('#residence_pincode').html(response.pincode);
            ResidencePincodeLabel();
            if($('#residence_pincode').val()==""){
                $('#residence_other_pincode_field').html('');
                $('#residence_other_pincode_field').removeClass('mt-4');
            }
        }
    });
}
function CloseModal(){
    var url = window.location.href;
    var a = url.indexOf("?");
    var b =  url.substring(a);
    var reloadUrl = url.replace(b,"");
    window.location.href=reloadUrl;
}
if($('#company_state').val()!=""){
    GetCompanyCityList($('#company_state').val(),$('#company_city_hidden').val());
    if($('#company_city_hidden').val()!=""){
        CheckCompanySelectCity($('#company_city_hidden').val(),$('#company_pincode_hidden').val());
        if($('#company_pincode_hidden').val()!=''){
            CompanyOtherPincode($('#company_pincode_hidden').val());
        }
    }
}
if($('#residence_state').val()!=""){
    GetResidenceCityList($('#residence_state').val(),$('#residence_city_hidden').val());
    if($('#residence_city_hidden').val()!=""){
        CheckResidenceCityList($('#residence_city_hidden').val(),$('#residence_pincode_hidden').val());
        if($('#residence_city_hidden').val()){
            ResidenceOtherPincode($('#residence_pincode_hidden').val());
        }
    }
}
</script>
