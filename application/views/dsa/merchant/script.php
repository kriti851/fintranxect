<script>
    //document.getElementById("merchant-li").classList.add("active");
   
    function ApplyDownload(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        if(val!=""){
            $('#filter_case_form').submit();
        }else{
            $.notify('Please select business type.','error');
        }
    }
</script>