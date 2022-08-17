<script>
    function StateEdit(id,value){
        $('#stateid').val(id);
        $('#statename').val(value);
        $('#StateEdit').modal('show')
    }
    function StateSubmit(){
        $('.invalid').html('');
        if($('#statename').val()==""){
            $('.invalid').html('The State Name field is Required.');
            return false;
        }
        $.ajax({
            url:SiteUrl+'setting/state/StateEdit',
            dataType:'json',
            method:'POST',
            data:{
                'statename':$('#statename').val(),
                'stateid':$('#stateid').val()
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