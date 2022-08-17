function SubmitDsaForm(){
    
    $('#dsa_company_name_error').html('');
    $('#dsa_username_error').html('');
    $('#dsa_doc_error').html('');
    $('#dsa_full_name_error').html('');
    $('#dsa_address_error').html('');
    $('#dsa_mobile_numbere_error').html('');
    $('#dsa_email_error').html('');
    $('#dsa_password_error').html('');
    $('#dsa_cpassword_error').html('');
    
    var username=  $('#dsa_username').val().trim();
    if(username==""){
       $('#dsa_username_error').html('The Trade Name field is required');
       document.getElementById("dsa_username_error").scrollIntoView();
       return false;
    }else{
        var validate= TradeNameValidate(username);
        if(!validate){
            $('#dsa_username_error').html('Please Enter Only Alphabets and Dash');
            document.getElementById("dsa_username_error").scrollIntoView();
            return false;
        }
    }

    var company_name=  $('#dsa_company_name').val();
    if(company_name==""){
       $('#dsa_company_name_error').html('The Company Name field is required');
       document.getElementById("dsa_company_name_error").scrollIntoView();
       return false;
    }
    
     var full_name=  $('#dsa_full_name').val();
    if(full_name==""){
       $('#dsa_full_name_error').html('The Person Name field is required');
       document.getElementById("dsa_full_name_error").scrollIntoView();
       return false;
    }
    var address=  $('#dsa_address').val();
    if(address==""){
       $('#dsa_address_error').html('The Address Field is required');
       document.getElementById("dsa_address_error").scrollIntoView();
       return false;
    }
    
    var mobile_number=  $('#dsa_mobile_number').val().trim();
    if(mobile_number==""){
       $('#dsa_mobile_numbere_error').html('The Mobile Number field is required');
       document.getElementById("dsa_mobile_numbere_error").scrollIntoView();
       return false;
    }else{
       var validatenum= DsaMobileValidate();
       if(!validatenum){
        $('#dsa_mobile_numbere_error').html('Please Enter Correct Mobile Number');
        document.getElementById("dsa_mobile_numbere_error").scrollIntoView();
        return false;
       }
    }
     var email=  $('#dsa_email').val().trim();
    if(email==""){
       $('#dsa_email_error').html('The Email field is required');
       document.getElementById("dsa_email_error").scrollIntoView();
       return false;
    }
    var gst_number=  $('#dsa_gst_number').val();
    $('#dsa_gst_number_error').html('');
    if(gst_number==""){
        $('#dsa_gst_number_error').html('The PAN/GST number is Required');
        document.getElementById("dsa_gst_number_error").scrollIntoView();
        return false;
    }else{
        if(gst_number.length==10){
            var valid = ValidatePAN(gst_number);
            if(!valid){
                $('#dsa_gst_number_error').html('Plese Enter Valid PAN Number');
                document.getElementById("dsa_gst_number_error").scrollIntoView();
                return false;
            }
        }else if(gst_number.length==15){
            var valid = GstValidate(gst_number);
            if(!valid){
                $('#dsa_gst_number_error').html('Plese Enter Valid GST Number');
                document.getElementById("dsa_gst_number_error").scrollIntoView();
                return false;
            }
        }else{
            $('#dsa_gst_number_error').html('Invalid PAN/GST Number');
            document.getElementById("dsa_gst_number_error").scrollIntoView();
            return false;
        }
    }
    var dsa_password=$('#dsa_password').val();
    if(dsa_password==""){
        $('#dsa_password_error').html('The Password field is required');
        document.getElementById("dsa_password_error").scrollIntoView();
        return false;
    }
    var dsa_cpassword=$('#dsa_cpassword').val();
    if(dsa_cpassword==""){
        $('#dsa_cpassword_error').html('The Confirm Password field is required');
        document.getElementById("dsa_cpassword_error").scrollIntoView();
        return false;
    }else if(dsa_cpassword!=dsa_password){
        $('#dsa_cpassword_error').html('Password And Confirm Password Not Match');
        document.getElementById("dsa_cpassword_error").scrollIntoView();
        return false;
    }
    var dsa_document=$('[name="dsa_document[]"]');
    if(dsa_document.length==0){
        $('#dsa_doc_error').html('Required document not uploaded');
        document.getElementById("dsa_doc_error").scrollIntoView();
        return false;
    }else{
        iserror=true;
        dsa_document.each(function(){
            var ext = $(this).val().split('@kk@').pop().toLowerCase();
            if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                $('#dsa_doc_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                document.getElementById("dsa_doc_error").scrollIntoView();
                iserror=false;
                return false;
            }
        });
        if(iserror==false){
            return false;
        }
    }
    var ajax0=$.ajax({
        url: SiteUrl+"/ajax/validate_username",
        method:'POST',
        dataType:"json",
        data:{"username":username},
        success: function(result){
            if(result.status=="fail"){
                $('#dsa_username_error').html(result.message);
                document.getElementById("dsa_username_error").scrollIntoView();
               return false;
            }                 
        }
    });

    var ajax1=$.ajax({
        url: SiteUrl+"/ajax/dsa_mobile_number",
        method:'POST',
        dataType:"json",
        data:{"mobile_number":mobile_number},
        success: function(result){
            if(result.status=="fail"){
                $('#dsa_mobile_numbere_error').html(result.message);
                document.getElementById("dsa_mobile_numbere_error").scrollIntoView();
               return false;
            }                 
        }
    });
   
    var ajax2=$.ajax({
        url: SiteUrl+"/ajax/dsa_email",
        method:'POST',
        dataType:"json",
        data:{"email":email},
        success: function(result){
            if(result.status=="fail"){
                $('#dsa_email_error').html(result.message);
                document.getElementById("dsa_email_error").scrollIntoView();
               return false;
            }                 
        }
    });
    
    $.when( ajax0,ajax1, ajax2, ).done(function (v0, v1, v2) {
        if(v0[0].status=='success' && v1[0].status=='success' && v2[0].status=='success'){
            /* $.ajax({
                url: SiteUrl+"/ajax/send_dsa_otp",
                method:'POST',
                dataType:"json",
                data:{"mobile_number":mobile_number},
                success: function(result){
                    $('#OpenOtpModel').modal('show');   
                }
            }); */
            DsaRegistration();
        }
    });
}
function TradeNameValidate(value){
    var regexp = /^[a-zA-Z-]+$/;
    if (value.search(regexp) === -1)
    { return false; }
    else
    { return true }
}
function SubmitOtp(){
    var otp=$('#dsa_otp').val();
     $('#dsa_otp_errorr').html('');
    if(otp==""){
        $('#dsa_otp_errorr').html('Invalid Otp');
       return false;
    }else{
        
       var mobile_number=  $('#dsa_mobile_number').val();
        $.ajax({
            url: SiteUrl+"/ajax/dsa_verify_otp",
            method:'POST',
            dataType:"json",
            data:{"mobile_number":mobile_number,'otp':otp},
            success: function(result){
               if(result.status=="success"){
                   DsaRegistration();
               }else{
                  $('#dsa_otp_errorr').html('Invalid Otp');
                    return false;
               }
            }
        });
    }
}
function DsaRegistration(){
    $('#dsa_loader').html('<div class="spinner-border text-white" style="height:17px;width:17px;" role="status"><span class="sr-only">Loading...</span></div>');
     var formData = new FormData();
    formData.append('company_name', $('#dsa_company_name').val());
    formData.append('full_name', $('#dsa_full_name').val());
    formData.append('mobile_number', $('#dsa_mobile_number').val().trim());
    formData.append('address', $('#dsa_address').val());
    formData.append('email', $('#dsa_email').val().trim());
    formData.append('gst_number', $('#dsa_gst_number').val());
    formData.append('website', $('#dsa_website').val());
    formData.append('password', $('#dsa_password').val().trim());
    formData.append('username', $('#dsa_username').val());

    var dsa_document=document.getElementsByName('dsa_document[]');
    for (var i = 0; i <dsa_document.length; i++) {
        formData.append('dsa_document[]',dsa_document[i].value);
    }
    $.ajax({
        type: "POST",
        url: SiteUrl+"/ajax/dsa_registration",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
           if(response['status']=="success"){
                //$('#OpenOtpModel').modal('hide');
                $('#success_message').html('Registration Successful. Your password is '+$('#dsa_password').val());
                document.getElementById("success_message").scrollIntoView();
                setInterval(function () {
                    window.location.href=SiteUrl+"login";
                },5000);
           }else{
                $('#dsa_otp_errorr').html('Registration Failure');
           }
        }
    });
}
function SubmitLenderForm(){
    $('#company_name_error').html('');
    $('#full_name_error').html('');
    $('#address_error').html('');
    $('#mobile_number_error').html('');
    $('#email_error').html('');
    $('#gst_number_error').html('');
    $('#password_error').html('');
    $('#cpassword_error').html('');
    
    var company_name=  $('#company_name').val();
    if(company_name==""){
       $('#company_name_error').html('The Company Name field is required');
       document.getElementById("company_name_error").scrollIntoView();
       return false;
    }
    
     var full_name=  $('#full_name').val();
    if(full_name==""){
       $('#full_name_error').html('The Person Name field is required');
       document.getElementById("full_name_error").scrollIntoView();
       return false;
    }
    var address=  $('#address').val();
    if(address==""){
       $('#address_error').html('The Address field is required');
       document.getElementById("address_error").scrollIntoView();
       return false;
    }
    var gst_number=  $('#gst_number').val();
    if(gst_number!=""){
        if($('#gst_number').val().length!=15){
            $('#gst_number_error').html('Invalid GST Number Provided');
            document.getElementById("gst_number_error").scrollIntoView();
            return false;
        }
    }   
    var mobile_number=  $('#mobile_number').val().trim();
    if(mobile_number==""){
       $('#mobile_number_error').html('The Mobile Number field is required');
       document.getElementById("mobile_number_error").scrollIntoView();
       return false;
    }else{
        var validate=LenderMobileValidate();
        if(!validate){
            $('#mobile_number_error').html('Plesae Enter Correct Mobile Number');
            document.getElementById("mobile_number_error").scrollIntoView();
            return false;
        }
    }
    var email=  $('#email').val().trim();
    if(email==""){
       $('#email_error').html('The Email field is required');
       document.getElementById("email_error").scrollIntoView();
       return false;
    }
    var password=$('#password').val().trim();
    if(password==""){
        $('#password_error').html('The Password field is required');
        document.getElementById("password_error").scrollIntoView();
        return false;
    }
    var cpassword=$('#confirm_password').val();
    if(cpassword==""){
        $('#cpassword_error').html('The Confirm Password field is required');
        document.getElementById("cpassword_error").scrollIntoView();
        return false;
    }else if(cpassword!=password){
        $('#cpassword_error').html('Password And Confirm Password Not Match');
        document.getElementById("cpassword_error").scrollIntoView();
        return false;
    }
    var ajax1=$.ajax({
        url: SiteUrl+"/ajax/lender_mobile_number",
        method:'POST',
        dataType:"json",
        data:{"mobile_number":mobile_number},
        success: function(result){
            if(result.status=="fail"){
                $('#mobile_number_error').html(result.message);
                document.getElementById("mobile_number_error").scrollIntoView();
               return false;
            }                 
        }
    });
   
    var ajax2=$.ajax({
        url: SiteUrl+"/ajax/lender_email",
        method:'POST',
        dataType:"json",
        data:{"email":email},
        success: function(result){
            if(result.status=="fail"){
                $('#email_error').html(result.message);
                document.getElementById("email_error").scrollIntoView();
               return false;
            }                 
        }
    });
    
    $.when( ajax1, ajax2, ).done(function ( v1, v2) {
        if($('#email_error').html()=="" && $('#mobile_number_error').html()==""){
            /* $.ajax({
                url: SiteUrl+"/ajax/send_lender_otp",
                method:'POST',
                dataType:"json",
                data:{"mobile_number":mobile_number},
                success: function(result){
                    $('#OpenLenderOtpModel').modal('show');   
                }
            }); */
            LenderRegistration();
        }
    });
}
function SubmitLenderOtp(){
    var otp=$('#lender_otp').val();
    $('#lender_otp_errorr').html('');
    if(otp==""){
        $('#lender_otp_errorr').html('Invalid Otp');
       return false;
    }else{
        
       var mobile_number=  $('#mobile_number').val();
        $.ajax({
            url: SiteUrl+"/ajax/lender_verify_otp",
            method:'POST',
            dataType:"json",
            data:{"mobile_number":mobile_number,'otp':otp},
            success: function(result){
               if(result.status=="success"){
                   LenderRegistration();
               }else{
                  $('#lender_otp_errorr').html('Invalid Otp');
                    return false;
               }
            }
        });
    }
}
function LenderRegistration(){
    $('#lender_loader').html('<div class="spinner-border text-white" style="height:17px;width:17px;" role="status"><span class="sr-only">Loading...</span></div>');
    var formData = new FormData();
    formData.append('company_name', $('#company_name').val());
    formData.append('full_name', $('#full_name').val());
    formData.append('mobile_number', $('#mobile_number').val().trim());
    formData.append('address', $('#address').val());
    formData.append('email', $('#email').val().trim());
    formData.append('gst_number', $('#gst_number').val());
    formData.append('password', $('#password').val());
    $.ajax({
        type: "POST",
        url: SiteUrl+"/ajax/lender_registration",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response['status']=="success"){
                $('#OpenOtpModel').modal('hide');
                $('#success_message').html('Registration Successful. You password is '+$('#password').val());
                document.getElementById("success_message").scrollIntoView();
                setInterval(function () {
                    window.location.href=SiteUrl+"login";
                },5000);
           }else{
                $('#lender_otp_errorr').html('Registration Failure');
           }
        }
    });
}
function GstValidate(g){
    let regTest = /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/.test(g)
     if(regTest){
        let a=65,b=55,c=36;let p;
        return Array['from'](g).reduce((i,j,k,g)=>{ 
           p=(p=(j.charCodeAt(0)<a?parseInt(j):j.charCodeAt(0)-b)*(k%2+1))>c?1+(p-c):p;
           return k<14?i+p:j==((c=(c-(i%c)))<10?c:String.fromCharCode(c+b));
        },0); 
    }
    return regTest
}

function DsaMobileValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('dsa_mobile_number');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
function LenderMobileValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('mobile_number');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
function ReadFile(image){
    /* var ext = $('#dsa_doc').val().split('.').pop().toLowerCase();
    if(ext=='pdf' || ext=="doc" || ext=='docx'){
        $('#uploaded_image').html('<div>'+file.files[0].name+' view not available</div>');
    }else{
        $('#uploaded_image').html('<img src="#"  onclick="ShowLargeImage(this.src)" id="blash" style="width:30%;">');
        readURL(file);
    } */
    for(var i=0;i<image.files.length;i++){
        $('#uploaded_image').addClass('quote-imgs-thumbs');
        var extension = image.files[i].name.split('.').pop().toLowerCase()
        if(extension=='doc' || extension=='pdf' || extension=='docx'){
            var randid=new Date().getUTCMilliseconds();
            $('#uploaded_image').append('<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" ><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+'</a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`uploaded_image`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'" name="dsa_document[]"></div>');
            convertToBase64(image.files[i],randid);
        }else if(extension=='png' || extension=='jpg' || extension=='jpeg'){
            var randid=new Date().getUTCMilliseconds();
            $('#uploaded_image').append('<div class="m-2"><a href="javascript:void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" id="'+randid+'"></a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`uploaded_image`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'image" name="dsa_document[]"></div></div>');
            readURL(image.files[i],randid);
        }else{
            var randid=new Date().getUTCMilliseconds();
            $('#uploaded_image').append('<div class="m-2 img-preview-thumb"><a href="javascript:void(0)" ><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+'</a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`uploaded_image`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'" name="dsa_document[]"></div>');
            convertToBase64(image.files[i],randid);
        }
    }
    document.getElementById(image.id).value=null;
    
}
function RemoveFile(elem,parentid){
    $(elem).parent('div').remove();
    var html = $('#'+parentid).html();
    if(html.trim()==""){
        $('#'+parentid).removeClass('quote-imgs-thumbs');
    }
}
function ShowLargeImage(image){
    $('#to-large-image').attr('src',image);
    $('#LargeImageModel').modal('show');
}
function readURL(input,imageid) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#'+imageid).attr('src', e.target.result);
        $('#'+imageid+'image').attr('value', e.target.result+'@kk@'+input.name.split('.').pop().toLowerCase());
    }
    reader.readAsDataURL(input);
}
function convertToBase64(fileToLoad,randid) {
    var fileReader = new FileReader();
    var base64;
    fileReader.onload = function(fileLoadedEvent) {
        $('#'+randid).attr('value',fileLoadedEvent.target.result+'@kk@'+fileToLoad.name.split('.').pop().toLowerCase());
    };
    fileReader.readAsDataURL(fileToLoad);
}
function ValidatePAN(val) { 
    var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
    if (val.search(panPat) == -1) {
        return false;
    }
    return true;
}