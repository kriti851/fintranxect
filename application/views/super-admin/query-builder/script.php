<script>
    function DatepickerOperator(keyword, value){
        if(value=='BETWEEN' || value=='NOT BETWEEN'){
            $('input[name="'+keyword+'"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
            $('input[name="'+keyword+'"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            });

        }else if(value=='IN(...)' || value=='NOT IN(...)' || value=="IS NULL" || value=="IS NOT NULL"){
            $('input[name="'+keyword+'"]').data('daterangepicker').remove()
        }else{
            $('input[name="'+keyword+'"]').daterangepicker({
                autoUpdateInput: false,
                //autoApply:true,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
            $('input[name="'+keyword+'"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
        }
    }
    
    DatepickerOperator('users_created_at','=');
    DatepickerOperator('users_received_time','=');
    DatepickerOperator('users_short_close_time','=');
    DatepickerOperator('users_comment_time','=');
    DatepickerOperator('users_remark_time','=');
    DatepickerOperator('date_of_birth','=');
</script>