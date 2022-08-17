<script>
     document.getElementById("profile-li").classList.add("active");
    function AddProfile(){
        $('.invalid').html('');
        $('.add_permission_error').html('');
        var add_title=$('#add_title').val();    
        if(add_title==""){
            $('#add_title').siblings('.invalid').html('The Title Field is Required');
            return false;
        }
        if ($("input[name*='main_permission']:checked").length>0){
        }else{
            $('#add_permission_error').html('Please Select Permission');
            return false;
        }
        var ajax1=$.ajax({
            url: SiteUrl+"profile/unique_title",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"title":add_title},
            success: function(result){
                if(result.status=="fail"){
                    $('#add_title').siblings('.invalid').html(result.message);
                }              
            }
        });
        var formData = new FormData();
        formData.append('title', $('#add_title').val());
        $("input[name*='main_permission']:checked").each(function(){
            formData.append('main_permission[]',$(this).val());
        });
        $("input[name*='sub_permission']:checked").each(function(){
            formData.append('sub_permission[]',$(this).val());
        });
        $.when(ajax1).done(function(a1){
            if(a1.status=="success"){
                $.ajax({
                    type: "POST",
                    url: SiteUrl+"profile/AddProfile",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    }

    function EditProfile(profile_id){
        $('#EditProfileModal').modal('show');
        $.ajax({
            url: SiteUrl+"profile/GetProfile",
            method:'POST',
            cache: false,
            data:{"profile_id":profile_id},
            success: function(result){

                $('#edit-profile-form').html(result);
                var buttonhtml='<button type="button" class="btn btn-primary" onclick="UpdateProfile()">SAVE CHANGES</button>';
                $('#button_edit').html(buttonhtml);
            }
        });
    }
    function UpdateProfile(){
        $('.edit_title_error').html('');
        $('.edit_permission_error').html('');
        var edit_title=$('#edit_title').val();    
        if(edit_title==""){
            $('#edit_title_error').html('The Title Field is Required');
            return false;
        }
        if ($("input[name*='edit_main_permission']:checked").length>0){
        }else{
            $('#edit_permission_error').html('Please Select Permission');
            return false;
        }
        var ajax1=$.ajax({
            url: SiteUrl+"profile/edit_unique_title",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"title":edit_title,'profile_id':$('#profile_id').val()},
            success: function(result){
                if(result.status=="fail"){
                    $('#edit_title_error').html(result.message);
                }              
            }
        });
        var formData = new FormData();
        formData.append('title', $('#edit_title').val());
        formData.append('profile_id', $('#profile_id').val());
        $("input[name*='edit_main_permission']:checked").each(function(){
            formData.append('main_permission[]',$(this).val());
        });
        $("input[name*='edit_sub_permission']:checked").each(function(){
            formData.append('sub_permission[]',$(this).val());
        });
        $.when(ajax1).done(function(a1){
            if(a1.status=="success"){
                $.ajax({
                    type: "POST",
                    url: SiteUrl+"profile/UpdateProfile",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    }
</script>