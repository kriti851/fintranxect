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
        $('#employment_type_error').html('');
        var first_name=$('#first_name').val();
        if(first_name==""){
            $('#first_name_error').html('The First Name Field is Required');
            return false;
        }
        var last_name=$('#last_name').val();
        if(last_name==""){
            $('#last_name_error').html('The Last Name Field is Required');
            return false;
        }
        var age=$('#age').val();
        if(age==""){
            $('#age_error').html('The Age Field is Required');
            return false;
        }else if(age>=80){
            $('#age_error').html('Please Enter Correct Age');
            return false;
        }
        var employment_type=$('#employment_type').val();
        if(employment_type==""){
            $('#employment_type_error').html('The Type Of Occupation Field is Required');
            return false;
        }else if(employment_type!="Business"){
            $('#employment_type_error').html('Only Business Option Available');
            return false;
        }

        var email=$('#email').val();
        var ajax1=$.ajax({
            url: SiteUrl+"merchant/email_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"email":email},
            success: function(result){
                if(result.status=="fail"){
                    $('#email_error').html(result.message);
                }              
            }
        });
        var phone=$('#phone').val();
        var validphone = MobileValidate();
        if(!validphone){
            $('#phone_error').html("Please enter valid mobile number");
            return false;
        }
        var ajax2=$.ajax({
            url: SiteUrl+"merchant/phone_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"mobile_number":phone},
            success: function(result){
                if(result.status=="fail"){
                    $('#phone_error').html(result.message);
                }              
            }
        });
        $.when(ajax1,ajax2).done(function(a1, a2){
            if(a1[0].status=="success" && a2[0].status=="success"){
                $.ajax({
                    url: SiteUrl+"merchant/IncompleteForm",
                    method:'POST',
                    cache: false,
                    dataType:"json",
                    data:{"phone":phone,'email':email,'first_name':first_name,'last_name':last_name,'age':age,'employment_type':employment_type,'merchant_id':$('#merchant_id').val()},
                    success: function(result){
                        //$('#merchant_id').val(result.id);  
                        location.reload();       
                    }
                });
            }
        });
    }else if(currentid=='next-2'){
        $('#business_name_error').html('');
        $('#loan_type1_error').html('');
        $('#houseno_error').html('');
        $('#city_error').html('');
        $('#pincode_error').html('');
        $('#state_error').html('');
        $('#vintage_error').html('');
        $('#turn_over_error').html('');
        $('#desired_amount_error').html('');
        $('#type_of_firm_error').html('');
        $('#nature_of_business_error').html('');
        $('#type_of_nature_error').html('');
        $('#partner_number_error').html('');
        $('#director_number_error').html('');
        var business_name=$('#business_name').val();
        if(business_name==""){
            $('#business_name_error').html('The Business Name Field is Required');
            document.getElementById("business_name_error").scrollIntoView();
            return false;
        }
        var loan_type1=$('#loan_type1').val();
        if(loan_type1==""){
            $('#loan_type1_error').html('The Loan Type Field is Required');
            document.getElementById("loan_type1_error").scrollIntoView();
            return false;
        }
        var state=$('#state').val();
        if(state==""){
            $('#state_error').html('The State Field is Required');
            document.getElementById("state_error").scrollIntoView();
            return false;
        }
        var city=$('#city').val();
        if(city==""){
            $('#city_error').html('The City Field is Required');
            document.getElementById("city_error").scrollIntoView();
            return false;
        }else{
            if($('#city').val()=='Other'){
                if($('#other_city').val()==""){
                    $('#other_city_error').html('Other City field is Required');
                    document.getElementById("other_city_error").scrollIntoView();
                    return false;
                }
            }
        }
        var houseno=$('#houseno').val();
        if(houseno==""){
            $('#houseno_error').html('The Flat No./Building No./Street No. Field is Required');
            document.getElementById("houseno_error").scrollIntoView();
            return false;
        }
        var pincode=$('#pincode').val();
        if(pincode==""){
            $('#pincode_error').html('The Pincode Field is Required');
            document.getElementById("pincode_error").scrollIntoView();
            return false;
        }else{
            if($('#pincode').val()=='Other'){
                if($('#other_pincode').val()==""){
                    $('#other_pincode_error').html('Other Pincode field is Required');
                    document.getElementById("other_pincode_error").scrollIntoView();
                    return false;
                }else{
                    var validpincode = PincodeValidation($('#other_pincode').val());
                    if(!validpincode){
                        $('#other_pincode_error').html('Please Enter Valid Pincode');
                        document.getElementById("other_pincode_error").scrollIntoView();
                        return false;
                    }
                }
            }
        }
        $.ajax({
            url: SiteUrl+"merchant/checkAddressError",
            dataType:"json",
            method:'POST',
            data:{
                'city':city,
                'pincode':pincode,
                'state':state,
            },
            success:function(response){
                if(response.status=='fail' && city!='Other'){
                    if(response.city_error!=""){
                        $('#city_error').html(response.city_error);
                        document.getElementById("city_error").scrollIntoView();
                        return false;
                    }
                    if(response.pincode_error && pincode!='Other'){
                        $('#pincode_error').html(response.pincode_error);
                        document.getElementById("pincode_error").scrollIntoView();
                        return false;
                    }
                }
                var type_of_firm=$('#business_type').val();
                if(type_of_firm==""){
                    $('#type_of_firm_error').html('The Type Of Firm Field is Required');
                    document.getElementById("type_of_firm_error").scrollIntoView();
                    return false;
                }
                if(type_of_firm=='Partnership'){
                    var no_of_partner=$('#no_of_partner').val();
                    if(no_of_partner==""){
                        $('#partner_number_error').html('The Number Of Partner Field is Required');
                        document.getElementById("partner_number_error").scrollIntoView();
                        return false;
                    }else{
                        if(no_of_partner<=1){
                            $('#partner_number_error').html('The Number Of Partner Field must be greater than one');
                            document.getElementById("partner_number_error").scrollIntoView();
                            return false;
                        }
                    }
                }else if(type_of_firm=='PVT .ltd'){
                    var no_of_director=$('#no_of_director').val();
                    if(no_of_director==""){
                        $('#director_number_error').html('The Number Of Director Field is Required');
                        document.getElementById("director_number_error").scrollIntoView();
                        return false;
                    }else{
                        if(no_of_director<=1){
                            $('#director_number_error').html('The Number Of Director Field must be greater than one');
                            document.getElementById("director_number_error").scrollIntoView();
                            return false;
                        }
                    }
                }
                var nature_of_business=$('#nature_of_business').val();
                if(nature_of_business==""){
                    $('#nature_of_business_error').html('The Nature Of Business Field is Required');
                    document.getElementById("nature_of_business_error").scrollIntoView();
                    return false;
                }
                var type_of_nature=$('#type_of_nature').val();
                if(type_of_nature==""){
                    $('#type_of_nature_error').html('The Type of '+nature_of_business+' Field is Required');
                    document.getElementById("type_of_nature_error").scrollIntoView();
                    return false;
                }
                var vintage=$('#vintage').val();
                if(vintage==""){
                    $('#vintage_error').html('The No. of years in business Field is Required');
                    document.getElementById("vintage_error").scrollIntoView();
                    return false;
                }else{
                    if(vintage<=0){
                        $('#vintage_error').html('No. of years in business must be greater than Zero');
                        document.getElementById("vintage_error").scrollIntoView();
                        return false;
                    }
                }
                var turn_over=$('#turn_over').val();
                if(turn_over==""){
                    $('#turn_over_error').html('The Turnover Field is Required');
                    document.getElementById("turn_over_error").scrollIntoView();
                    return false;
                }
                var desired_amount=$('#desired_amount').val();
                if(desired_amount==""){
                    $('#desired_amount_error').html('The Desire Amount Field is Required');
                    document.getElementById("desired_amount_error").scrollIntoView();
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
            }
        });
    } else if(currentid=='next-3'){
        $(".other_pan_error").html("");
            $(".invalid").html("");
            var co_name = $('[name="co_name[]"]');
            var iserror=true;
            co_name.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".invalid").html("Please Enter Co-Applicant Name");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    },200);
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
            var co_name = $('[name="co_relationship[]"]');
            var iserror=true;
            co_name.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".invalid").html("Please Enter Co-Applicant Relationship");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top,
                    });
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
            var other_pannumber = $('[name="co_pan_number[]"]');
            var iserror=true;
            other_pannumber.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".other_pan_error").html("The Pan Number Field Required");
                    iserror=false;
                    return false;
                }else{
                    var validateotherpan = ValidateOtherPAN($(this).val());
                    if(!validateotherpan){
                        $(this).siblings(".other_pan_error").html("Please Enter Valid Pan Number");
                        iserror=false;
                        $('html, body').animate({
                            scrollTop: $(this).offset().top
                        }, 100);
                        return false;
                    }else{
                        $(this).css("border-color",'#e6ecef');
                    }
                }
            });  
            if(iserror==false){
                return false;
            }
            var iserror=true;
            var coId = $('[name="getCoId[]"]');
            coId.each(function(){
               var coval= $(this).val();
               var isvalid=$('[name="base_co_pancard_'+coval+'[]"]');
                if(isvalid.length==0){
                    $('#other_pancard_error'+coval).html('Required document not uploaded');
                    document.getElementById('other_pancard_error'+coval).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#other_pancard_error'+coval).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('other_pancard_error'+coval).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            });
            if(iserror==false){
                return false;
            }
            UploadCoApplicantDocs();
    }else if(currentid=='next-4'){
        $('#itr_error').html('');
        $('#cheque_error').html('');
        $('#additionaldocs_error').html('');
        var business_type=$('#business_type').val();
        if(business_type=="Individual"){
            $('#pan_number_error').html('');
            $('#pan_image_error').html('');
            $('#business_address_error').html('');
            $('#business_address_proof_error').html('');
            $('#resident_address_error').html('');
            $('#resident_address_proof_error').html('');
            $('#bankstatement_error').html('');

            var pan_number=$('#pan_number').val();
            if(pan_number==""){
                $('#pan_number_error').html('The Pan Number Field is Required');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                var validatepan = ValidatePAN();
                if(!validatepan){
                    $('#pan_number_error').html('Please Enter Valid Pan Number');
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
                iserror=true;
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
            var business_address=$('#business_address').val();
            if(business_address==''){
                $('#business_address_error').html('The Business Address Field is Required');
                document.getElementById("business_address_error").scrollIntoView();
                return false;
            } 
            var base_business_proof_=$('[name="base_business_proof_[]"]');
            if(base_business_proof_.length==0){
                $('#business_address_proof_error').html('Required document not uploaded');
                document.getElementById("business_address_proof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_business_proof_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#business_address_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("business_address_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var resident_address=$('#resident_address').val();
            if(resident_address==''){
                $('#resident_address_error').html('The Resident Address Field is Required');
                document.getElementById("resident_address_error").scrollIntoView();
                return false;
            }
            var base_resident_address_=$('[name="base_resident_address_[]"]');
            if(base_resident_address_.length==0){
                $('#resident_address_proof_error').html('Required document not uploaded');
                document.getElementById("resident_address_proof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_resident_address_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#resident_address_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("resident_address_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_bankstatement_=$('[name="base_bankstatement_[]"]');
            if(base_bankstatement_.length==0){
                $('#bankstatement_error').html('Required document not uploaded');
                document.getElementById("bankstatement_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_bankstatement_.each(function(){
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
                iserror=true;
                base_itr_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#itr_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("itr_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_canceled_cheque_=$('[name="base_canceled_cheque_[]"]');
            if(base_canceled_cheque_.length>0){
                iserror=true;
                base_canceled_cheque_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#cheque_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("cheque_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_additional_docs_=$('[name="base_additional_docs_[]"]');
            if(base_additional_docs_.length>0){
                iserror=true;
                base_additional_docs_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#additionaldocs_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("additionaldocs_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            
        }else if(business_type=="Proprietorship"){
            $('#pan_number_error').html('');
            $('#pan_image_error').html('');
            $('#gst_proof_error').html('');
            $('#gstnumber_error').html('');
            $('#business_address_error').html('');
            $('#business_address_proof_error').html('');
            $('#resident_address_error').html('');
            $('#resident_address_proof_error').html('');
            $('#bankstatement_error').html('');
 
            var pan_number=$('#pan_number').val();
            if(pan_number==""){
                $('#pan_number_error').html('The Pan Number Field Required');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                var validatepan = ValidatePAN();
                if(!validatepan){
                    $('#pan_number_error').html('Please Enter Valid Pan Number');
                    document.getElementById("pan_number_error").scrollIntoView();
                    return false;
                }
            }
            var pancard_image=$('[name="base_pancard_[]"]');
            if(pancard_image.length==0){
                $('#pan_image_error').html('Required document not uploaded');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
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
            var gst_number=$('#gstnumber').val();
            if(gst_number!=""){
                var gstvalidation = GstValidate(gst_number);
                if(!gstvalidation){
                    $('#gstnumber_error').html('Please Enter Valid GST Number');
                    document.getElementById("gstnumber_error").scrollIntoView();
                    return false;
                }
            }
            var base_gstnumber_=$('[name="base_gstnumber_[]"]');
            if(base_gstnumber_.length>0){
                iserror=true;
                base_gstnumber_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#gst_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("gst_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }

            var business_address=$('#business_address').val();
            if(business_address==''){
                $('#business_address_error').html('The Business Address Field is Required');
                document.getElementById("business_address_error").scrollIntoView();
                return false;
            }
            var base_business_proof_=$('[name="base_business_proof_[]"]');
            if(base_business_proof_.length==0){
                $('#business_address_proof_error').html('Required document not uploaded');
                document.getElementById("business_address_proof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_business_proof_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#business_address_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("business_address_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var resident_address=$('#resident_address').val();
            if(resident_address==''){
                $('#resident_address_error').html('The Resident Address Field Required');
                document.getElementById("resident_address_error").scrollIntoView();
                return false;
            }
            var base_resident_address_=$('[name="base_resident_address_[]"]');
            if(base_resident_address_.length==0){
                $('#resident_address_proof_error').html('Required document not uploaded');
                document.getElementById("resident_address_proof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_resident_address_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#resident_address_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("resident_address_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_bankstatement_=$('[name="base_bankstatement_[]"]');
            if(base_bankstatement_.length==0){
                $('#bankstatement_error').html('Required document not uploaded');
                document.getElementById("bankstatement_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_bankstatement_.each(function(){
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
                iserror=true;
                base_itr_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#itr_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("itr_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_canceled_cheque_=$('[name="base_canceled_cheque_[]"]');
            if(base_canceled_cheque_.length>0){
                iserror=true;
                base_canceled_cheque_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#cheque_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("cheque_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_additional_docs_=$('[name="base_additional_docs_[]"]');
            if(base_additional_docs_.length>0){
                iserror=true;
                base_additional_docs_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#additionaldocs_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("additionaldocs_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
        }else if(business_type=="Partnership"){
            $('#pan_number_error').html('');
            $('#pan_image_error').html('');
            $('#gst_proof_error').html('');
            $('#gstnumber_error').html('');
            $('#business_address_error').html('');
            $('#business_address_proof_error').html('');
            $('#bankstatement_error').html('');
            $('#ownershipproof_error').html('');
            $('#partnershipdeal_error').html('');
            for(var i=0;i<$('#no_of_partner').val();i++){
                $('#panerror'+i).html('');
                $('#nameerror'+i).html('');
                $('#addresserror'+i).html('');
            }

            var pan_number=$('#pan_number').val();
            if(pan_number==""){
                $('#pan_number_error').html('The Pan Number Field is Required');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                var validatepan = ValidatePAN();
                if(!validatepan){
                    $('#pan_number_error').html('Please Enter Valid Pan Number');
                    document.getElementById("pan_number_error").scrollIntoView();
                    return false;
                }
            }

            var pancard_image=$('[name="base_pancard_[]"]');
            if(pancard_image.length==0){
                $('#pan_image_error').html('Required document not uploaded');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
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

            var gst_number=$('#gstnumber').val();
            if(gst_number!=""){
                var gstvalidation = GstValidate(gst_number);
                if(!gstvalidation){
                    $('#gstnumber_error').html('Please Enter Valid GST Number');
                    document.getElementById("gstnumber_error").scrollIntoView();
                    return false;
                }
            }
            var base_gstnumber_=$('[name="base_gstnumber_[]"]');
            if(base_gstnumber_.length>0){
                iserror=true;
                base_gstnumber_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#gst_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("gst_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var business_address=$('#business_address').val();
            if(business_address==''){
                $('#business_address_error').html('The Business Address Field is Required');
                document.getElementById("business_address_error").scrollIntoView();
                return false;
            }
            var base_business_proof_=$('[name="base_business_proof_[]"]');
            if(base_business_proof_.length==0){
                $('#business_address_proof_error').html('TRequired document not uploaded');
                document.getElementById("business_address_proof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_business_proof_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#business_address_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("business_address_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            
            var base_bankstatement_=$('[name="base_bankstatement_[]"]');
            if(base_bankstatement_.length==0){
                $('#bankstatement_error').html('Required document not uploaded');
                document.getElementById("bankstatement_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_bankstatement_.each(function(){
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

            var base_ownership_=$('[name="base_ownership_[]"]');
            if(base_ownership_.length==0){
                $('#ownershipproof_error').html('Required document not uploaded');
                document.getElementById("ownershipproof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_ownership_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#ownershipproof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("ownershipproof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_partnership_=$('[name="base_partnership_[]"]');
            if(base_partnership_.length==0){
                $('#partnershipdeal_error').html('Required document not uploaded');
                document.getElementById("partnershipdeal_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_partnership_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#partnershipdeal_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("partnershipdeal_error").scrollIntoView();
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
                iserror=true;
                base_itr_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#itr_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("itr_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_canceled_cheque_=$('[name="base_canceled_cheque_[]"]');
            if(base_canceled_cheque_.length>0){
                iserror=true;
                base_canceled_cheque_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#cheque_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("cheque_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_additional_docs_=$('[name="base_additional_docs_[]"]');
            if(base_additional_docs_.length>0){
                iserror=true;
                base_additional_docs_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#additionaldocs_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("additionaldocs_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            $(".invalid").html("");
            var other_name = $('[name="other_name[]"]');
            var iserror=true;
            other_name.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".invalid").html("Please Enter Partner Name");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 100);
                    return false;
                }
            });  
            if(iserror==false){
                return false;
            }
            var other_pannumber = $('[name="other_pan_number[]"]');
            var iserror=true;
            other_pannumber.each(function(){
                var validateotherpan = ValidateOtherPAN($(this).val());
                if(!validateotherpan){
                    $(this).siblings(".invalid").html("Please Enter Valid Pan Number");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 100);
                    return false;
                }                
            });  
            if(iserror==false){
                return false;
            }
            var other_address = $('[name="other_address[]"]');
            var iserror=true;
            other_address.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".invalid").html("Please Enter Business address");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 100);
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
            var iserror=true;
            for(var i=0;i<$('#no_of_partner').val();i++){
                var isvalid=$('[name="other_name_proof'+i+'[]"]');
                if(isvalid.length==0){
                    $('#nameerror'+i).html("Required document not uploaded");
                    document.getElementById('nameerror'+i).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#nameerror'+i).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('nameerror'+i).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            }
            if(iserror==false){
                return false;
            }
            var iserror=true;
            for(var i=0;i<$('#no_of_partner').val();i++){
                var isvalid=$('[name="other_pancard'+i+'[]"]');
                if(isvalid.length==0){
                    $('#panerror'+i).html("Required document not uploaded");
                    document.getElementById('panerror'+i).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#panerror'+i).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('panerror'+i).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            }
            if(iserror==false){
                return false;
            }
            var iserror=true; 
            for(var i=0;i<$('#no_of_partner').val();i++){
                var isvalid=$('[name="other_address'+i+'[]"]');
                if(isvalid.length==0){
                    $('#addresserror'+i).html("Required document not uploaded");
                    document.getElementById('addresserror'+i).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#addresserror'+i).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('addresserror'+i).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            }
            if(iserror==false){
                return false;
            }
            
        }else{
            $('#pan_number_error').html('');
            $('#pan_image_error').html('');
            $('#tan_number_error').html('');
            $('#tan_image_error').html('');
            $('#gst_proof_error').html('');
            $('#gstnumber_error').html('');
            $('#business_address_error').html('');
            $('#business_address_proof_error').html('');
            $('#coi_error').html('');
            $('#bankstatement_error').html('');
            $('#board_resolution_error').html('');
            for(var i=0;i<$('#no_of_director').val();i++){
                $('#panerror'+i).html('');
                $('#nameerror'+i).html('');
                $('#addresserror'+i).html('');
            }
            var pan_number=$('#pan_number').val();
            if(pan_number==""){
                $('#pan_number_error').html('The Pan Number Field is Required');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                var validatepan = ValidatePAN();
                if(!validatepan){
                    $('#pan_number_error').html('Please Enter Valid Pan Number');
                    document.getElementById("pan_number_error").scrollIntoView();
                    return false;
                }
            }
            
            var pancard_image=$('[name="base_pancard_[]"]');
            if(pancard_image.length==0){
                $('#pan_image_error').html('Required document not uploaded');
                document.getElementById("pan_number_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
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

            var gst_number=$('#gstnumber').val();
            if(gst_number!=""){
                var gstvalidation = GstValidate(gst_number);
                if(!gstvalidation){
                    $('#gstnumber_error').html('Please Enter Valid GST Number');
                    document.getElementById("gstnumber_error").scrollIntoView();
                    return false;
                }
            }
            var base_gstnumber_=$('[name="base_gstnumber_[]"]');
            if(base_gstnumber_.length>0){
                iserror=true;
                base_gstnumber_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#gst_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("gst_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var business_address=$('#business_address').val();
            if(business_address==''){
                $('#business_address_error').html('The Business Address Field is Required');
                document.getElementById("business_address_error").scrollIntoView();
                return false;
            }

            var base_business_proof_=$('[name="base_business_proof_[]"]');
            if(base_business_proof_.length==0){
                $('#business_address_proof_error').html('Required document not uploaded');
                document.getElementById("business_address_proof_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_business_proof_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#business_address_proof_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("business_address_proof_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            
            var base_tan_=$('[name="base_tan_[]"]');
            if(base_tan_.length==0){
                $('#tan_image_error').html('Required document not uploaded');
                document.getElementById("tan_image_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_tan_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#tan_image_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("tan_image_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            
            var base_coi_firm_=$('[name="base_coi_firm_[]"]');
            if(base_coi_firm_.length==0){
                $('#coi_error').html('Required document not uploaded');
                document.getElementById("coi_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_coi_firm_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#coi_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("coi_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_bankstatement_=$('[name="base_bankstatement_[]"]');
            if(base_bankstatement_.length==0){
                $('#bankstatement_error').html('Required document not uploaded');
                document.getElementById("bankstatement_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_bankstatement_.each(function(){
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
            var base_resolution_=$('[name="base_resolution_[]"]');
            if(base_resolution_.length==0){
                $('#board_resolution_error').html('Required document not uploaded');
                document.getElementById("board_resolution_error").scrollIntoView();
                return false;
            }else{
                iserror=true;
                base_resolution_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                        $('#board_resolution_error').html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                        document.getElementById("board_resolution_error").scrollIntoView();
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
                iserror=true;
                base_itr_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#itr_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("itr_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_canceled_cheque_=$('[name="base_canceled_cheque_[]"]');
            if(base_canceled_cheque_.length>0){
                iserror=true;
                base_canceled_cheque_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#cheque_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("cheque_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            var base_additional_docs_=$('[name="base_additional_docs_[]"]');
            if(base_additional_docs_.length>0){
                iserror=true;
                base_additional_docs_.each(function(){
                    var ext = $(this).val().split('@kk@').pop().toLowerCase();
                    if($.inArray(ext, ['pdf','png','jpeg','jpg','doc','docx']) == -1) {
                        $('#additionaldocs_error').html('Only pdf,png,jpeg,doc,docx,jpg file Allowed');
                        document.getElementById("additionaldocs_error").scrollIntoView();
                        iserror=false;
                        return false;
                    }
                });
                if(iserror==false){
                    return false;
                }
            }
            $(".invalid").html("");
            var other_name = $('[name="other_name[]"]');
            var iserror=true;
            other_name.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".invalid").html("Please Enter Director Name");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 100);
                    return false;
                }
            });  
            if(iserror==false){
                return false;
            }
            var other_pannumber = $('[name="other_pan_number[]"]');
            var iserror=true;
            other_pannumber.each(function(){
                var validateotherpan = ValidateOtherPAN($(this).val());
                if(!validateotherpan){
                    $(this).siblings(".invalid").html("Please Enter Valid Pan Number");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 100);
                    return false;
                }                
            });  
            if(iserror==false){
                return false;
            }
            var other_address = $('[name="other_address[]"]');
            var iserror=true;
            other_address.each(function(){
                if($(this).val()==""){
                    $(this).siblings(".invalid").html("Please Enter Business address");
                    iserror=false;
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 100);
                    return false;
                }
            });
            if(iserror==false){
                return false;
            }
           /*  var iserror=true;
            for(var i=0;i<$('#no_of_director').val();i++){
                var isvalid=$('[name="other_name_proof'+i+'[]"]');
                if(isvalid.length==0){
                    $('#nameerror'+i).html("Required document not uploaded");
                    document.getElementById('nameerror'+i).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#nameerror'+i).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('nameerror'+i).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            }
            if(iserror==false){
                return false;
            } */
            var iserror=true;
            for(var i=0;i<$('#no_of_director').val();i++){
                var isvalid=$('[name="other_pancard'+i+'[]"]');
                if(isvalid.length==0){
                    $('#panerror'+i).html("Required document not uploaded");
                    document.getElementById('panerror'+i).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#panerror'+i).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('panerror'+i).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            }
            if(iserror==false){
                return false;
            }
            var iserror=true; 
            for(var i=0;i<$('#no_of_director').val();i++){
                var isvalid=$('[name="other_address'+i+'[]"]');
                if(isvalid.length==0){
                    $('#addresserror'+i).html("Required document not uploaded");
                    document.getElementById('addresserror'+i).scrollIntoView();
                    iserror=false;
                    return false;
                }else{
                    isvalid.each(function(){
                        var ext = $(this).val().split('@kk@').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg','pdf','doc','docx']) == -1) {
                            $('#addresserror'+i).html('Only png,jpg,jpeg,pdf,doc,docx file Allowed');
                            document.getElementById('addresserror'+i).scrollIntoView();
                            iserror=false;
                            return false;
                        }
                    });
                }
            }
            if(iserror==false){
                return false;
            }
        }
        
        DocumentUpload();
    }else if(currentid=='next-5'){
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
 
$("fieldset").delegate(".removeOrder", "click", function () {  
    $(this).closest('.card').remove();
  }
);  

function SublitLoan(){
    var html='<div style="height:14px;width:14px;" class="spinner-border text-light" role="status">'+
        '<span class="sr-only">Loading...</span>'+
    '</div>';
    $('#submitloader').html(html);
    $('#next-5').attr('disabled', 'disabled'); 
    var clearinterval = setInterval(function(){ 
        if($.active==0){
            getsuccess();
            clearInterval(clearinterval);
        }
     }, 100);
}
function getsuccess(){
    var formData = new FormData();
    formData.append('phone', $('#phone').val());
    formData.append('employment_type', $('#employment_type').val());
    formData.append('business_name', $('#business_name').val());
    formData.append('houseno', $('#houseno').val());
    formData.append('city', $('#city').val());
    formData.append('pincode', $('#pincode').val());
    formData.append('state', $('#state').val());
    formData.append('vintage', $('#vintage').val());
    formData.append('turn_over', $('#turn_over').val());
    formData.append('business_type', $('#business_type').val());
    formData.append('desired_amount', $('#desired_amount').val());
    formData.append('reference', $('#reference').val());
    formData.append('reference_number', $('#reference_number').val());
    formData.append('nature_of_business', $('#nature_of_business').val());
    formData.append('type_of_nature', $('#type_of_nature').val());
    $.ajax({
        type: "POST",
        url: SiteUrl+"merchant/loan_registration",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (request, xhr) {
            
        },
        success: function(response) {
            if(response['status']=="success"){
               window.location.href=SiteUrl+"merchant";
            }
        },
        xhr: function(){
             var xhr = $.ajaxSettings.xhr() ;
             xhr.upload.onprogress = function(data){
                
             };
             return xhr ;
        },
    });
}
function DeleteRow(e){
    e.parentNode.parentNode.removeChild(e.parentNode);
    if(document.getElementById("add_co_applicant").innerHTML.trim()==""){
        FixApplicant();
    }
}
function CheckDPBtn(){
    var value=$('#business_type').val();
    if(value!=""){
        if(value=='Proprietorship'){      
            UploadForPropertier();
            $('#add_number_field').html('');
            $('#add_number_field').attr('class','col-12 col-sm-6');
        }else{
            if(value=="Partnership"){
                UploadForPartnership();
                var other_html='<div class="md-input">'+
                    '<input class="md-form-control" id="no_of_partner"  type="number" onkeyup="TotalPartnerDoc(this.value);DataSave(this.id,this.value)" title="No. of Partners" required=""/>'+
                    '<label>Number Of Partners</label>'+
                    '<small id="partner_number_error" class="text-danger"></small></div>';
                $('#add_number_field').attr('class','col-12 col-sm-6 mt-4');
                $('#add_number_field').html(other_html);
            }else if(value=="Individual"){
                UploadForIndividual();
                $('#add_number_field').html('');
                $('#add_number_field').attr('class','col-12 col-sm-6');
            }else{
                UploadForPvt();
                var other_html='<div class="md-input">'+
                    '<input class="md-form-control" id="no_of_director" type="number" onkeyup="TotalDirectorDoc(this.value);DataSave(this.id,this.value)" title="No. of Directors" required=""/>'+
                    '<label>No. of Directors</label>'+
                    '<small id="director_number_error" class="text-danger"></small></div>';
                $('#add_number_field').attr('class','col-12 col-sm-6 mt-4');
                $('#add_number_field').html(other_html);
            }
        }
    }else{
        $('#add_number_field').attr('class','col-12 col-sm-6');
        $('#add_number_field').html('');
    }
}
function TotalPartnerDoc(value){
    $('#add_partner_doc_field').html('');
    if(value>0){
        for(var i=0;i<value;i++){
            AddMorePartner(i);
        }
    }
}
function TotalDirectorDoc(value){
    $('#add_director_doc_field').html('');
    if(value>0){
        for(var i=0;i<value;i++){
            AddMoreDirector(i);
        }
    }
}
function CheckNatureBtn(value){
    if(value!=""){
        var other_html='<div class="md-input"><input onkeyup="DataSave(this.id,this.value)" class="md-form-control" id="type_of_nature" title="Type Of '+value+'" type="text" required=""/><label>Type Of '+value+'</label><small id="type_of_nature_error" class="text-danger"></small></div>';
        $('#add_nature_field').attr('class','col-12 col-sm-6 mt-4');
        $('#add_nature_field').html(other_html);
    }else{
        var business_type=$().val();
        /* if(business_type=="" || business_type=="Individual" || business_type!="Proprietorship"){
            $('#firm_field').attr('class','form-row');
        } */
        $('#add_nature_field').html('');
        $('#add_nature_field').attr('class','col-12 col-sm-6');
    }
}

function UploadForPvt(){
    
    var html='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    `<input class="md-form-control" type="text" id="pan_number" onkeyup="DataSave(this.id,this.value)" title="Enter Firm's PAN No." required=""/>`+
                    `<label>Enter Firm's PAN No.</label>`+
                    '<small class="text-danger" id="pan_number_error"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload Pan Card +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" id="pancard_image" onchange="ShowSelectImage(this,`shownearimage1`,`base_pancard_`,`pancard_image`)" class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="pan_image_error"></small>'+
            '</div>'+
            '<div id="shownearimage1" style="width:100%" aria-live="polite"></div>'+
        '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                `<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="gstnumber" title="Enter Firm's GST Number" required=""/>`+
                `<label>Enter Firm's GST Number</label>`+
                '<small class="text-danger" id="gstnumber_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload GST Registration +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" id="gstproof_image" onchange="ShowSelectImage(this,`shownearimage2`,`base_gstnumber_`,`gstproof_image`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="gst_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage2" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="business_address" title="Enter Business Address" required=""/>'+
                '<label>Enter Business Address</label>'+
                '<small class="text-danger" id="business_address_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>Upload +</span>'+
            '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" id="business_proof_image" onchange="ShowSelectImage(this,`shownearimage4`,`base_business_proof_`,`business_proof_image`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="business_address_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage4" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>Upload MOA/AOA +</span>'+
            '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" id="tan_image" onchange="ShowSelectImage(this,`shownearimage3`,`base_tan_`,`tan_image`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="tan_image_error"></small>'+
        '</div>'+
        '<div id="shownearimage3" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>Upload COI of Firm +</span>'+
            '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage5`,`base_coi_firm_`,`coi_image`)" id="coi_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="coi_error"></small>'+
        '</div>'+
        '<div id="shownearimage5" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-9 col-sm-9">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +</span>'+
            '<input type="file" multiple accept=".pdf"  onchange="ShowSelectImage(this,`shownearimage6`,`base_bankstatement_`,`bankstatement_image`)" id="bankstatement_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="bankstatement_error"></small>'+
        '</div>'+
        '<div class="col-3 col-sm-3">'+
            '<div class="md-input">'+
                '<input class="md-form-control"  id="bankstatement_password">'+
                '<label>PDF Password (Optional)</label>'+
            '</div>'+
        '</div>'+
        '<div id="shownearimage6" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>Upload Board Resolution for signing authority +</span>'+
            '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage7`,`base_resolution_`,`boardresolution_image`)" id="boardresolution_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="board_resolution_error"></small>'+
        '</div>'+
        '<div id="shownearimage7" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+=AddExtraDocs();
    html+='<div class="form-row mt-2 condition_type_of_firm">'+
            '<div class="col-12 col-sm-12 mt-4" >'+
                '<h3>Director Docs</h3>'+
            '</div>'+
        '</div>';
    html+='<div id="add_director_doc_field"></div>';
    $('#documents_field').html(html);
}
var directorid=100000;
function AddMoreDirector(i){
    var html='<div><hr>'+
    '<div class="form-row mt-1">'+
        '<div class="col-12 col-sm-12">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" name="other_name[]" title="Enter director name" required=""/>'+
                '<label>Enter director name</label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
        '<!--div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>Upload Proof +</span>'+
            '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" id="other_name_proof'+i+'" multiple onchange="ShowSelectImage2(this,`shownearimage'+directorid+'`,`other_name_proof'+i+'`)" name="other_nameproof_image[]" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="nameerror'+i+'"></small>'+
            '<div id="shownearimage'+directorid+'"></div>'+
        '</div--->'+
    '</div>';
    directorid=directorid+1;
    html+='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    '<input class="md-form-control" type="text" name="other_pan_number[]" title="Enter director pan number" required=""/>'+
                    '<label>Enter director pan number</label>'+
                    '<small class="text-danger invalid"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload Director Pan Card +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple id="other_pancard'+i+'" name="other_pancard_image[]" onchange="ShowSelectImage2(this,`shownearimage'+directorid+'`,`other_pancard'+i+'`)" class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="panerror'+i+'"></small>'+
                '<div id="shownearimage'+directorid+'"></div>'+
            '</div>'+
        '</div>';
    directorid=directorid+1;
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" name="other_address[]" title="Enter Director Address" required=""/>'+
                '<label>Enter Director Address</label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload Director Address Proof +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple  id="other_address'+i+'" name="other_address_proof[]" onchange="ShowSelectImage2(this,`shownearimage'+directorid+'`,`other_address'+i+'`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="addresserror'+i+'"></small>'+
            '<div id="shownearimage'+directorid+'"></div>'+
        '</div>'+
    '</div></div>';
    directorid=directorid+1;
    $('#add_director_doc_field').append(html);
}
function UploadForPartnership(){
    var html='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    `<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="pan_number" title="Enter Firm's PAN No." required=""/>`+
                    `<label>Enter Firm's PAN No.</label>`+
                    '<small class="text-danger" id="pan_number_error"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                    '<span>Upload Pan Card +</span>'+
                    '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage10`,`base_pancard_`,`pancard_image`)" id="pancard_image" class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="pan_image_error"></small>'+
            '</div>'+
            '<div id="shownearimage10" style="width:100%" aria-live="polite"></div>'+
        '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                `<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="gstnumber" title="Enter Firm's GST Number" required=""/>`+
                `<label>Enter Firm's GST Number</label>`+
                '<small class="text-danger" id="gstnumber_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload GST Registration +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" id="gstproof_image" onchange="ShowSelectImage(this,`shownearimage11`,`base_gstnumber_`,`gstproof_image`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="gst_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage11" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="business_address" title="Enter Business Address" required=""/>'+
                '<label>Enter Business Address</label>'+
                '<small class="text-danger" id="business_address_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>Upload +</span>'+
            '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage12`,`base_business_proof_`,`business_proof_image`)" id="business_proof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="business_address_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage12" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-9 col-sm-9">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +</span>'+
                '<input type="file" multiple accept=".pdf"  id="bankstatement_image" onchange="ShowSelectImage(this,`shownearimage13`,`base_bankstatement_`,`bankstatement_image`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="bankstatement_error"></small>'+
        '</div>'+
        '<div class="col-3 col-sm-3">'+
            '<div class="md-input">'+
                '<input class="md-form-control"  id="bankstatement_password">'+
                '<label>PDF Password (Optional)</label>'+
            '</div>'+
        '</div>'+
        '<div id="shownearimage13" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload Ownership Proof +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage14`,`base_ownership_`,`ownershipproof_image`)" id="ownershipproof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="ownershipproof_error"></small>'+
        '</div>'+
        '<div id="shownearimage14" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload Partnership Deed Proof +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage15`,`base_partnership_`,`partnershipdeal_image`)" id="partnershipdeal_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="partnershipdeal_error"></small>'+
        '</div>'+
        '<div id="shownearimage15" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+=AddExtraDocs();
    html+='<div class="form-row mt-2 condition_type_of_firm">'+
            '<div class="col-12 col-sm-12 mt-4" >'+
                '<h3>Partner Docs</h3>'+
            '</div>'+
        '</div>';
    html+='<div id="add_partner_doc_field"></div>';
    $('#documents_field').html(html);
}
function UploadForPropertier(){
    var html='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    `<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="pan_number" title="Enter Firm's PAN No." required=""/>`+
                    `<label>Enter Firm's PAN No.</label>`+
                    '<small class="text-danger" id="pan_number_error"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                    '<span>Upload Pan Card +</span>'+
                    '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage31`,`base_pancard_`,`pancard_image`)" id="pancard_image" class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="pan_image_error"></small>'+
            '</div>'+
            '<div id="shownearimage31" style="width:100%" aria-live="polite"></div>'+
        '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                `<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="gstnumber" title="Enter Firm's GST Number" required=""/>`+
                `<label>Enter Firm's GST Number</label>`+
                '<small class="text-danger" id="gstnumber_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload GST Registration +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage32`,`base_gstnumber_`,`gstproof_image`)" id="gstproof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="gst_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage32" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="business_address" title="Enter Business Address" required=""/>'+
                '<label>Enter Business Address</label>'+
                '<small class="text-danger" id="business_address_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage33`,`base_business_proof_`,`business_proof_image`)" id="business_proof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="business_address_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage33" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="resident_address" title="Enter Residence Address" required=""/>'+
                '<label>Enter Residence Address</label>'+
                '<small class="text-danger" id="resident_address_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload +</span>'+
                '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage34`,`base_resident_address_`,`resident_proof_image`)" id="resident_proof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="resident_address_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage34" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-9 col-sm-9">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +</span>'+
                '<input type="file" accept=".pdf" multiple id="bankstatement_image" onchange="ShowSelectImage(this,`shownearimage35`,`base_bankstatement_`,`bankstatement_image`)" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="bankstatement_error"></small>'+
        '</div>'+
        '<div class="col-3 col-sm-3">'+
            '<div class="md-input">'+
                '<input class="md-form-control"  id="bankstatement_password">'+
                '<label>PDF Password (Optional)</label>'+
            '</div>'+
        '</div>'+
        '<div id="shownearimage35" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+=AddExtraDocs();
    $('#documents_field').html(html);
}
function AddMorePartner(i){
    var html='<div><hr>'+
    '<div class="form-row mt-1">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    '<input class="md-form-control" type="text" name="other_name[]" title="Enter partner name" required=""/>'+
                    '<label>Enter partner name</label>'+
                    '<small class="text-danger invalid"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                    '<span>Upload Proof +</span>'+
                    '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple id="other_name_proof'+i+'" name="other_nameproof_image[]" onchange="ShowSelectImage2(this,`shownearimage'+directorid+'`,`other_name_proof'+i+'`)" class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="nameerror'+i+'"></small>'+
                '<div id="shownearimage'+directorid+'"></div>'+
            '</div>'+
        '</div>';
    directorid=directorid+1;
    html+='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    '<input class="md-form-control" type="text" name="other_pan_number[]" title="Enter partner pan number" required=""/>'+
                    '<label>Enter partner pan number</label>'+
                    '<small class="text-danger invalid"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                    '<span>Upload Partner Pan Card +</span>'+
                    '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple id="other_pancard'+i+'" name="other_pancard_image[]" onchange="ShowSelectImage2(this,`shownearimage'+directorid+'`,`other_pancard'+i+'`)"  class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="panerror'+i+'"></small>'+
                '<div id="shownearimage'+directorid+'"></div>'+
            '</div>'+
        '</div>';
    directorid=directorid+1;
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" name="other_address[]" title="Enter partner Address" required=""/>'+
                '<label>Enter partner Address<label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload Partner Address Proof +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" multiple id="other_address'+i+'" onchange="ShowSelectImage2(this,`shownearimage'+directorid+'`,`other_address'+i+'`)"  name="other_address_proof[]" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="addresserror'+i+'"></small>'+
            '<div id="shownearimage'+directorid+'"></div>'+
        '</div>'+
    '</div></div>';
    directorid=directorid+1;
    $('#add_partner_doc_field').append(html);
}
function UploadForIndividual(){
    var html='<div class="form-row mt-4">'+
            '<div class="col-12 col-sm-6">'+
                '<div class="md-input">'+
                    '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="pan_number" title="Enter PAN No." required=""/>'+
                    '<label>Enter PAN No.</label>'+
                    '<small class="text-danger" id="pan_number_error"></small>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                '<div class="fileUpload blue-btn btn width100">'+
                    '<span>Upload Pan Card +</span>'+
                    '<input type="file" multiple accept=".png, .jpeg, .jpg, .pdf, .doc, .docx"  onchange="ShowSelectImage(this,`shownearimage21`,`base_pancard_`,`pancard_image`)"   id="pancard_image" class="uploadlogo" />'+
                '</div>'+
                '<small class="text-danger" id="pan_image_error"></small>'+
            '</div>'+
            '<div id="shownearimage21" style="width:100%" aria-live="polite"></div>'+
        '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="business_address" title="Enter Business Address" required=""/>'+
                '<label>Enter Business Address</label>'+
                '<small class="text-danger" id="business_address_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage22`,`base_business_proof_`,`business_proof_image`)" multiple id="business_proof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="business_address_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage22" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" type="text" onkeyup="DataSave(this.id,this.value)" id="resident_address" title="Enter Residence Address" required=""/>'+
                '<label>Enter Residence Address</label>'+
                '<small class="text-danger" id="resident_address_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Upload +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`shownearimage23`,`base_resident_address_`,`resident_proof_image`)"  id="resident_proof_image" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="resident_address_proof_error"></small>'+
        '</div>'+
        '<div id="shownearimage23" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-9 col-sm-9">'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>UPLOAD LATEST MINIMUM 6 MONTHS BANK STATEMENT +</span>'+
                '<input type="file" accept=".pdf" onchange="ShowSelectImage(this,`shownearimage24`,`base_bankstatement_`,`bankstatement_image`)" id="bankstatement_image" multiple class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="bankstatement_error"></small>'+
        '</div>'+
        '<div class="col-3 col-sm-3">'+
            '<div class="md-input">'+
                '<input class="md-form-control"  id="bankstatement_password">'+
                '<label>PDF Password (Optional)</label>'+
            '</div>'+
        '</div>'+
        '<div id="shownearimage24" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+=AddExtraDocs();
    $('#documents_field').html(html);
}
function AddCoApplicant(){
    var randid=new Date().getUTCMilliseconds();
    var html='<div><hr>'+
    '<button type="button" onclick="DeleteRow(this)" class="btn btn-danger float-right mt-2">Delete</button>'+
    '<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" onkeyup="SaveApplicant()" type="text" title="Name of co-applicant" name="co_name[]" required=""/>'+
                '<label>Name</label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="md-input">'+
                '<input class="md-form-control" onkeyup="SaveApplicant()" type="text" title="Relationship with co-applicant" name="co_relationship[]" required=""/>'+
                '<label>Relationship</label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
    '</div>'+
    '<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" onkeyup="SaveApplicant()" name="co_pan_number[]" type="text" title="PAN No. of co-applicant" required=""/>'+
                '<label>PAN</label>'+
                '<small class="text-danger other_pan_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
        '<input type="hidden" name="getCoId[]" value="'+randid+'" >'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Co-Applicant Pancard +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`ShowImage'+randid+'`,`base_co_pancard_'+randid+'`,`co-pan'+randid+'`)" id="co-pan'+randid+'" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="other_pancard_error'+randid+'"></small>'+
        '</div>'+
        '<div id="ShowImage'+randid+'" style="width:100%" aria-live="polite"></div>'+
    '</div></div>';
    
    $('#add_co_applicant').append(html);
}
function FixApplicant(){
    var randid=new Date().getUTCMilliseconds();
    var html='<div>'+
    '<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" onkeyup="SaveApplicant()" type="text" title="Name of co-applicant" name="co_name[]" required=""/>'+
                '<label>Name</label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="md-input">'+
                '<input class="md-form-control" onkeyup="SaveApplicant()" type="text" title="Relationship with co-applicant" name="co_relationship[]" required=""/>'+
                '<label>Relationship</label>'+
                '<small class="text-danger invalid"></small>'+
            '</div>'+
        '</div>'+
    '</div>'+
    '<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-6">'+
            '<div class="md-input">'+
                '<input class="md-form-control" onkeyup="SaveApplicant()" name="co_pan_number[]" type="text" title="PAN No. of co-applicant" required=""/>'+
                '<label>PAN</label>'+
                '<small class="text-danger other_pan_error"></small>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<input type="hidden" name="getCoId[]" value="'+randid+'" >'+
            '<div class="fileUpload blue-btn btn width100">'+
                '<span>Co-Applicant Pancard +</span>'+
                '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage2(this,`ShowImage'+randid+'`,`base_co_panncard_'+randid+'`,`co-pan'+randid+'`)" id="co-pan'+randid+'" class="uploadlogo" />'+
            '</div>'+
            '<small class="text-danger" id="other_pancard_error'+randid+'"></small>'+
        '</div>'+
        '<div id="ShowImage'+randid+'" style="width:100%" aria-live="polite"></div>'+
    '</div></div>';
    $('#add_co_applicant').append(html);
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
function convertToBase64(fileToLoad,randid) {
    var fileReader = new FileReader();
    var base64;
    fileReader.onload = function(fileLoadedEvent) {
        $('#'+randid).attr('value',fileLoadedEvent.target.result+'@kk@'+fileToLoad.name.split('.').pop().toLowerCase());
    };
    fileReader.readAsDataURL(fileToLoad);
}
function ShowSelectImage(image,classid,class_add="",nullid){
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
    document.getElementById(nullid).value=null;
}
function ShowSelectImage2(image,classid,idcurrent=""){
    //$('#'+classid).html('');
    for(var i=0;i<image.files.length;i++){
        $('#'+classid).addClass('quote-imgs-thumbs');
        var extension = image.files[i].name.split('.').pop().toLowerCase()
        if(extension=='doc' || extension=='pdf' || extension=='docx'){
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2 img-preview-thumb"><a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+'</a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`'+classid+'`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'" name="'+idcurrent+'[]"></div>');
            convertToBase64(image.files[i],randid);
        }else if(extension=='png' || extension=='jpg' || extension=='jpeg'){
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2"><a href="javascript:void(0)"><img class="img-preview-thumb" onclick="ShowLargeImage(this.src)" id="'+randid+'"></a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`'+classid+'`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'image" name="'+idcurrent+'[]"></div></div>');
            readURL(image.files[i],randid);
        }else{
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2 img-preview-thumb"><a href="javascript:void(0)"><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+'</a><a href="javascript:void(0)" class="text-danger" onclick="RemoveFile(this,`'+classid+'`)">&times;</a>'+
            '<input type="hidden" id="'+randid+'" name="'+idcurrent+'[]"></div>');
            convertToBase64(image.files[i],randid);
        }
    }
    document.getElementById(idcurrent).value=null;
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
$('#loan_otp').keyup(function(){
    var loanotp=$('#loan_otp').val();
    if(loanotp.length==6){
        $('#disabled_btn').removeAttr('disabled');
    }
});
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
function MobileValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('phone');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
function ReferenceValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('reference_number');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
function ValidatePAN() { 
    var Obj = document.getElementById("pan_number");
    if (Obj.value != "") {
        var ObjVal = Obj.value;
        var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
        if (ObjVal.search(panPat) == -1) {
            return false;
        }
    }
    return true;
}
function ValidateTAN() { 
    var Obj = document.getElementById("tan_number");
    if (Obj.value != "") {
        var ObjVal = Obj.value;
        var panPat = /^([a-zA-Z]{4})(\d{5})([a-zA-Z]{1})$/;
        if (ObjVal.search(panPat) == -1) {
            return false;
        }
    }
    return true;
}
function ValidateOtherPAN(val) { 
    var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
    if (val.search(panPat) == -1) {
        return false;
    }
    return true;
}
function PincodeValidation(val){
    var pinvalid=/^\d{6}$/;
    if (val.search(pinvalid) == -1) {
        return false;
    }
    return true;
}
function GetCityList(state,city=""){
    if(state!=""){
        $.ajax({
            url: SiteUrl+"merchant/GetCityList",
            method:'POST',
            data:{"state":state,"city":city},
            success: function(result){
                $('#city').html(result);
                if($.isFunction(window.CityLabel)){
                    CityLabel();
                    if($('#city').val()==""){
                        $('#other_city_field').html('');
                        $('#pincode').html('<option value="">Pincode</option><option value="Other">Other</option>');
                        $('#other_pincode_field').html('');
                        $('#other_city_field').removeClass('mt-4');
                        $('#other_pincode_field').removeClass('mt-4');
                    }
                    
                }
            }
        });
    }else{
        $('#city').html('<option value="">City</option><option value="Other">Other</option>');
        $('#pincode').html('<option value="">Pincode</option><option value="Other">Other</option>');
        $('#other_city_field').html('');
        $('#other_city_field').removeClass('mt-4');
        $('#other_pincode_field').html('');
        $('#other_pincode_field').removeClass('mt-4');
    }
}


function DataSave(id,value){
    var Data={
        "mobile_number":$('#phone').val(),
        'value':value,
        'key':id
    }
    $.ajax({
        url: SiteUrl+"merchant/keyUpForm",
        method:'POST',
        cache: false,
        dataType:"json",
        data:Data,
        success: function(result){
            //console.log(result);
        }
    });
}
function SaveApplicant(){
/* 
    var formData = new FormData();
    formData.append('phone',$('#phone').val());
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
    $.ajax({
        url: SiteUrl+"merchant/SaveApplicant",
        method:'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(result){
            //console.log(result);
        }
    }); */
}
function DocumentUpload(){
    var html='<div class="progress" style="height: 40px;">'+
                '<div style="font-size: 30px;" class="documentbar progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">'+
                    '0%'+
                '</div>'+
                '<div id="status"></div>'+
            '</div>';
    $('#showdocumentbar').html(html);
    var formData = new FormData();
    formData.append('phone',$('#phone').val());
    var business_type=$('#business_type').val();
    formData.append('business_type', $('#business_type').val());
    formData.append('bankstatement_password', $('#bankstatement_password').val());
    if(business_type=="Individual"){
        formData.append('pan_number', $('#pan_number').val());
        formData.append('business_address', $('#business_address').val());
        formData.append('resident_address', $('#resident_address').val());
    }else if(business_type=="Proprietorship"){
        formData.append('pan_number', $('#pan_number').val());
        formData.append('gstnumber', $('#gstnumber').val());
        formData.append('business_address', $('#business_address').val());
        formData.append('resident_address', $('#resident_address').val());
    }else if(business_type=="Partnership"){
        formData.append('no_of_partner', $('#no_of_partner').val());
        formData.append('pan_number', $('#pan_number').val());
        formData.append('gstnumber', $('#gstnumber').val());
        formData.append('business_address', $('#business_address').val());

        var other_name=document.getElementsByName('other_name[]');
        for (var i = 0; i <other_name.length; i++) {
            formData.append('other_name[]',other_name[i].value);
        }

        var other_pan=document.getElementsByName('other_pan_number[]');
        for (var i = 0; i <other_pan.length; i++) {
            formData.append('other_pan_number[]',other_pan[i].value);
        }

        var other_address=document.getElementsByName('other_address[]');
        for (var i = 0; i <other_address.length; i++) {
            formData.append('other_address[]',other_address[i].value);
        }

        for(var i=0;i<$('#no_of_partner').val();i++){
            var othername=document.getElementsByName('other_name_proof'+i+'[]');
            for (var j = 0; j <othername.length; j++) {
                formData.append('other_name_proof'+i+'[]',othername[j].value);
            }
            var other_pancard=document.getElementsByName('other_pancard'+i+'[]');
            for (var j = 0; j <other_pancard.length; j++) {
                formData.append('other_pancard'+i+'[]',other_pancard[j].value);
            }

            var other_address=document.getElementsByName('other_address'+i+'[]');
            for (var j = 0; j <other_address.length; j++) {
                formData.append('other_address'+i+'[]',other_address[j].value);
            }
        }
    }else{
        formData.append('no_of_director', $('#no_of_director').val());
        formData.append('pan_number', $('#pan_number').val());
        formData.append('gstnumber', $('#gstnumber').val());
        formData.append('business_address', $('#business_address').val());
        
        var other_name=document.getElementsByName('other_name[]');
        for (var i = 0; i <other_name.length; i++) {
            formData.append('other_name[]',other_name[i].value);
        }

        var other_pan=document.getElementsByName('other_pan_number[]');
        for (var i = 0; i <other_pan.length; i++) {
            formData.append('other_pan_number[]',other_pan[i].value);
        }

        var other_address=document.getElementsByName('other_address[]');
        for (var i = 0; i <other_address.length; i++) {
            formData.append('other_address[]',other_address[i].value);
        }
        for(var i=0;i<$('#no_of_director').val();i++){
            var othername=document.getElementsByName('other_name_proof'+i+'[]');
            for (var j = 0; j <othername.length; j++) {
                formData.append('other_name_proof'+i+'[]',othername[j].value);
            }
            var other_pancard=document.getElementsByName('other_pancard'+i+'[]');
            for (var j = 0; j <other_pancard.length; j++) {
                formData.append('other_pancard'+i+'[]',other_pancard[j].value);
            }

            var other_address=document.getElementsByName('other_address'+i+'[]');
            for (var j = 0; j <other_address.length; j++) {
                formData.append('other_address'+i+'[]',other_address[j].value);
            }
        }
    }
    var base_pancard_=document.getElementsByName('base_pancard_[]');
    for (var i = 0; i <base_pancard_.length; i++) {
        formData.append('base_pancard_[]',base_pancard_[i].value);
    }
    var base_gstnumber_=document.getElementsByName('base_gstnumber_[]');
    for (var i = 0; i <base_gstnumber_.length; i++) {
        formData.append('base_gstnumber_[]',base_gstnumber_[i].value);
    }
    var base_business_proof_=document.getElementsByName('base_business_proof_[]');
    for (var i = 0; i <base_business_proof_.length; i++) {
        formData.append('base_business_proof_[]',base_business_proof_[i].value);
    }
    var base_tan_=document.getElementsByName('base_tan_[]');
    for (var i = 0; i <base_tan_.length; i++) {
        formData.append('base_tan_[]',base_tan_[i].value);
    }
    var base_coi_firm_=document.getElementsByName('base_coi_firm_[]');
    for (var i = 0; i <base_coi_firm_.length; i++) {
        formData.append('base_coi_firm_[]',base_coi_firm_[i].value);
    }
    var base_bankstatement_=document.getElementsByName('base_bankstatement_[]');
    for (var i = 0; i <base_bankstatement_.length; i++) {
        formData.append('base_bankstatement_[]',base_bankstatement_[i].value);
    }
    var base_resolution_=document.getElementsByName('base_resolution_[]');
    for (var i = 0; i <base_resolution_.length; i++) {
        formData.append('base_resolution_[]',base_resolution_[i].value);
    }
    var base_resident_address_=document.getElementsByName('base_resident_address_[]');
    for (var i = 0; i <base_resident_address_.length; i++) {
        formData.append('base_resident_address_[]',base_resident_address_[i].value);
    }
    var base_ownership_=document.getElementsByName('base_ownership_[]');
    for (var i = 0; i <base_ownership_.length; i++) {
        formData.append('base_ownership_[]',base_ownership_[i].value);
    }
    var base_partnership_=document.getElementsByName('base_partnership_[]');
    for (var i = 0; i <base_partnership_.length; i++) {
        formData.append('base_partnership_[]',base_partnership_[i].value);
    }
    var base_itr_=document.getElementsByName('base_itr_[]');
    for (var i = 0; i <base_itr_.length; i++) {
        formData.append('base_itr_[]',base_itr_[i].value);
    }
    var base_canceled_cheque_=document.getElementsByName('base_canceled_cheque_[]');
    for (var i = 0; i <base_canceled_cheque_.length; i++) {
        formData.append('base_canceled_cheque_[]',base_canceled_cheque_[i].value);
    }
    var base_additional_docs_=document.getElementsByName('base_additional_docs_[]');
    for (var i = 0; i <base_additional_docs_.length; i++) {
        formData.append('base_additional_docs_[]',base_additional_docs_[i].value);
    }
    var bar= $('.documentbar');
    var percent= $('.documentbar');
    $.ajax({
        type: "POST",
        url: SiteUrl+"merchant/loan_documents",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (request, xhr) {
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            nextTab();
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
function nextTab(){
    $('#OpenOtpModel').modal('hide');  
          
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
function AddExtraDocs(){
    var html='';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<span class="text-danger" id="itr_error"></span>'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>UPLOAD ITR (OPTIONAL) +</span>'+
            '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`showExtraImage1`,`base_itr_`,`itr_image`)" id="itr_image" multiple class="uploadlogo" />'+
            '</div>'+
        '</div>'+
        '<div id="showExtraImage1" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<span class="text-danger" id="cheque_error"></span>'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>UPLOAD CANCELLED CHEQUE (OPTIONAL) +</span>'+
            '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`showExtraImage2`,`base_canceled_cheque_`,`canceled_cheque`)" id="canceled_cheque" multiple class="uploadlogo" />'+
            '</div>'+
        '</div>'+
        '<div id="showExtraImage2" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    html+='<div class="form-row mt-4">'+
        '<div class="col-12 col-sm-12">'+
            '<span class="text-danger" id="additionaldocs_error"></span>'+
            '<div class="fileUpload blue-btn btn width100">'+
            '<span>UPLOAD OTHER DOCS (OPTIONAL) +</span>'+
            '<input type="file" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx" onchange="ShowSelectImage(this,`showExtraImage3`,`base_additional_docs_`,`additiona_docs`)" id="additiona_docs" multiple class="uploadlogo" />'+
            '</div>'+
        '</div>'+
        '<div id="showExtraImage3" style="width:100%" aria-live="polite"></div>'+
    '</div>';
    return html;
}
function UploadCoApplicantDocs(){
    var html='<div class="progress" style="height: 40px;">'+
            '<div style="font-size: 30px;" class="coapplicant-bar progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">'+
                '0%'+
            '</div>'+
            '<div id="status"></div>'+
        '</div>';
    $('#showcoapplicantbar').html(html);
    var formData = new FormData();
    formData.append('phone', $('#phone').val());

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
    
    var coId = $('[name="getCoId[]"]');
    var l=0;
    coId.each(function(){
        var coval= $(this).val();
        var base_co_pancard_=document.getElementsByName('base_co_pancard_'+coval+'[]');
        for (var j = 0; j <base_co_pancard_.length; j++) {
            formData.append('base_co_pancard_'+l+'[]',base_co_pancard_[j].value);
        }
        l++;
    });

    var bar= $('.coapplicant-bar');
    var percent= $('.coapplicant-bar');
    $.ajax({
        type: "POST",
        url: SiteUrl+"/merchant/UploadCoApplicantDocs",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (request, xhr) {
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            nextTab();
        },
        success: function(response) {
            if(response.status=='success'){
                setTimeout(function(){ 
                    $('#showcoapplicantbar').html('');
                }, 1000);
            }
        },
        xhr: function(){
             var xhr = $.ajaxSettings.xhr() ;
             xhr.upload.onprogress = function(data){
                var perc = Math.round((data.loaded / data.total) * 100);
                $('.coapplicant-bar').text(perc + '%');
                $('.coapplicant-bar').css('width',perc + '%');
             };
             return xhr ;
        },
    });
}
function CheckSelectCity(city,pincode=""){
    if(city=='Other'){
        OtherCity();
    }else{
        $('#other_city_field').html('');
        $('#other_city_field').removeClass('mt-4');
    }
    $('#city_error').html('');
    if(city!=""){
        $.ajax({
            url: SiteUrl+"merchant/CheckSelectCity",
            dataType:'json',
            method:'POST',
            data:{
                'city':city,
                'state':$('#state').val(),
                'pincode':pincode
            },
            success: function(response){
                if(response.status=='fail'){
                    $('#city_error').html('City does not exists in our record.');
                }else{
                    $('#city_error').html('');
                }
                $('#pincode').html(response.pincode);
                if($('#pincode').val()==""){
                    $('#other_pincode_field').html('');
                    $('#other_pincode_field').removeClass('mt-4');
                }
                if($.isFunction(window.PincodeLabel)){
                    PincodeLabel();
                }
            }
        });
    }
}
if($('#state').val()!=""){
    GetCityList($('#state').val(),$('#city_hidden').val());
    if($('#city_hidden').val()!=""){
        CheckSelectCity($('#city_hidden').val(),$('#pincode_hidden').val());
        if($('#pincode_hidden').val()!=''){
            OtherPincode($('#pincode_hidden').val());
        }
    }
}
function OtherCity(){
    var html='<div class="col-12 col-sm-6">'+
    '</div>'+
    '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
        '<div class="md-input">'+
            '<input class="md-form-control" value="'+$('#other_city_hidden').val()+'" id="other_city" type="text" onkeyup="DataSave(this.id,this.value)" required="" title="Other City" />'+
            '<label>Other City</label>'+
            '<small class="text-danger" id="other_city_error"></small>'+
        '</div>'+
    '</div>';
    $('#other_city_field').addClass('mt-4');
    $('#other_city_field').html(html);
}

function OtherPincode(value){
    if(value=='Other'){
        var other_pincode='';
        if($('#other_pincode_hidden').val()!=undefined){
            other_pincode=$('#other_pincode_hidden').val();
        }
        var html='<div class="col-12 col-sm-6">'+
        '</div>'+
        '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
            '<div class="md-input">'+
                `<input class="md-form-control" value="`+other_pincode+`" id="other_pincode" type="text" oninput="this.value = Math.abs(this.value);" minlength="6" maxlength="6" onkeyup="DataSave(this.id,this.value)" required="" title="Other Pincode" />`+
                '<label>Other Pincode</label>'+
                '<small class="text-danger" id="other_pincode_error"></small>'+
            '</div>'+
        '</div>';
        $('#other_pincode_field').addClass('mt-4');
        $('#other_pincode_field').html(html);
    }else{
        $('#other_pincode_field').removeClass('mt-4');
        $('#other_pincode_field').html('');
    }
}
</script>