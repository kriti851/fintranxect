<script>
    $('.checkbox_lender').click(function(){
        if ($("input:checkbox:checked").length > 0)
        {
            $('#assign_btn').prop('disabled', false);
        }
        else
        {
            $('#assign_btn').prop('disabled', true);
        }
    });
    $('#assign_btn').click(function(){
        var array=[];
        $("input:checkbox:checked").each(function(){
            array.push($(this).val());
        });
       
        $.ajax({
            url: SiteUrl+"merchant/loggedLenderToMerchant",
            method:'POST',
            dataType:"json",
            data:{
                "multi_lender_id":array,
                "merchant_id":$('#merchant_id').val(),
                "logged_type":$('#logged_Type').val()
            },
            success: function(result){
                if(result.status=="Success"){
                    window.history.back();
                }                    
            }
        });
    });
</script>