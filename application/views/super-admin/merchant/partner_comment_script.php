<script>
    function SubmitComment(){
        $('#comment_error').html();
        if($('#comments').val()==''){
            $('#comment_error').html('The Comment Field is required');
            return false;
        }
        $.ajax({
            url: SiteUrl+"merchant/LeaveComment",
            method:'POST',
            dataType:"json",
            data:{
                "merchant_id":$('#merchant_id').val(),
                "comments":$('#comments').val(),
                "partner_id":$('#partner_id').val()
            },
            success: function(result){
                location.reload();                   
            }
        });
    }

</script>