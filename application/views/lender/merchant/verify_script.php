<script>
    function BtnEnabled(){
        /* $('#singlebutton').prop('disabled', true);
        var status = $('input[name="verify_status"]:checked').val();
        if(status){ */
            var message= $('textarea#message').val();
            if(message.length>2){
                $('#singlebutton').prop('disabled', false);
            }
        //}
    }
    $('#singlebutton').click(function(){
        $.ajax({
            url: SiteUrl+"merchant/IsVerifyRequest",
            method:'POST',
            dataType:"json",
            data:{
                "assign_id":$('#assign_id').val(),
               // "status":$('input[name="verify_status"]:checked').val(),
                "message":$('textarea#message').val()
            },
            success: function(result){
                location.reload();                     
            }
        });
    });
    $('#DisbursedSubmit').click(function(){
        if($('#disbursed_amount').val()==""){
            $('#disbursederror').html('The Disburse Amount filed is required');
            return false;
        }
        $.ajax({
            url: SiteUrl+"merchant/disburse",
            method:'POST',
            dataType:"json",
            data:{
                "merchant_id":$('#disbursed_id').val(),
                "disburse_amount":$('#disburse_amount').val()
            },
            success: function(result){
               window.location.href=SiteUrl+'merchant';                    
            }
        });
    });

</script>