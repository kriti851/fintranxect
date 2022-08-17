<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
    //if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
     var currentid=$(this).attr('id');
    if(currentid=='next-1'){
        $('#first_name_error').html('');
        $('#last_name_error').html('');
        $('#email_error').html('');
        $('#age_error').html('');
        $('#employment_type_error').html('');
        $('#birthdate_error').html('');
        var first_name=$('#first_name').val();
        if(first_name==""){
            $('#first_name_error').html('The First Name Field Required');
            return false;
        }
        var last_name=$('#last_name').val();
        if(last_name==""){
            $('#last_name_error').html('The Last Name Field Required');
            return false;
        }
        var employment_type=$('#employment_type').val();
        if(employment_type==""){
            $('#employment_type_error').html('The Type Of Occupation Field is Required');
            return false;
        }

        var age=$('#age').val();
        if(age==""){
            $('#age_error').html('The Age Field is Required');
            return false;
        }else if(age>=80){
            $('#age_error').html('Please Enert Correct Age');
            return false;
        }
        var birthdate="";
        if(employment_type=='Business'){
            birthdate=$('#birthdate').val();
            if(birthdate==""){
                $('#birthdate_error').html('The Date of birth Field is Required');
                return false;
            }
        }

        var email=$('#email').val();
        var ajax1=$.ajax({
            url: SiteUrl+"merchant/edit_email_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"email":email,"merchant_id":$('#merchant_id').val()},
            success: function(result){
                if(result.status=="fail"){
                    $('#email_error').html(result.message);
                }              
            }
        });
        
        $.when(ajax1).done(function(a1){
            if(a1.status=="success"){ 
                $.ajax({
                    url: SiteUrl+"merchant/UpdateInfo",
                    method:'POST',
                    cache: false,
                    dataType:"json",
                    data:{'email':email,'first_name':first_name,'last_name':last_name,'age':age,
                        'employment_type':employment_type,'merchant_id':$('#merchant_id').val(),'date_of_birth':birthdate},
                    success: function(result){
                        location.reload();       
                    }
                });
            }
        });
    }
});

$(".previous").click(function(){
	//if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 200, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});
 
$("fieldset").delegate(".removeOrder", "click", function () {  
    $(this).closest('.card').remove();
  }
);  
function MobileValidate() {
    var mob = /^[6-9]{1}[0-9]{9}$/;
    var txtMobile = document.getElementById('phone');
    if (mob.test(txtMobile.value) == false) {
        return false;
    }
    return true;
}
function loadDatePicker(){
    $('.datepickerrange').daterangepicker({ 
        drops:'up',
        singleDatePicker: true,
        showDropdowns: true,
        maxYear:2002,
        minYear: 1940,
        autoUpdateInput: false,
        locale: {
                cancelLabel: 'Clear'
        }
    });
    $('input[name="birthdate"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY'));
    });
}
loadDatePicker();
</script>