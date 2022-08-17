<script>
   
    function LoggedCase(userid){
        $.ajax({
            url: SiteUrl+"merchant/LoggedCase",
            method:'POST',
            dataType:"json",
            data:{"user_id":userid},
            success: function(result){
                   location.reload();                     
            }
        });
    }
</script>