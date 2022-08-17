<script>
    function GetCityList(id){
        $.ajax({
            url:SiteUrl+'setting/pincode/GetCityList',
            method:'post',
            data:{
                'state_id':id
            },
            success:function(response){
                $('#city').html(response);
            }
        });
    }
    $('.next').on('click',function(){
        $('.text-danger').html('');
        if($('#state_id').val()==""){
            $('#state_id').siblings('.text-danger').html('The State field is Required');
            return false;
        }
        if($('#city').val()==""){
            $('#city').siblings('.text-danger').html('The City field is Required');
            return false;
        }
        if($('#pincode').val()==""){
            $('#pincode').siblings('.text-danger').html('The Pincode field is Required');
            return false;
        }else{
            var valid = PincodeValidation($('#pincode').val());
            if(!valid){
                $('#pincode').siblings('.text-danger').html('The Pincode enter valid pincode');
                return false;
            }else{
                $('#pincodeform').submit();
            }
        }
    });
    function Delete(id){      
        $('#deleteconfirm').attr('href',SiteUrl+'setting/pincode/delete/'+id);  
        $('#DeleteModal').modal('show');
    }
    function PincodeValidation(val){
        var pinvalid=/^\d{6}$/;
        if (val.search(pinvalid) == -1) {
            return false;
        }
        return true;
    }
</script>