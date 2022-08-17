function SubmitPartnerWithUs(){
    $('.invalid-str').html('');
    if($('#partner_name').val()==""){
        $('#partner_name').siblings(".invalid-str").html("The Name Field is Required.");
        return false;
    }
    if($('#partner_email').val()==""){
        $('#partner_email').siblings(".invalid-str").html("The Email Field is Required.");
        return false;
    }else{
        var valid=validateEmail($('#partner_email').val());
        if(!valid){
            $('#partner_email').siblings(".invalid-str").html("Please Enter a valid Email Address.");
            return false;
        }
    }
    if($('#partner_mobile_number').val()==""){
        $('#partner_mobile_number').siblings(".invalid-str").html("The Mobile Number Field is Required.");
        return false;
    }
    if($('#partner_comments').val()==""){
        $('#partner_comments').siblings(".invalid-str").html("The Comments Field is Required.");
        return false;
    }

    $.ajax({
        url: SiteUrl+"ajax/PartnerWithUs",
        method:'POST',
        dataType:"json",
        data:{
            'name':$('#partner_name').val(),
            'email':$('#partner_name').val(),
            'mobile_number':$('#partner_mobile_number').val(),
            'business_url':$('#partner_business_url').val(),
            'comments':$('#partner_comments').val()
        },
        success: function(result){
            if(result.status=='success'){
                document.getElementById('show_message').classList.add("text-success");
                $('#show_message').html('Thanks for connecting with us.');
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }else{
                document.getElementById('show_message').classList.add("text-danger");
                $('#show_message').html('Server error Occured!');
            }
        }
    });

}
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}