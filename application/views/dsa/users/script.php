<script>
    function AddUser(){
        var html=`<div class="modal-dialog modal-lg">`+
                `<div class="modal-content">`+
                    `<div class="modal-header">`+
                        `<h4 class="modal-title">Edit User</h4>`+
                        `<button type="button" class="close" data-dismiss="modal" aria-label="Close">`+
                            `<span aria-hidden="true">&times;</span>`+
                        `</button>`+
                    `</div>`+
                    `<div class="modal-body">`+
                        `<div class="text-center"><div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div></div>`+
                    `</div>`+
                `</div>`+
            `</div>`;
        $('#usermodal').html(html);
        $('#usermodal').modal('show');
        $.ajax({
            url:SiteUrl+"users/add_",
            method:'POST',
            dataType:'json',
            success:function(response){
                var html=`<div class="modal-dialog modal-lg">`+
                        `<div class="modal-content">`+
                            `<div class="modal-header">`+
                                `<h4 class="modal-title">Add User</h4>`+
                                `<button type="button" class="close" data-dismiss="modal" aria-label="Close">`+
                                    `<span aria-hidden="true">&times;</span>`+
                                `</button>`+
                            `</div>`+

                            `<div class="modal-body">`+
                                `<div class="form-row" id="alert_message">`+

                                ` </div>`+
                                `<div class="form-row">`+
                                    `<div class="col-6 col-sm-6">`+
                                        `<label>Full Name <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="text" id="full_name" placeholder="Full Name" >`+
                                    `</div>`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Company Name <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="text" id="company_name" placeholder="Company Name" >`+
                                    `</div>`+
                            `</div>`+
                            `<div class="form-row">`+
                                    `<div class="col-6 col-sm-6">`+
                                        `<label>Email <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="text" id="email" placeholder="Email" >`+
                                    `</div>`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Mobile Number <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="text" id="mobile_number" placeholder="Mobile NUmber" >`+
                                    `</div>`+
                            ` </div>`+
                            `<div class="form-row">`+
                                    `<div class="col-6 col-sm-6">`+
                                        `<label>Adress <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="text" id="address" placeholder="Address" >`+
                                    `</div>`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Permission <span class="text-danger"></span></label>`+
                                        `<select class="multisteps-form__input form-control" id="permission">`+response.html+`</select>`+
                                    `</div>`+
                            ` </div>`+
                            `<div class="form-row">`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Password <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="password" id="password" placeholder="Password" >`+
                                    `</div>`+
                            ` </div>`+
                            `</div>`+

                            `<div class="modal-footer">`+
                                `<a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal">Close</a>`+
                                `<a href="javascript:void(0)" id="modal-submit" class="btn btn-primary" onclick="AddUserSubmit()">Submit</a>`+
                            `</div>`+
                        `</div>`+
                    `</div>`;
                $('#usermodal').html(html);
                $('#usermodal').modal('show');
            }
        });
    }
    function AddUserSubmit(){
        $('#alert_message').html('');
        if($('#full_name').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Full Name Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        if($('#company_name').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Company Name Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        if($('#email').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Email Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }else{
            var emailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
            if(!$('#email').val().match(emailFormat))
            {
                var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                    `Please Enter Valid Email Address`+
                `</div>`;
                $('#alert_message').html(alert);
                return false;
            }
        }
        if($('#mobile_number').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Mobile Number Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }else{
            if(!MobileValidate($('#mobile_number').val()))
            {
                var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                    `Please Enter Valid Mobile Number`+
                `</div>`;
                $('#alert_message').html(alert);
                return false;
            }
        }
        if($('#address').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Address Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        if($('#password').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Password Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        $('#modal-submit').attr('disabled',true);
        $.ajax({
            url:SiteUrl+"users/adduser",
            method:'POST',
            dataType:'json',
            data:{
                'full_name':$('#full_name').val(),
                'company_name':$('#company_name').val(),
                'email':$('#email').val(),
                'mobile_number':$('#mobile_number').val(),
                'address':$('#address').val(),
                'password':$('#password').val(),
                'permission':$('#permission').val()
            },
            success:function(response){
                if(response.status=='failure'){
                    var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                    response.message+
                    `</div>`;
                    $('#alert_message').html(alert);
                    setTimeout(() => {
                        $('#modal-submit').attr('disabled',false);
                    }, 100);
                }else{
                    var alert=`<div class="alert alert-success" style="width: 100%;text-align: center;" role="alert">`+
                    response.message+
                    `</div>`;
                    $('#alert_message').html(alert);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            }
        });
    }
    function MobileValidate(phone) {
        var mob = /^[6-9]{1}[0-9]{9}$/;
        if (mob.test(phone.trim()) == false) {
            return false;
        }
        return true;
    }
    function UpdateUser(id){
        var html=`<div class="modal-dialog modal-lg">`+
                `<div class="modal-content">`+
                    `<div class="modal-header">`+
                        `<h4 class="modal-title">Edit User</h4>`+
                        `<button type="button" class="close" data-dismiss="modal" aria-label="Close">`+
                            `<span aria-hidden="true">&times;</span>`+
                        `</button>`+
                    `</div>`+
                    `<div class="modal-body">`+
                        `<div class="text-center"><div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div></div>`+
                    `</div>`+
                `</div>`+
            `</div>`;
        $('#usermodal').html(html);
        $('#usermodal').modal('show');
        $.ajax({
            url:SiteUrl+"users/getuser",
            method:'POST',
            dataType:'json',
            data:{
                'user_id':id
            },
            success:function(response){
                setTimeout(() => {
                    var html=`<div class="modal-dialog modal-lg">`+
                        `<input value="`+response.data.user_id+`" type="hidden" id="user_id" >`+
                        `<div class="modal-content">`+
                            `<div class="modal-header">`+
                                `<h4 class="modal-title">Edit User</h4>`+
                                `<button type="button" class="close" data-dismiss="modal" aria-label="Close">`+
                                    `<span aria-hidden="true">&times;</span>`+
                                `</button>`+
                            `</div>`+
                            `<div class="modal-body">`+
                                `<div class="form-row" id="alert_message">`+

                                ` </div>`+
                                `<div class="form-row">`+
                                    `<div class="col-6 col-sm-6">`+
                                        `<label>Full Name <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" value="`+response.data.full_name+`" type="text" id="full_name" placeholder="Full Name" >`+
                                    `</div>`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Company Name <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" value="`+response.data.company_name+`" type="text" id="company_name" placeholder="Company Name" >`+
                                    `</div>`+
                            `</div>`+
                            `<div class="form-row">`+
                                    `<div class="col-6 col-sm-6">`+
                                        `<label>Email <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" value="`+response.data.email+`" type="text" id="email" placeholder="Email" >`+
                                    `</div>`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Mobile Number <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" value="`+response.data.mobile_number+`" type="text" id="mobile_number" placeholder="Mobile NUmber" >`+
                                    `</div>`+
                            ` </div>`+
                            `<div class="form-row">`+
                                    `<div class="col-6 col-sm-6">`+
                                        `<label>Adress <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" value="`+response.data.address+`" type="text" id="address" placeholder="Address" >`+
                                    `</div>`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Permission <span class="text-danger"></span></label>`+
                                        `<select class="multisteps-form__input form-control" id="permission">`+response.data.select+`</select>`+
                                    `</div>`+
                            ` </div>`+
                            `<div class="form-row">`+
                                    `<div class="col-12 col-sm-6 mt-4 mt-sm-0">`+
                                        `<label>Password <span class="text-danger"></span></label>`+
                                        `<input class="multisteps-form__input form-control" type="password" id="password" placeholder="Password" >`+
                                    `</div>`+
                            ` </div>`+
                            `</div>`+

                            `<div class="modal-footer">`+
                                `<a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal">Close</a>`+
                                `<a href="javascript:void(0)" id="modal-submit" class="btn btn-primary" onclick="UpdateUserSubmit()">Submit</a>`+
                            `</div>`+
                        `</div>`+
                    `</div>`;
                    $('#usermodal').html(html);
                }, 400);
            }
        });
    }
    function UpdateUserSubmit(){
        $('#alert_message').html('');
        if($('#full_name').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Full Name Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        if($('#company_name').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Company Name Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        if($('#email').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Email Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }else{
            var emailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
            if(!$('#email').val().match(emailFormat))
            {
                var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                    `Please Enter Valid Email Address`+
                `</div>`;
                $('#alert_message').html(alert);
                return false;
            }
        }
        if($('#mobile_number').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Mobile Number Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }else{
            if(!MobileValidate($('#mobile_number').val()))
            {
                var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                    `Please Enter Valid Mobile Number`+
                `</div>`;
                $('#alert_message').html(alert);
                return false;
            }
        }
        if($('#address').val()==""){
            var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                `The Address Field is Required.`+
            `</div>`;
            $('#alert_message').html(alert);
            return false;
        }
        $('#modal-submit').attr('disabled',true);
        $.ajax({
            url:SiteUrl+"users/updateuser",
            method:'POST',
            dataType:'json',
            data:{
                'user_id':$('#user_id').val(),
                'full_name':$('#full_name').val(),
                'company_name':$('#company_name').val(),
                'email':$('#email').val(),
                'mobile_number':$('#mobile_number').val(),
                'address':$('#address').val(),
                'password':$('#password').val(),
                'permission':$('#permission').val()
            },
            success:function(response){
                if(response.status=='failure'){
                    var alert=`<div class="alert alert-danger" style="width: 100%;text-align: center;" role="alert">`+
                    response.message+
                    `</div>`;
                    $('#alert_message').html(alert);
                    setTimeout(() => {
                        $('#modal-submit').attr('disabled',false);
                    }, 100);
                }else{
                    var alert=`<div class="alert alert-success" style="width: 100%;text-align: center;" role="alert">`+
                    response.message+
                    `</div>`;
                    $('#alert_message').html(alert);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            }
        });
    }
</script>