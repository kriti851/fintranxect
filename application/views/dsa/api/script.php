<script>

    function ChangeIpModal(ip_id,ip_address){
        if(ip_id>0){
            $('#ip_id').val(ip_id);
            $('#ip_address').val(ip_address);
        }
        $('#IpModal').modal();
    }
    function SubmitIp(){
        $('#ip_error').html('');
        if($('#ip_address').val()==""){
            $('#ip_error').html(' Please Enter Ip Address');
            return false;
        }
        $.ajax({
            url:SiteUrl+'api/change_ip',
            method:'POST',
            dataType:'json',
            data:{'ip_id':$('#ip_id').val(),'ip_address':$('#ip_address').val()},
            success:function(response){
                location.reload();
            }
        });
    }
</script>