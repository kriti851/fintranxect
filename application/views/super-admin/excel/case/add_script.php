<script>
    function ShowImage(file){
        $('#file_error').html('');
        var extension = file.files[0].name.split('.').pop().toLowerCase();
        if(extension=='xlsx' || extension=='csv'){
           $('#showfile').html(file.files[0].name);
        }else{
            $('#file_error').html('Only xlsx,csv extension allowed');
        }
        
    }
    
</script>