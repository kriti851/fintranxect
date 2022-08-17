<script>
    document.getElementById("lender-li").classList.add("active");
    //window.history.replaceState({}, document.title,SiteUrl+'merchant');
    function GetUserDetail(userid){
        $('#viewdetail').modal('show');
        $('#user_detail').html('<div class="text-center"><div class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div></div>');
        $.ajax({
            url: SiteUrl+"merchant/GetUserDetail",
            method:'POST',
            dataType:"json",
            data:{"user_id":userid},
            success: function(result){
                if(result.status=="Success"){
                    var html='<div class="information" id="dsa-detail">'+
                            '<h4>Merchant Information</h4>'+
                           ' <ul>'+
                                '<li><span>Person Name:</span> '+result.data.full_name+'</li>'+
                                '<li><span>Mobile no:</span> +91 '+result.data.mobile_number+'</li>'+
                                '<li><span>Email:</span> '+result.data.email+'</li>'+
                                '<li><span>GST no:</span> '+result.data.gst_number+'</li>'+
                                '<li><span>Pan no:</span> '+result.data.pan_number+'</li>'+
                                '<li><span>Age:</span> '+result.data.age+'</li>'+
                                '<li><span>Address:</span> '+result.data.address1+'</li>'+
                                '<li><span>Vintage:</span> '+result.data.vintage+'</li>'+
                                '<li><span>Turn Over:</span> '+result.data.turn_over+'</li>'+
                                '<li><span>Business:</span> '+result.data.company_name+'</li>'+
                                '<li><span>Business Type:</span> '+result.data.business_type+'</li>'+
                                '<li><span>Refrence:</span> '+result.data.reference+'</li>'+
                            '</ul>';
                        var dsa=    result.data.dsa
                        if(dsa!=""){
                            html+='<h4>DSA Detatil</h4>'+
                           ' <ul>'+
                                '<li><span>DSA ID:</span> '+dsa.file_id+'</li>'+
                                '<li><span>DSA Name:</span> '+dsa.full_name+'</li>'+
                                '<li><span>Mobile no:</span> +91 '+dsa.mobile_number+'</li>'+
                                '<li><span>Mobile no:</span> '+dsa.email+'</li>'+
                            '</ul>';
                        }
                        if(result.data.partner!=""){
                            if(result.data.business_type=='Partnership'){
                                html+='<h4>Partner Detail</h4>';
                            }else if(result.data.business_type=='Proprietor'){
                                html+='<h4>Proprietor Detail</h4>';
                            }else{
                                html+='<h4>Director Detail</h4>';
                            }
                            html+='<table class="table">'+
                                '<thead>'+
                                    '<tr>'+
                                    '<th scope="col">Pan Number</th>'+
                                    '<th scope="col">Phone</th>'+
                                    '<th scope="col">Office Address</th>'+
                                    '<th scope="col">Home Address</th>'+
                                    '</tr>'+
                                '</thead>';
                            var partners =result.data.partner;
                            partners.forEach(function (partner) { 
                                html+='<tbody>'+
                                    '<tr>'+
                                    '<td>'+partner.pan_number+'</td>'+
                                    '<td>'+partner.phone_number+'</td>'+
                                    '<td>'+partner.office_address+'</td>'+
                                    '<td>'+partner.home_address+'</td>'+
                                    '</tr>';
                            });
                            html+='</tbody></table>' 
                        }
                        if(result.data.applicant!=""){
                            html+='<h4>Co-Applicant Detail</h4>';
                            html+='<table class="table">'+
                                '<thead>'+
                                    '<tr>'+
                                    '<th scope="col">Name</th>'+
                                    '<th scope="col">Pan Number</th>'+
                                    '<th scope="col">Relationship</th>'+
                                    '</tr>'+
                                '</thead>';
                            var applicants =result.data.applicant;
                            applicants.forEach(function (applicant) { 
                                html+='<tbody>'+
                                    '<tr>'+
                                    '<td>'+applicant.name+'</td>'+
                                    '<td>'+applicant.pan_number+'</td>'+
                                    '<td>'+applicant.relationship+'</td>'+
                                    '</tr>';
                            });
                            html+='</tbody></table>' 
                        }
                        html+='<div class="photodocument">'+
                                '<img src="'+BaseUrl+'uploads/merchant/pancard/'+result.data.pancard_image+'" />'+
                            '</div>'+
                            '<div class="photodocument">'+
                                '<img src="'+BaseUrl+'uploads/merchant/adharcard/'+result.data.adharcard_image+'" />'+
                            '</div>'+
                        '</div>';
                        if(result.data.other_image){
                        html+='<div class="photodocument">'+
                                '<img src="'+BaseUrl+'uploads/merchant/other/'+result.data.pancard_image+'" />'+
                            '</div>';
                        }
                        $('#user_detail').html(html);
                        //$('#button_dsa').html('<button type="button" onclick="EditProfile()" class="btn btn-primary" >Edit</button>');
                }else{
                    $('#user_detail').html(result.message);
                }                          
            }
        });
    }
</script>