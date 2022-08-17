<script>
    $('input[name="rangepicker"]').daterangepicker({
        autoUpdateInput: true,
        //autoApply:true,
        singleDatePicker: false
    });
    $("#select-all").click(function(){
        $('input[name="multi_id[]"]').not(this).prop('checked', this.checked);
    });
</script>