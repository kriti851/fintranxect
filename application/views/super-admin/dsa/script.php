<script>
    document.getElementById("dsa-li").classList.add("active");
    function GetUserDetail(userid){
        $('#viewdetail').modal('show');
        $('#dsa_user_detail').html('<div class="text-center"><div class="spinner-border" role="status">'+
                  '<span class="sr-only">Loading...</span>'+
                '</div></div>');
        $.ajax({
            url: SiteUrl+"dsa/GetUserDetail",
            method:'POST',
            dataType:"json",
            data:{"user_id":userid},
            success: function(result){
                if(result.status=="Success"){
                    if(result.data.total_businessvolume_.disbursed_amount==null){
                        result.data.total_businessvolume_.disbursed_amount=0;
                    }
                  
                    var html='<div  class="dashboard-section user-statistic-block text-center">'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Total Cases</h3>'+result.data.total_cases_in_year+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Incomplete Cases</h3>'+
                                        result.data.incomplete_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Short Close Cases</h3>'+result.data.shortclose_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Received Cases</h3>'+result.data.received_total+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Assigned Cases</h3>'+result.data.assigned_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Logged Cases</h3>'+result.data.logged_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Pending Cases</h3>'+result.data.pending_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Approved Cases</h3>'+result.data.approved_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Rejected Cases</h3>'+result.data.reject_current+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Disbursed Cases</h3>'+result.data.total_disbursed_+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">'+
                                    '<div class="user-statistic">'+
                                        '<h3>Disbursed Amount</h3>'+
                                        result.data.total_businessvolume_.disbursed_amount+
                                    '</div>'+
                                '</div>'+
                                
                            '</div>';
                    var payhtml='';
                    if(result.data.user_id==1793){
                        payhtml='<a class="button viewbutton" href="<?php echo admin_url('pay1')?>"><i class="fa fa-file"></i> Api</a>'
                    }
                    var documents=result.data.doc;
                        var items = documents.split(',');
                        var newhtml='<div style="width: 100%;" class="quote-imgs-thumbs">';
                        for(var j=0;j<items.length;j++){
                            var extension = items[0].split('.').pop();
                            if(extension=='png' || extension=='jpg' || extension=='jpeg'){
                                newhtml+='<div class="m-2">'+
                                        '<a href="'+BaseUrl+'uploads/dsa-doc/'+items[0]+'" download><img class="img-preview-thumb" src="'+BaseUrl+'uploads/dsa-doc/'+items[0]+'" /></a>'+
                                    '</div>';
                            }else{
                                newhtml+='<div class="m-2">'+
                                        '<a href="'+SiteUrl+'uploads/dsa-doc/'+items[0]+'" style="font-size:60px;" download ><i class="fa fa-file"></i></a>'+
                                    '</div>';
                            }
                        }
                    newhtml+='</div>';
                    html+='<div class="information" id="dsa-detail">'+
                            '<h4>Partner Information <div class="float-right"><h5><a class="button viewbutton" href="<?php echo admin_url('dsa/logo')?>/'+result.data.user_id+'"><i class="fa fa-image"></i> Logo</a>'+
                            payhtml+'</h5></div></h4>'+
                           ' <ul>'+
                                '<li><span>Company Name:</span> '+result.data.company_name+'</li>'+
                                '<li><span>Trade Name:</span> '+result.data.user_name+'</li>'+
                                '<li><span>Person Name:</span> '+result.data.full_name+'</li>'+
                                '<li><span>Mobile no:</span> +91 '+result.data.mobile_number+'</li>'+
                                '<li><span>Email:</span> '+result.data.email+'</li>'+
                                '<li><span>Website:</span> '+result.data.website+'</li>'+
                                '<li><span>Pan/GST no:</span> '+result.data.gst_number+'</li>'+
                                '<li><span>Address:</span> '+result.data.address+'</li>'+
                                '<li><span>Public Url:</span> '+WebUrl+result.data.user_name+'/loan</li>'+
                            '</ul>'+newhtml+
                        '</div>';
                        var pan_number="";
                        if(result.data.pan_number!=null){
                           pan_number= result.data.pan_number;
                        }
                    html+='<div style="display:none" id="dsa_user_edit"><form id="user_form"><div class="form-row">'+
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
                    				'<label>Pan no</label>'+
                    				 '<input class="multisteps-form__input form-control" type="text" id="pan_number" placeholder="Pan no"  value="'+pan_number+'" />'+
                    			'</div>'+
                    			'<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                    				'<label>Email</label>'+
                    				'<input class="multisteps-form__input form-control" type="text" id="email" placeholder="Mobile number" value="'+result.data.email+'"/>'+
                    			'</div>'+
                    		'</div>'+	
                    		
                    		'<div class="form-row mt-4">'+
                    				'<div class="col-12 col-sm-6">'+
                    					'<label>website</label>'+
                    						'<input class="multisteps-form__input form-control"  id="website"  type="text" placeholder="Website" value="'+result.data.website+'" />'+
                    				'</div>'+
                    				'<div class="col-12 col-sm-6 mt-4 mt-sm-0">'+
                    					'<label>GST no</label>'+
                    				    '<input class="multisteps-form__input form-control" id="gst_number" type="text" placeholder="GST No." value="'+result.data.gst_number+'" />'+
                    			'</div>'+
                    		'</div></form>'+
                    		
                    		'</div>';
                        $('#dsa_user_detail').html(html);
                        $('#button_dsa').html('<button type="button" onclick="EditProfile()" class="btn btn-primary" >Edit</button>');
                }else{
                    $('#dsa_user_detail').html(result.message);
                }                          
            }
        });
    }
    function EditProfile(){
        $('#myModalLabel').html('DSA Information Edit');
        $('#dsa-detail').hide();
        $('#dsa_user_edit').show();
        $('#button_dsa').html('<button type="button" onclick="UpdateProfile()" class="btn btn-primary" >SAVE CHANGES <span id="update_loader"></span></button>');
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
            url: SiteUrl+"dsa/UpdateProfile",
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
            url: SiteUrl+"dsa/GetAssignMember",
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
            url: SiteUrl+"dsa/AssignRm",
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