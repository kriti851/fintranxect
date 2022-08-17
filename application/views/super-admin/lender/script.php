<script>
    document.getElementById("lender-li").classList.add("active");
   // window.history.replaceState({}, document.title,SiteUrl+'lender');
    function GetUserDetail(userid){
        $('#viewdetail').modal('show');
        $('#lender_user_detail').html('<div class="text-center"><div class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div></div>');
        $.ajax({
            url: SiteUrl+"lender/GetUserDetail",
            method:'POST',
            dataType:"json",
            data:{"user_id":userid},
            success: function(result){
                if(result.status=="Success"){
                    if(result.data.total_disbursed_.amount==null){
                        result.data.total_disbursed_.amount=0;
                    }
                    var html='<div  class="dashboard-section user-statistic-block text-center">'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Total Cases</h3>'+
                                        '<span >'+result.data.total_cases_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Assigned Cases</h3>'+
                                        '<span>'+result.data.assigned_case_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Logged Cases</h3>'+
                                        '<span>'+result.data.logged_case_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Pending Cases</h3>'+
                                        '<span>'+result.data.pending_case_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Approved Cases</h3>'+
                                        '<span>'+result.data.approved_case_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Disbursed Cases</h3>'+
                                        '<span >'+result.data.disbursed_case_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Rejected Cases</h3>'+
                                        '<span>'+result.data.reject_case_+' </span>'+
                                    '</div>'+
                                '</div>'+
                                
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Disbursed Amount</h3>'+
                                        '<span>'+result.data.total_disbursed_.amount+' </span>'+
                                    '</div>'+
                                '</div>'+
                               
                            '</div>';
                    html+='<div class="information" id="lender-detail">'+
                            '<h4>Lender Information</h4>'+
                           ' <ul>'+
                                '<li><span>Company Name:</span> '+result.data.company_name+'</li>'+
                                '<li><span>Person Name:</span> '+result.data.full_name+'</li>'+
                                '<li><span>Mobile no:</span> +91 '+result.data.mobile_number+'</li>'+
                                '<li><span>Email:</span> '+result.data.email+'</li>'+
                                '<li><span>GST no:</span> '+result.data.gst_number+'</li>'+
                                '<li><span>Address:</span> '+result.data.address+'</li>'+
                            '</ul>'+
                        '</div>';
                        var gst_number="";
                        if(result.data.gst_number!=null){
                            gst_number= result.data.gst_number;
                        }
                    html+='<div style="display:none" id="lender_user_edit"><form id="user_form"><div class="form-row">'+
                    				'<div class="col-12 col-sm-6">'+
                    					 '<label>Company name</label>'+
                    					 '<input type="hidden"id="updated_user_id" value="'+result.data.user_id+'" >'+
                    					 '<input class="multisteps-form__input form-control" type="text" id="company_name" placeholder="Company name" value="'+result.data.company_name+'" />'+
                    				'</div>'+
                    				'<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                    				'<label>Contact person name</label>'+
                    				'<input class="multisteps-form__input form-control" type="text" id="full_name" placeholder="Name of Contact Person" value="'+result.data.full_name+'" />'+
                    			 ' </div>'+
                    		 '</div>'+
                               '<div class="form-row mt-4">'+
                    				'<div class="col-12 col-sm-6">'+
                    					'<label>Address</label>'+
                    						'<input class="multisteps-form__input form-control" id="address" type="text" placeholder="Address" value="'+result.data.address+'"/>'+
                    				'</div>'+
                    				'<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                    					'<label>Mobile number</label>'+
                    				     '<input class="multisteps-form__input form-control" type="text" id="mobile_number" placeholder="Mobile number" value="'+result.data.mobile_number+'"/>'+
                    			    '</div>'+
                    		'</div>'+
                    		
                    		'<div class="form-row mt-4">'+
                    				'<div class="col-12 col-sm-6">'+
                    					'<label>GST no</label>'+
                    				    '<input class="multisteps-form__input form-control" id="gst_number" type="text" placeholder="GST No." value="'+gst_number+'" />'+
                    			'</div>'+
                    			'<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                    				'<label>Email</label>'+
                    				'<input class="multisteps-form__input form-control" type="text" id="email" placeholder="Email" value="'+result.data.email+'"/>'+
                    			'</div>'+
                    		'</div>'+	
                    		'</form>'+
                    		
                    		'</div>';
                        $('#lender_user_detail').html(html);
                        $('#button_lender').html('<button type="button" onclick="EditProfile()" class="btn btn-primary" >Edit</button>');
                }else{
                    $('#lender_user_detail').html(result.message);
                }                          
            }
        });
    }
    function EditProfile(){
        $('#myModalLabel').html('Lender Information Edit');
        $('#lender-detail').hide();
        $('#lender_user_edit').show();
        $('#button_lender').html('<button type="button" onclick="UpdateProfile()" class="btn btn-primary" >SAVE CHANGES <span id="update_loader"></span></button>');
    }
    function UpdateProfile(){
        $('#update_loader').html('<div style="width:17px;height:17px;" class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div>');
        var company_name=$('#company_name').val();
        var full_name=$('#full_name').val();
        var email=$('#email').val();
        var mobile_number=$('#mobile_number').val();
        var website=$('#website').val();
        var address=$('#address').val();
        var gst_number=$('#gst_number').val();
        var pan_number=$('#pan_number').val();
        $.ajax({
            url: SiteUrl+"lender/UpdateProfile",
            method:'POST',
            dataType:"json",
            data:{"company_name":company_name,"full_name":full_name,
                    "email":email,"mobile_number":mobile_number,
                    "website":website,"address":address,
                "gst_number":gst_number,"user_id":$('#updated_user_id').val(),
                "pan_number":pan_number
            },
            success: function(result){
                if(result.status=="Success"){
                    location.reload();
                }                        
            }
        });
    }
    function AssignRmModal(user_id){
        $('#rmassign').modal('show');
        $('#rm-body').html('<div class="text-center"><div class="spinner-border text-primary" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div></div>');
        $.ajax({
            url: SiteUrl+"lender/GetAssignMember",
            method:'POST',
            dataType:"json",
            data:{"user_id":user_id },
            success: function(result){
                var html='<div class="form-row">'+
                    '<div class="col-12 col-sm-12">'+
                            '<label>Sale </label>'+
                            '<input type="hidden" id="update_user_id" value="'+result.data.user_id+'" >'+
                            '<select id="sale_id" class="multisteps-form__input form-control">'+result.data.salelist+'</select>'+
                    '</div>'+
                '</div>';
                html+='<div class="form-row">'+
                    '<div class="col-12 col-sm-12">'+
                            '<label>Operation </label>'+
                            '<select id="operation_id" class="multisteps-form__input form-control">'+result.data.operationlist+'</select>'+
                    '</div>'+
                '</div>';
                
                $('#rm-body').html(html); 
                $('#button_rm').html('<button type="button" onclick="AssignRm()" class="btn btn-primary" >SAVE</button>'); 
            }
        });
    }
    function AssignRm(){
        $.ajax({
            url: SiteUrl+"lender/AssignRm",
            method:'POST',
            dataType:"json",
            data:{"user_id":$('#update_user_id').val(),
                'sale_id':$('#sale_id').val(),
                'operation_id':$('#operation_id').val(),
            },
            success: function(result){
                location.reload();
            }
        });
    }
</script>