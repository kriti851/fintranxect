<script>
    function SubmitComment(){
        $('#comment_error').html();
        if($('#comments').val()==''){
            $('#comment_error').html('The Comment Field is required');
            return false;
        }
        $.ajax({
            url: SiteUrl+"merchant/LenderLeaveComment",
            method:'POST',
            dataType:"json",
            data:{
                "merchant_id":$('#merchant_id').val(),
                "comments":$('#comments').val(),
                "lender_id":$('#lender_id').val()
            },
            success: function(result){
                location.reload();                   
            }
        });
    }

</script>