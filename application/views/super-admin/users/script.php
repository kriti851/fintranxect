<script>
    document.getElementById("profile-li").classList.add("active");
    function GetUserDetail(userid){
        $('#viewdetail').modal('show');
        $('#dsa_user_detail').html('<div class="text-center"><div class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div></div>');
        $.ajax({
            url: SiteUrl+"users/GetUserDetail",
            method:'POST',
            dataType:"json",
            data:{"user_id":userid},
            success: function(result){
                if(result.status=="Success"){
                    var permission="Super Admin";
                    if(result.data.profile_title!=null){
                        permission=result.data.profile_title;
                    }
                    var html='<div class="information" id="dsa-detail">'+
                            '<h4>User Information</h4>'+
                           ' <ul>'+
                                '<li><span>Person Name:</span> '+result.data.full_name+'</li>'+
                                '<li><span>Mobile no:</span> +91 '+result.data.mobile_number+'</li>'+
                                '<li><span>Email:</span> '+result.data.email+'</li>'+
                                '<li><span>Address:</span> '+result.data.address+'</li>'+
                                '<li><span>Pan Number:</span> '+result.data.pan_number+'</li>'+
                                '<li><span>Permission:</span> '+permission+'</li>'+
                            '</ul>'+
                        '</div>';
                    var pan_number="";
                    if(result.data.pan_number!=null){
                        pan_number= result.data.pan_number;
                    }
                    html+='<div style="display:none" id="dsa_user_edit"><form id="user_form"><div class="form-row">'+
                    				'<div class="col-12 col-sm-12">'+
                    					 '<label>Contact Person name</label>'+
                                         '<small class="text-danger invalid"></small>'+
                    					 '<input type="hidden"id="updated_user_id" value="'+result.data.user_id+'" >'+
                    					 '<input class="multisteps-form__input form-control" type="text" id="full_name" placeholder="Name of Contact Person" value="'+result.data.full_name+'" />'+
                    				'</div>'+
                    		 '</div>'+
                               '<div class="form-row mt-4">'+
                    				'<div class="col-12 col-sm-6">'+
                    					'<label>Mobile number</label>'+
                                        '<small class="text-danger invalid"></small>'+
                    				     '<input class="multisteps-form__input form-control" disabled type="text" id="mobile_number" placeholder="Mobile number" value="'+result.data.mobile_number+'"/>'+
                    			    '</div>'+
                                    '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                    				'<label>Email</label>'+
                                    '<small class="text-danger invalid"></small>'+
                    				'<input class="multisteps-form__input form-control" type="text" id="email" placeholder="Mobile number" value="'+result.data.email+'"/>'+
                    			'</div>'+
                    		'</div>'+
                    		
                    		'<div class="form-row mt-4">'+
                    				'<div class="col-12 col-sm-6">'+
                    				'<label>Pan no</label>'+
                                    '<small class="text-danger invalid"></small>'+
                    				 '<input class="multisteps-form__input form-control" type="text" id="pan_number" placeholder="Pan no"  value="'+pan_number+'" />'+
                    			'</div>'+
                    			'<div class="col-12 col-sm-6  mt-4 mt-sm-0">'+
                    					'<label>Address</label>'+
                                        '<small class="text-danger invalid"></small>'+
                    						'<input class="multisteps-form__input form-control" id="address" type="text" placeholder="Address" value="'+result.data.address+'"/>'+
                    				'</div>'+
                    		'</div>'+	
                            '<div class="form-row mt-4">'+
                                '<div class="col-12 col-sm-6">'+
                                    '<label>Permission</label>'+
                                    '<small class="text-danger invalid"></small>'+
                                    '<select class="multisteps-form__input form-control" id="permission">'+
                                        result.data.permission
                                    +'</select>'+
                                '</div>'+
                                '<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                                    '<label>Change Password (Optional)</label>'+
                                    '<small class="text-danger invalid"></small>'+
                                   ' <input class="multisteps-form__input form-control" type="password" id="password" placeholder="Password"/>'+
                                '</div>'+
                                '<div class="form-row mt-4">'+
                                    result.data.dsa_permission+
                                '</div>'+
                            '</div>'+			
                    		'</form>'+
                    		
                    		'</div>';
                        $('#dsa_user_detail').html(html);
                        $('#button_dsa').html('<button type="button" onclick="EditProfile()" class="btn btn-primary" >Edit</button>');
                }else{
                    $('#dsa_user_detail').html(result.message);
                }                          
            }
        });
    }
    function EditProfile(){
        $('#myModalLabel').html('User Information Edit');
        $('#dsa-detail').hide();
        $('#dsa_user_edit').show();
        $('#button_dsa').html('<button type="button" onclick="UpdateProfile()" class="btn btn-primary" >SAVE CHANGES <span id="update_loader"></span></button>');
    }
    function UpdateProfile(){
        $('.invalid').html('');
        var full_name=$('#full_name').val();
        if(full_name==""){
            $('#full_name').siblings('.invalid').html('The Full Name Field is Required');
            return false;
        }
        var email=$('#email').val();
        if(email==""){
            $('#email').siblings('.invalid').html('The Email Field id Required');
            return false;
        }
        var address=$('#address').val();
        if(address==""){
            $('#address').siblings('.invalid').html('The Address Field Required');
            return false;
        }
        var k=[];
        var checkboxes = document.querySelectorAll('input[name="multi_dsa_editid[]"]:checked')
        for (var i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].value!='on'){
                k.push(checkboxes[i].value)
            }
        }
        if(k!="" || $('#permission').val()==''){}else{
            $('#partner_error').html('The Partner field is Required');
            return false;
        }

        var ajax1=$.ajax({
            url: SiteUrl+"users/edit_email_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"email":email,'user_id':$('#updated_user_id').val()},
            success: function(result){
                if(result.status=="fail"){
                    $('#email').siblings('.invalid').html(result.message);
                }              
            }
        });
        
        $.when(ajax1).done(function(a1){
            if(a1.status=="success"){
                $('#update_loader').html('<div style="width:17px;height:17px;" class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div>');
                var full_name=$('#full_name').val();
                var email=$('#email').val();
                var address=$('#address').val();
                var pan_number=$('#pan_number').val();
                $.ajax({
                    url: SiteUrl+"users/UpdateProfile",
                    method:'POST',
                    dataType:"json",
                    data:{"full_name":full_name,
                        "email":email,
                        "address":address,
                        "password":$('#password').val(),
                        "profile_id":$('#permission').val(),
                        "user_id":$('#updated_user_id').val(),
                        "pan_number":pan_number,
                        "dsa_id":k
                    },
                    success: function(result){
                        if(result.status=="Success"){
                            location.reload();
                        }                        
                    }
                });
            }
        });
    }
    function AddUser(){
        $('.invalid').html('');
        $('#partner_error').html('');
        var add_full_name=$('#add_full_name').val();
        if(add_full_name==""){
            $('#add_full_name').siblings('.invalid').html('The Full Name Field is Required');
            return false;
        }
        var add_mobile_number=$('#add_mobile_number').val();
        if(add_mobile_number==""){
            $('#add_mobile_number').siblings('.invalid').html('The Mobile Number Field is Required');
            return false;
        }else{
            var valid=MobileValidate();
            if(!valid){
                $('#add_mobile_number').siblings('.invalid').html('Please Enter Valid Mobile Number');
                return false;
            }
        }
        var add_email=$('#add_email').val();
        if(add_email==""){
            $('#add_email').siblings('.invalid').html('The Email Field id Required');
            return false;
        }
        var add_address=$('#add_address').val();
        if(add_address==""){
            $('#add_address').siblings('.invalid').html('The Address Field Required');
            return false;
        }
        var add_password=$('#add_password').val();
        if(add_password==""){
            $('#add_password').siblings('.invalid').html('The password Field Required');
            return false;
        }

        var k=[];
        var checkboxes = document.querySelectorAll('input[name="multi_dsa_id[]"]:checked')
        for (var i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].value!='on'){
                k.push(checkboxes[i].value)
            }
        }
        if(k!="" || $('#add_permission').val()==''){}else{
            $('#partner_error').html('The Partner field is Required');
            return false;
        }
        var ajax1=$.ajax({
            url: SiteUrl+"users/email_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"email":add_email},
            success: function(result){
                if(result.status=="fail"){
                    $('#add_email').siblings('.invalid').html(result.message);
                }              
            }
        });
        var ajax2=$.ajax({
            url: SiteUrl+"users/phone_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"mobile_number":add_mobile_number},
            success: function(result){
                if(result.status=="fail"){
                    $('#add_mobile_number').siblings('.invalid').html(result.message);
                    return false;
                }              
            }
        });
        $.when(ajax1,ajax2).done(function(a1, a2){
            if(a1[0].status=="success" && a2[0].status=="success"){
                $('#add_loader').html('<div style="width:17px;height:17px;" class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div>');
                $.ajax({
                    url: SiteUrl+"users/add_user",
                    method:'POST',
                    cache: false,
                    dataType:"json",
                    data:{
                        "full_name":add_full_name,
                        "mobile_number":add_mobile_number,
                        "passwrod":add_password,
                        "profile_id":$('#add_permission').val(),
                        "email":add_email,
                        "pan_number":$('#add_pan_number').val(),
                        "address":add_address,
                        "dsa_id":k
                    },
                    success: function(result){
                        if(result.status=="success"){
                            location.reload();
                        }              
                    }
                });
            }
        });
    }
    function MobileValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('add_mobile_number');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
$("#select-all").click(function(){
    $('input[name="multi_dsa_id[]"]').not(this).prop('checked', this.checked);
});
function selectFunct(val){
    $('input[name="multi_dsa_editid[]"]').not(this).prop('checked', val.checked);
}
</script>