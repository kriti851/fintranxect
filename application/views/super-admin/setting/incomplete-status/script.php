<script>
    function StatusEdit(id,value){
        $('#id').val(id);
        $('#title').val(value);
        $('#StatusEdit').modal('show')
    }
    function StatusSubmit(){
        $('.invalid').html('');
        if($('#title').val()==""){
            $('.invalid').html('The title field is Required.');
            return false;
        }
        $.ajax({
            url:SiteUrl+'setting/status/StatusEdit',
            dataType:'json',
            method:'POST',
            data:{
                'title':$('#title').val(),
                'id':$('#id').val()
            },
            success:function(response){
                if(response.status=='success'){
                    location.reload();
                }else{
                    $('.invalid').html(response.error);
                    return false;
                }
            }
        });
    }
</script>