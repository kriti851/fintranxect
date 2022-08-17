<script>
    function isresolved(remark_id){
        var isresolevd='';
        if($('#isresolved' + remark_id).is(":checked")==true){
                isresolevd='YES';
        }else{
                isresolved='NO';
        }
        $.ajax({
                url: SiteUrl+"merchant/IsRemarked",
                method:'POST',
                dataType:"json",
                data:{
                        "remark_id":remark_id,
                        "is_resolved":isresolevd
                },
                success: function(result){
                    if(isresolevd=='YES'){
                        $('#update-resolved-'+remark_id).html('RESOLVED');
                    }else{  
                        $('#update-resolved-'+remark_id).html('PENDING'); 
                    } 
                }
        });
    }
</script>