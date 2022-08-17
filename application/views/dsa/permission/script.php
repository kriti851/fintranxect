<script>
    function Add(){
        var html=`<div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Permission</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center"><div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div></div>
                    </div>
                </div>
            </div>`;
        $('#permissionmodal').html(html);
        $('#permissionmodal').modal('show');
        $.ajax({
            url:SiteUrl+'permission/add',
            datatype:'json',
            method:'POST',
            success:function(response){
                var html=`<div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Permission</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row" id="error">
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-sm-12">
                                        <label>Title</label>
                                        <input class="multisteps-form__input form-control" type="text" id="title" placeholder="Permission Title" value="" />
                                    </div>
                                </div>
                                `+response.html+`
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="submitbtn" onclick="AddPermission()" class="btn btn-primary">SAVE
                                    <span id="loader"></span>
                                </button>
                            </div>
                        </div>
                    </div>`;
                $('#permissionmodal').html(html);
            }
        });
    }

    function AddPermission(){
        $('#error').html('');
        if($('#title').val()==""){
            $('#error').html(`<div style="width: 100%;text-align: center;" class="alert alert-danger" role="alert">
                The Title Field is Required
            </div>`);
            return false;
        }
        var formData = new FormData();
        formData.append('title', $('#title').val());
        $("input[name*='main_permission']:checked").each(function(){
            formData.append('main_permission[]',$(this).val());
        });
        $("input[name*='sub_permission']:checked").each(function(){
            formData.append('sub_permission[]',$(this).val());
        });
        $.ajax({
            url:SiteUrl+'permission/addform',
            method:'POST',
            data:formData,
            processData: false,
            contentType: false,
            beforeSend:function(){
                $('#loader').html('<div style="width:17px;height:17px;" class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div>');
                $('#submitbtn').attr('disabled',true);
            },
            success:function(response){
                if(response.status=='success'){
                    location.reload();
                }else{
                    $('#loader').html('');
                    $('#submitbtn').attr('disabled',false);
                    $('#error').html(`<div style="width: 100%;text-align: center;" class="alert alert-danger" role="alert">
                        Something Went Wrong
                    </div>`);
                }
            }
        });
    }
    function Update(permission_id){
        var html=`<div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Permission</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center"><div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div></div>
                    </div>
                </div>
            </div>`;
        $('#permissionmodal').html(html);
        $('#permissionmodal').modal('show');
        $.ajax({
            url:SiteUrl+'permission/edit',
            datatype:'json',
            data:{
                id:permission_id
            },
            method:'POST',
            success:function(response){
                var html=`<div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Permission</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row" id="error">
                                </div>
                                `+response.html+`
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="submitbtn" onclick="UpdatePermission()" class="btn btn-primary">UPDATE
                                    <span id="loader"></span>
                                </button>
                            </div>
                        </div>
                    </div>`;
                $('#permissionmodal').html(html);
            }
        });
    }
    function UpdatePermission(){
        $('#error').html('');
        if($('#title').val()==""){
            $('#error').html(`<div style="width: 100%;text-align: center;" class="alert alert-danger" role="alert">
                The Title Field is Required
            </div>`);
            return false;
        }
        var formData = new FormData();
        formData.append('id', $('#id').val());
        formData.append('title', $('#title').val());
        $("input[name*='main_permission']:checked").each(function(){
            formData.append('main_permission[]',$(this).val());
        });
        $("input[name*='sub_permission']:checked").each(function(){
            formData.append('sub_permission[]',$(this).val());
        });
        $.ajax({
            url:SiteUrl+'permission/updateform',
            method:'POST',
            data:formData,
            processData: false,
            contentType: false,
            beforeSend:function(){
                $('#loader').html('<div style="width:17px;height:17px;" class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div>');
                $('#submitbtn').attr('disabled',true);
            },
            success:function(response){
                if(response.status=='success'){
                    location.reload();
                }else{
                    $('#loader').html('');
                    $('#submitbtn').attr('disabled',false);
                    $('#error').html(`<div style="width: 100%;text-align: center;" class="alert alert-danger" role="alert">
                        Something Went Wrong
                    </div>`);
                }
            }
        });
    }
</script>