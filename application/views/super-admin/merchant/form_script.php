<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script>
    "use strict";
//jQuery time
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
        $('#dsaid_error').html('');
        $('#first_name_error').html('');
        $('#last_name_error').html('');
        $('#email_error').html('');
        $('#phone_error').html('');
        $('#age_error').html('');
        $('#employment_type_error').html('');
        $('#birthdate_error').html('');
        var dsaid=$('#dsaid').val();
        if(dsaid==""){
            $('#dsaid_error').html('Please select partner');
            return false;
        }
        var first_name=$('#first_name').val();
        if(first_name==""){
            $('#first_name_error').html('The First Name field is required');
            return false;
        }
        var last_name=$('#last_name').val();
        if(last_name==""){
            $('#last_name_error').html('The Last Name field is required');
            return false;
        }
        var employment_type=$('#employment_type').val();
        if(employment_type==""){
            $('#employment_type_error').html('The Type Of Occupation field is required');
            return false;
        }
        var age=$('#age').val();
        if(age==""){
            $('#age_error').html('The Age field is required');
            return false;
        }else if(age>=80){
            $('#age_error').html('Please Enert Correct Age');
            return false;
        }
        var birthdate='';
        if(employment_type=='Business'){
            birthdate=$('#birthdate').val();
            if(birthdate==""){
                $('#birthdate_error').html('The Date of Birth field is required');
                return false;
            }
        }
        var email=$('#email').val();
        var ajax1=$.ajax({
            url: SiteUrl+"merchant/add_email_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"email":email},
            success: function(result){
                if(result.status=="fail"){
                    $('#email_error').html(result.message);
                }              
            }
        });
        var phone=$('#phone').val();
        var validphone = MobileValidate();
        if(!validphone){
            $('#phone_error').html("Please enter valid mobile number");
            return false;
        }
        var ajax2=$.ajax({
            url: SiteUrl+"merchant/phone_validation",
            method:'POST',
            cache: false,
            dataType:"json",
            data:{"mobile_number":phone},
            success: function(result){
                if(result.status=="fail"){
                    $('#phone_error').html(result.message);
                }              
            }
        });
        $.when(ajax1,ajax2).done(function(a1, a2){
            if(a1[0].status=="success" && a2[0].status=="success"){
                $.ajax({
                    url: SiteUrl+"merchant/IncompleteForm",
                    method:'POST',
                    cache: false,
                    dataType:"json",
                    data:{"phone":phone,'email':email,'first_name':first_name,'last_name':last_name,'age':age,
                        'employment_type':employment_type,'merchant_id':$('#merchant_id').val(),'dsaid':$('#dsaid').val(),
                        'date_of_birth':birthdate
                    },
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

function nextTab(){
    $('#OpenOtpModel').modal('hide');  
          
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    //show the next fieldset
    next_fs.show(); 
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = (now * 50)+"%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'transform': 'scale('+scale+')'});
            next_fs.css({'left': left, 'opacity': opacity});
        }, 
        duration: 200, 
        complete: function(){
            current_fs.hide();
            animating = false;
        }, 
        //this comes from the custom easing plugin
        easing: 'easeOutQuint'
    });
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
</script>