<script>
    function SubmitComment(id,by){
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
                "comment":$('#comments').val(),
                "comment_by":id,
                "comment_for":by
            },
            success: function(result){
                location.reload();                   
            }
        });
    }

</script>