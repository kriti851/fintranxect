function SendOtp(){
    var mobile_number=$('#mobile_phone').val();
    $('#mobile_number_error').html('');
    if(mobile_number!=""){
        $.ajax({
            url: SiteUrl+"/ajax/send_otp_phone",
            method:'POST',
            dataType:"json",
            data:{"mobile_number":mobile_number},
            success: function(result){
                if(result.status=="fail"){
                    $('#mobile_number_error').html(result.message);
                   return false;
                }else{
                    var html='<div class="col-12 col-sm-12">'+
                        '<span class="text-danger" id="forgot_otp_error"></span>'+
                        '<input  id="mobile_phone" type="hidden" value="'+mobile_number+'" />'+
                        '<input class="multisteps-form__input form-control" id="forgot_otp" type="text" placeholder="Enter Otp" />'+
                    '</div>';
                    $('#forgot-password').html(html);
                    $('#forgot-button').html('<button type="button" onclick="VerifyOtp()" class="btn btn-primary">Verify Otp</button>');
                }                 
            }
        });
    }else{
        $('#mobile_number_error').html('Mobile Number Required');
    }
}
function VerifyOtp(){
    var mobile_number=$('#mobile_phone').val();
    var otp=$('#forgot_otp').val();
    $('#forgot_otp_error').html('');
    $.ajax({
        url: SiteUrl+"/ajax/verify_otp",
        method:'POST',
        dataType:"json",
        data:{"mobile_number":mobile_number,"otp":otp},
        success: function(result){
            if(result.status=="fail"){
                $('#forgot_otp_error').html(result.message);
               return false;
            }else{
            var html='<div class="col-12 col-sm-12">'+
                    '<span class="text-danger" id="new_password_error"></span>'+
                    '<input  id="mobile_phone" type="hidden" value="'+mobile_number+'" />'+
                    '<input class="multisteps-form__input form-control" id="new_password" type="password" placeholder="Enter New Password" />'+
                '</div>';
                html+='<div class="col-12 col-sm-12">'+
                    '<span class="text-danger" id="confirm_password_error"></span>'+
                    '<input class="multisteps-form__input form-control" id="confirm_password" type="password" placeholder="Enter Confirm Password" />'+
                '</div>';
                $('#forgot-password').html(html);
                $('#forgot-button').html('<button type="button" onclick="SubmitPassword()" class="btn btn-primary">Change Password</button>');
                
            }                 
        }
    });
}
function SubmitPassword(){
    var mobile_number=$('#mobile_phone').val();
    var new_password=$('#new_password').val();
    var confirm_password=$('#confirm_password').val();
    $('#new_password_error').html('');
    $('#confirm_password_error').html('');
    if(new_password==""){
        $('#new_password_error').html('New Password Field Required');
        return false;
    }
    if(new_password!=confirm_password){
        $('#confirm_password_error').html('Password Not Match');
        return false;
    }
    $.ajax({
        url: SiteUrl+"/ajax/updatePassword",
        method:'POST',
        dataType:"json",
        data:{"mobile_number":mobile_number,"password":new_password},
        success: function(result){
            location.reload();       
        }
    });
}