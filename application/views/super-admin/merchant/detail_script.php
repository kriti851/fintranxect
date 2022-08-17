<script>
	function ShowLargeImage(image){
                document.getElementById("to-large-image").setAttribute("src",image);
                $('#LargeImageModel').modal('show');
        }
        function ShowLargeDoc(url){
                html='<div class="col-12 col-sm-12">'+
                        '<iframe style="width:730px;height:500px" id="to-large-doc"></iframe>'+
                '</div>'
                $('#modaldocbody').html(html);
                document.getElementById("to-large-doc").setAttribute("src",url);
                $('#LargeDocModel').modal('show');
        }
        function SubmitComment(id,by,name){
                $('#comment_error').html();
                if($('#comments').val()==''){
                $('#comment_error').html('The Comment Field is required');
                return false;
                }
                $.ajax({
                        url: SiteUrl+"merchant/LeaveComment",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "merchant_id":$('#merchant_id').val(),
                                "comment":$('#comments').val(),
                                "comment_by":id,
                                "comment_for":by
                        },
                        success: function(result){
                                if(result.status=='success'){
                                        html ='<div class="direct-chat-msg right">'+
                                        '<div class="direct-chat-info clearfix"> '+
                                                '<span class="direct-chat-name pull-right"> You : partner-'+name+'</span>'+
                                                '<span class="direct-chat-timestamp pull-left">'+result.date+'</span> </div>'+
                                                '<span>' +
                                                '<label class="switch">'+
                                                        '<input type="checkbox" id="isresolved'+result.comment_id+'" onclick="IsResolved(`'+result.comment_id+'`)">'+
                                                        '<span class="slider round"></span>'+
                                                '</label>'+
                                                '</span>'+ 
                                                '<span class="resolved">Resolved?</span>'+
                                                '<div class="direct-chat-text"> '+$('#comments').val()+'</div>'+
                                        '</div>';  
                                        $('.commentstyle').append(html);  
                                        $('#comments').val(''); 
                                        $('.commentstyle').scrollTop($('.commentstyle')[0].scrollHeight);    
                                }        
                        }
                });
        }
        function SendLenderComment(lenderid,lendername){
                $('#comment_error').html();
                var comments =$('#comments').val();
                if(comments==""){
                        $('#comment_error').html('The Comment Field is required');
                        return false;
                }
                $.ajax({
                        url: SiteUrl+"merchant/LeaveComment",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "merchant_id":$('#merchant_id').val(),
                                "comment":$('#comments').val(),
                                "comment_by":lenderid,
                                "comment_for":'LENDER'
                        },
                        success: function(result){
                                if(result.status=='success'){
                                        html ='<div class="direct-chat-msg right">'+
                                        '<div class="direct-chat-info clearfix"> '+
                                                '<span class="direct-chat-name pull-right"> You : lender-'+lendername+'</span>'+
                                                '<span class="direct-chat-timestamp pull-left">'+result.date+'</span> </div>'+
                                                '<span>' +
                                                '<label class="switch">'+
                                                        '<input type="checkbox" id="isresolved'+result.comment_id+'" onclick="IsResolved(`'+result.comment_id+'`)">'+
                                                        '<span class="slider round"></span>'+
                                                '</label>'+
                                                '</span>'+ 
                                                '<span class="resolved">Resolved?</span>'+
                                                '<div class="direct-chat-text"> '+$('#comments').val()+'</div>'+
                                        '</div>';  
                                        $('.commentstyle').append(html);  
                                        $('#comments').val(''); 
                                        $('.commentstyle').scrollTop($('.commentstyle')[0].scrollHeight);    
                                }        
                        }
                });
        }
        function RemarkSubmit(){
                $('#remark_comment_error').html();
                if($('#remark_comments').val()==''){
                $('#remark_comment_error').html('The Comment Field is required');
                return false;
                }
                var followuptime='';
                if($(".remarkdatepicker").val()){
                        followuptime=$(".remarkdatepicker").val();
                }
                $.ajax({
                        url: SiteUrl+"merchant/LeaveRemark",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "merchant_id":$('#remark_merchant_id').val(),
                                "comment":$('#remark_comments').val(),
                                "followuptime":followuptime
                        },
                        success: function(result){
                                if(result.status=='success'){
                                        html ='<div class="direct-chat-msg right">'+
                                        '<div class="direct-chat-info clearfix"> '+
                                                '<span class="direct-chat-name pull-right"> You </span>'+
                                                '<span class="direct-chat-timestamp pull-left">'+result.date+'</span> </div>'+
                                                '<div class="direct-chat-text"> '+$('#remark_comments').val()+'</div>'+
                                        '</div>';  
                                        $('.remarkstyle').append(html);  
                                        $('#remark_comments').val(''); 
                                        $('#remarkdatetime').html(''); 
                                        $("#remarkswitch").prop("checked", false);
                                        $('.remarkstyle').scrollTop($('.remarkstyle')[0].scrollHeight);    
                                }        
                        }
                });
        }
        function openNav() {
                $("#mySidenav").css("width", "300px");
                $("#main").css("margin-right", "300px");
                $('.commentstyle').scrollTop($('.commentstyle')[0].scrollHeight);
                
        }
        function openRemarkNav() {
                $("#myRemarkSidenav").css("width", "300px");
                $("#main").css("margin-right", "300px");
                $('.remarkstyle').scrollTop($('.remarkstyle')[0].scrollHeight);
                
        }
        
        function openFollowUpNav() {
                $("#openFollowUpNav").css("width", "300px");
                $("#main").css("margin-right", "300px");
                $.ajax({
                        url: SiteUrl+"merchant/GetFollowup/"+$('#merchant_id').val(),
                        method:'GET',
                        beforeSend:function(){
                                $('.followupstyle').html('<div class="spinner-border text-primary" role="status">'+
                                        '<span class="sr-only">Loading...</span>'+
                                '</div>');
                        },
                        success: function(result){
                                $('.followupstyle').html(result);
                                setTimeout(function(){
                                        $('.followupstyle').scrollTop($('.followupstyle')[0].scrollHeight);
                                },300)  
                        }
                });                
        }
        function closeRemarkNav() {
                $("#myRemarkSidenav").css("width", "0px");
                $("#main").css("margin-right", "0px");
        }
        function closeFollowUpNav() {
                $("#openFollowUpNav").css("width", "0px");
                $("#main").css("margin-right", "0px");
        }
        function closeNav() {
                $("#mySidenav").css("width", "0px");
                $("#main").css("margin-right", "0px");
        }
        function IsResolved(comment_id){
                var isresolevd='';
                if($('#isresolved' + comment_id).is(":checked")==true){
                        isresolevd='YES';
                }else{
                        isresolved='NO';
                }
                $.ajax({
                        url: SiteUrl+"merchant/IsResolved",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "comment_id":comment_id,
                                "is_resolved":isresolevd
                        },
                        success: function(result){
                                  
                        }
                });
        }
        function IsRemarked(remarked_id){
                var isresolevd='NO';
                if($('#isresolved' + remarked_id).is(":checked")==true){
                        isresolevd='YES';
                }
                $.ajax({
                        url: SiteUrl+"merchant/IsRemarked",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "remark_id":remarked_id,
                                "is_resolved":isresolevd
                        },
                        success: function(result){
                                  
                        }
                });
        }
        function RejectCaseModal(userid,lender_id){
                $('#rejector_id').val(userid);
                $('#reject_lender_id').val(lender_id);
                $('#ForceStatusModal').modal('hide');
                $('#RejectCaseModal').modal('show');
        }
        function ForceStatusModal(){
                $('#ForceStatusModal').modal('show');
        }
        function RejectCaseSubmit(){
                $('#reject_comment_error').html('');
                if($('textarea#reject_comments').val()==""){
                        $('#reject_comment_error').html('Comment Field is Required');
                        return false;
                }
                $.ajax({
                        url: SiteUrl+"merchant/RejectCase",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "user_id":$('#rejector_id').val(),
                                "lender_id":$('#reject_lender_id').val(),
                                "comments":$('textarea#reject_comments').val()
                        },
                        success: function(result){
                                location.reload();
                        }
                });
        }
        function ActivateCaseModal(userid){
                $('#activate_user_id').val(userid);
                $('#ActivatCaseModal').modal('show');
        }
        function ActivateCase(){
                $.ajax({
                        url: SiteUrl+"merchant/ActivateCase",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "user_id":$('#activate_user_id').val(),
                        },
                        success: function(result){
                                location.reload();
                        }
                });
        }
        $('#DisbursedSubmit').click(function(){
                if($('#disburse_amount').val()==""){
                $('#disbursederror').html('The Disburse Amount filed is required');
                return false;
                }
                $.ajax({
                        url: SiteUrl+"merchant/disburse",
                        method:'POST',
                        dataType:"json",
                        data:{
                                "merchant_id":$('#disbursed_id').val(),
                                "lender_id":$('#disbursed_lender_id').val(),
                                "disburse_amount":$('#disburse_amount').val()
                        },
                        success: function(result){
                                location.reload();                 
                        }
                });
        });
        function DisbursedModal(user_id,lender_id){
                //$('#ForceStatusModal').modal('hide');
                $('#disbursed_lender_id').val(lender_id);
                $('#DisbursedModel').modal('show');
        }
        $('#remarkswitch').click(function(){
                if($("#remarkswitch").is(':checked')){
                        var html='<input type="text" readonly class="form-control remarkdatepicker">';
                        $('#remarkdatetime').html(html);
                        RemarkDatePicker();
                }else{
                        $('#remarkdatetime').html('');
                }
        });
        function RemarkDatePicker(){
                $('.remarkdatepicker').daterangepicker({ 
                        drops:'up',
                        singleDatePicker: true,
                        timePicker24Hour:false,
                        timePicker: true,
                        autoUpdateInput: false,
                        locale: {
                                cancelLabel: 'Clear'
                        }
                });
                $('.remarkdatepicker').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('DD MMM YYYY hh:mm A'));
                });
                $('.remarkdatepicker').focus();

        }

        function OpenChecklist() {
                $("#checkListSidebar").css("width", "350px");
                $("#main").css("margin-right", "350px");
        }
        function closeChecklist() {
                $("#checkListSidebar").css("width", "0px");
                $("#main").css("margin-right", "0px");
        }
       /*  function ExBusinessTypeLabel(){
                if(document.getElementById('ex_business_type').value==''){
                        document.getElementById('ex_business_type_label').setAttribute('style','display:none');
                        document.getElementById('ex_business_type').setAttribute('style','');
                }else{
                        document.getElementById('ex_business_type_label').setAttribute('style','');
                        document.getElementById('ex_business_type').setAttribute('style','padding-top:17px;');
                }
        }
        ExBusinessTypeLabel(); */
        function MobileValidate(value) {
                var mob = /^[6-9]{1}[0-9]{9}$/;
                if (mob.test(value) == false) {
                        return false;
                }
                return true;
        }
        function NameOnPancard(value){
                value=value.trim();
                if(value!=""){
                        SetCheckList('full_name',value);
                        document.getElementById('_event_full_name').innerHTML=value;
                }
        } 
        function PersonAge(value){
                value=value.trim();
                if(value!="" && value>0){
                        SetCheckList('age',value);
                        document.getElementById('_event_age').innerHTML=value;
                }
        }
        function CheckMobileNumber(value){
                value=value.trim();
                if(value!="" && MobileValidate(value)==true){
                       $.ajax({
                                url: SiteUrl+"merchant/edit_phone_validation",
                                method:'POST',
                                dataType:"json",
                                data:{
                                'mobile_number':value,
                                'merchant_id':$('#merchant_id').val()
                                },
                                success: function(result){
                                        if(result.status=='success'){
                                                SetCheckList('mobile_number',value)
                                                document.getElementById('_event_mobile_number').innerHTML=value;
                                                $.notify(result.message, "success");
                                        }else{
                                                $.notify(result.message, "error");
                                        }
                                }
                        });
                }
        }
        function CheckEmail(value){
                value=value.trim();
                if(value!=""){
                        $.ajax({
                                url: SiteUrl+"merchant/email_validation",
                                method:'POST',
                                dataType:"json",
                                data:{
                                'email':value,
                                'merchant_id':$('#merchant_id').val()
                                },
                                success: function(result){
                                        if(result.status=='success'){
                                                SetCheckList('email',value);
                                                document.getElementById('_event_email').innerHTML=value;
                                                $.notify('Email updated successfully', "success");
                                        }else{
                                                $.notify(result.message, "error");
                                        }
                                }
                        });
                }
        }
        function CheckBusinessType(value){
                if(value!=""){
                        SetCheckList('business_type',value);
                }
        }
        function CheckVintage(value){
                if(value!="" && value>0){
                        SetCheckList('vintage',value);
                        document.getElementById('_event_vintage').innerHTML=value;
                }
        }
        function CheckBusinessAddress(value){
                if(value!=""){
                        SetCheckList('business_address',value);
                }
        }
        function CheckLoanRequirement(value){
                if(value!=""){
                        SetDocList('loan_requirement',value);
                }
        }
        function BankstatementProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('_year_banking__doc',ischecked);
        }
        function BusinessRegistrationProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('business_registration__doc',ischecked);
        }
        function AadharPancardProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('adhar_pancard__doc',ischecked);
        }
        function ItrProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('itr__doc',ischecked);
        }
        function GstCeritificateProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('gst_cretificate__doc',ischecked);
        }
        function CancelChequeProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('cancel_check__doc',ischecked);
        }
        function OwnershipProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('ownership_proof__doc',ischecked);
        }
        function RentAgreementProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('rent_agreement__doc',ischecked);
        }
        function MoaAoaProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('moa_aoa__doc',ischecked);
        }
        function CompanyPancardProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('company_pancard__doc',ischecked);
        }
        function PartnerAddressProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('partner_residenatal_address_proof__doc',ischecked);
        } 
        function PartnerAadharPanProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('partner_aadhar_pancard_proof__doc',ischecked);
        }
        function PartnershipDeedProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('partnership_deed__doc',ischecked);
        }
        function AddressShopProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('address_proof_shop__doc',ischecked);
        }
        function AddressResidentalProof(doc){
                var ischecked=0;
                if(doc.checked==true){
                        var ischecked=1;
                }
                SetDocList('address_proof_residential__doc',ischecked);
        }
        function SetDocList(key,value){
                $.ajax({
                        url: SiteUrl+"merchant/check_list",
                        method:'POST',
                        dataType:"json",
                        data:{
                               'key':key,
                               'value':value,
                               'merchant_id':$('#merchant_id').val()
                        }
                });
        }
        function SetCheckList(key,value){
                $.ajax({
                        url: SiteUrl+"merchant/check_case_list",
                        method:'POST',
                        dataType:"json",
                        data:{
                               'key':key,
                               'value':value,
                               'merchant_id':$('#merchant_id').val()
                        }
                });
        }
        function showNewgrowthModel(){
                var html='<div class="modal-dialog">'+
                        '<div class="modal-content" >'+
                               ' <div class="modal-header">'+
                                        '<h4 class="modal-title" >Newgrowth Api Form</h4>'+
                                        '<!--button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                                '<span aria-hidden="true">&times;</span>'+
                                        '</button-->'+
                                '</div>'+
                                '<div class="modal-body">'+
                                        '<div class="col-12 col-sm-12" id="newgrowthError">'+
                                                
                                        '</div>'+
                                        '<div class="col-12 col-sm-12">'+
                                                '<div class="form-row mt-3">'+
                                                        '<div class="col-12 col-sm-12">'+
                                                                '<div class="md-input">'+
                                                                        '<input type="number" title="Loan Amount" oninput="this.value = Math.abs(this.value)" id="newgrowth-loan-amount"  class="md-form-control" required="">'+
                                                                        '<label>Loan Amount</label>'+
                                                                '</div>'+
                                                        '</div>'+
                                                        '<div class="col-12 col-sm-12">'+
                                                                '<label style="display:none" id="newgrowth_city_label" class="accup">City</label>'+
                                                                '<select id="newgrowth_city" class="multisteps-form__input form-control" onchange="NewgrowthCityLabel()">'+
                                                                        '<option value="">City</option>'+
                                                                        '<option value="Ahmedabad">Ahmedabad</option>'+
                                                                        '<option value="Bangalore">Bangalore</option>'+
                                                                        '<option value="Baroda">Baroda</option>'+
                                                                        '<option value="Bhubaneswar">Bhubaneswar</option>'+
                                                                        '<option value="Chandigarh">Chandigarh</option>'+
                                                                        '<option value="Chennai">Chennai</option>'+
                                                                        '<option value="Coimbatore">Coimbatore</option>'+
                                                                        '<option value="Delhi">Delhi</option>'+
                                                                        '<option value="Hyderabad">Hyderabad</option>'+
                                                                        '<option value="Indore">Indore</option>'+
                                                                        '<option value="Jaipur">Jaipur</option>'+
                                                                        '<option value="Jalandhar">Jalandhar</option>'+
                                                                        '<option value="Jamshedpur">Jamshedpur</option>'+
                                                                        '<option value="Kolkata">Kolkata</option>'+
                                                                        '<option value="Mysore">Mysore</option>'+
                                                                        '<option value="Pune">Pune</option>'+
                                                                        '<option value="Rajkot">Rajkot</option>'+
                                                                        '<option value="Surat">Surat</option>'+
                                                                        '<option value="Vijayawada">Vijayawada</option>'+
                                                                        '<option value="Surat">Surat</option>'+
                                                                '</select>'+
                                                        '</div>'+
                                                '</div>'+
                                        '</div>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                        '<button type="button"  id="newgrowth-close" style="background:black;" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
                                        '<button type="button" id="newgrowth-submit" onclick="submitNewGrowth()" class="btn btn-primary" >Save '+
                                                '<span id="newgrowth-loader">'+
                                                
                                                '</span>'+
                                        '</button>'+
                                '</div>'+
                        '</div>'+
                '</div>';
                $('#newgrowthModel').html(html);
                $('#newgrowthModel').modal('show');
        }
        function NewgrowthCityLabel(){
                if(document.getElementById('newgrowth_city').value==''){
                        document.getElementById('newgrowth_city_label').setAttribute('style','display:none');
                        document.getElementById('newgrowth_city').setAttribute('style','');
                }else{
                        document.getElementById('newgrowth_city_label').setAttribute('style','');
                        document.getElementById('newgrowth_city').setAttribute('style','padding-top:17px;');
                }
        }
        function submitNewGrowth(){
                $('#newgrowthError').html('');
                if($('#newgrowth-loan-amount').val()==""){
                        $('#newgrowthError').html('<div class="alert alert-danger" role="alert">The Loan Amount Field is Required </div>');
                        return false;
                }
                if($('#newgrowth_city').val()==""){
                        $('#newgrowthError').html('<div class="alert alert-danger" role="alert">The City Field is Required</div>');
                        return false;
                }
                $.ajax({
                        url: SiteUrl+"newgrowth/create_lead",
                        method:'POST',
                        dataType:"json",
                        data:{
                               'loanamount':$('#newgrowth-loan-amount').val(),
                               'city':$('#newgrowth_city').val(),
                               'merchant_id':$('#merchant_id').val()
                        },
                        beforeSend:function(){
                                $('#newgrowth-loader').html('<div class="spinner-border text-light" style="height:13px;width:13px;" role="status">'+
                                        '<span class="sr-only">Loading...</span>'+
                                '</div>');
                                $('#newgrowth-submit').prop('disabled',true);
                                $('#newgrowth-close').prop('disabled',true);
                        },
                        success: function(response){
                                if(response.status=='failure'){
                                        $('#newgrowthError').html('<div class="alert alert-danger" role="alert">'+response.message+'</div>');
                                        setTimeout(function(){ 
                                                $('#newgrowth-loader').html('');
                                                $('#newgrowth-submit').prop('disabled',false);
                                                $('#newgrowth-close').prop('disabled',false);
                                        },100);
                                }else{
                                        $('#newgrowthError').html('<div class="alert alert-success" role="alert">'+response.message+'</div>');
                                        setTimeout(function(){ 
                                                $('#newgrowth-loader').html('');
                                                $('#newgrowth-close').prop('disabled',false);
                                        },100);
                                        setTimeout(function(){ 
                                               location.reload();
                                        },2000);
                                }
                                
                        }
                });
        }
        function GetNewGrowthStatus(leadid){
                var html='<div class="modal-dialog modal-lg">'+
                        '<div class="modal-content" >'+
                                '<div class="modal-header">'+
                                        '<h4 class="modal-title" >Newgrowth User Detail</h4>'+
                                        '<!--button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                                '<span aria-hidden="true">&times;</span>'+
                                        '</button-->'+
                                '</div>'+
                                '<div class="modal-body text-center">'+
                                        '<div class="spinner-border text-primary" role="status">'+
                                                '<span class="sr-only">Loading...</span>'+
                                        '</div>'+
                                '</div>'+
                        '</div>'+
                '</div>';
                $('#newgrowthModel').html(html);
                $('#newgrowthModel').modal('show');
                $.ajax({
                        url: SiteUrl+"newgrowth/getSatus",
                        method:'POST',
                        dataType:"json",
                        data:{
                               'lead_id':leadid,
                               'merchant_id':$('#merchant_id').val()
                        },
                        success: function(response){
                                var documents=`<div class="table-responsive"><table class="table table-bordered">`;
                                response.data.documents.forEach(function(item,index){
                                        documents+=`<tr>`;
                                        documents+=`<th><span id="text-`+item.id+`">`+item.name+`</span></th>`;
                                        if(item.document_id!=""){
                                                documents+=`<td><i id="sign-`+item.document_id+`" class="fas fa-check-circle text-success"></i></td>`;
                                                documents+=`<td><button id="btn-`+item.document_id+`" style="border:none" onclick="DeleteDocuments('`+item.document_id+`','`+leadid+`','`+item.id+`')" class="button viewbutton">Delete <span id="delete-`+item.document_id+`"></span></button></td></td>`;
                                        }else{
                                                documents+=`<td><span id="sign-`+item.document_id+`" class="fa fa-exclamation-circle text-danger"></span></td>`;
                                                documents+=`<td><a href="javascript:void(0)" id="btn-`+item.document_id+`" onclick="NewGrowthDocForm('`+item.id+`','`+item.name+`','`+leadid+`')" class="button viewbutton">Upload</a></td>`;    
                                        }      
                                        documents+=`</tr>`;
                                });
                                documents+=`</table></div>`;
                                setTimeout(function(){ 
                                        html =  '<div class="modal-dialog modal-lg">'+
                                                '<div class="modal-content" >'+
                                                        '<div class="modal-header">'+
                                                                '<h4 class="modal-title" >Newgrowth User Detail</h4>'+
                                                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                                                        '<span aria-hidden="true">&times;</span>'+
                                                                '</button>'+
                                                        '</div>'+
                                                        '<div class="modal-body" id="newgrowthModalBody">'+
                                                                '<div class="information">'+
                                                                        '<ul>'+
                                                                                '<li><span>Lead ID:</span> '+response.data.lead_id+'</li><br>'+
                                                                                '<li><span>Applicant Name:</span> '+response.data.applicant_name+'</li>'+
                                                                                '<li><span>Merchant NAme:</span> '+response.data.merchant_name+'</li>'+
                                                                                '<li><span>Created At:</span> '+response.data.date_created+'</li>'+
                                                                                '<li><span>Current Status:</span> '+response.data.current_status+'</li>'+
                                                                                '<li><span>Remarks:</span> '+response.data.remarks+'</li>'+
                                                                        '</ul>'+
                                                                '</div>'+
                                                                documents+
                                                        '</div>'+
                                                '</div>'+
                                        '</div>';
                                        $('#newgrowthModel').html(html);
                                },400);
                        }
                });
        }
        function NewGrowthDocForm(id,name,leadid){
                html = '<div class="form-row ">'+
                        '<label>'+name+'</label>'+
                        '<input type="hidden"  id="document_id" value="'+id+'">'+
                        '<input type="hidden"  id="lead_id" value="'+leadid+'">'+
                        '<div class="fileUpload blue-btn btn width100">'+
                                '<span>Choose File</span>'+
                                '<input type="file" id="newgrowth_docs" accept=".png,.jpeg,.pdf,.gif" onchange="FilePreview(this)"  class="uploadlogo">'+
                        '</div>'+
                        '<div id="image-preview" style="width:100% !important;" ></div>'+
                '</div>';
                html+='<div class="form-row float-right mt-4"><input type="button" onclick="GetNewGrowthStatus(`'+leadid+'`)" class="previous action-button-previous btn btn-default" value="Back">';
                html+='<button type="button" disabled id="upload-btn-newgrowth" onclick="SubmitDocumentNewgrowth()" class="previous action-button-previous btn btn-primary">Upload '+
                        '<span id="newgrowth-loader"></span></button></div>';
                $('#newgrowthModalBody').html(html);
        }
        function convertToBase64(fileToLoad,randid) {
                var fileReader = new FileReader();
                var base64;
                fileReader.onload = function(fileLoadedEvent) {
                };
                fileReader.readAsDataURL(fileToLoad);
        }
        function FilePreview(file){
                var extension = file.files[0].name.split('.').pop().toLowerCase();
                var fileReader = new FileReader();
                var base64;
                fileReader.onload = function(fileLoadedEvent) {
                        if(extension=='pdf'){
                                var appenddata='<iframe src="#" style="width:100% !important;max-height:400px;"   id="show-preview"></iframe>';
                                $('#image-preview').html(appenddata);
                                setTimeout(function(){
                                        $('#show-preview').attr('src',fileLoadedEvent.target.result);
                                        $('#upload-btn-newgrowth').attr('disabled',false);
                                },100);
                        }else if(extension=='jpg' ||extension=='jpeg' || extension=='png' || extension=='gif'){
                                var appenddata='<img class="quote-imgs-thumbs" style="max-width:400px !important;max-height:400px;" id="show-preview" scr="#">';
                                $('#image-preview').html(appenddata);
                                setTimeout(function(){
                                        $('#show-preview').attr('src',fileLoadedEvent.target.result);
                                        $('#upload-btn-newgrowth').attr('disabled',false);
                                },100);
                        }else{
                                var appenddata='<span class="text-danger" >Only pdf,jpg,png,gif file allowed</span>';
                                $('#image-preview').html(appenddata);  
                                $('#upload-btn-newgrowth').attr('disabled',true);
                        }
                };
                fileReader.readAsDataURL(file.files[0]);
                
        }
        function SubmitDocumentNewgrowth(){
                var file = document.getElementById('newgrowth_docs');
                var extension = file.files[0].name.split('.').pop().toLowerCase();
                if($.inArray(extension, ['png','jpeg','pdf','gif']) == -1) {
                        var appenddata='<span class="text-danger" >Only pdf,jpeg,png,gif file allowed</span>';
                        $('#image-preview').html(appenddata);  
                        $('#upload-btn-newgrowth').attr('disabled',true);
                }else{
                        $('#upload-btn-newgrowth').attr('disabled',true);
                        var formData = new FormData();
                        formData.append('document_meta_id', $('#document_id').val());
                        formData.append('lead_id', $('#lead_id').val());
                        formData.append('merchant_id', $('#merchant_id').val());
                        formData.append('dsa_document',file.files[0]);
                        $.ajax({
                                type: "POST",
                                url: SiteUrl+"/newgrowth/uploadsDocuments",
                                data: formData,
                                processData: false,
                                contentType: false,
                                beforeSend:function(){
                                        $('#newgrowth-loader').html('<div class="spinner-border text-light" style="height:13px;width:13px;" role="status">'+
                                                '<span class="sr-only">Loading...</span>'+
                                        '</div>');
                                },
                                success: function(response) {
                                        $('#newgrowth-loader').html('');
                                        if(response.status=="success"){
                                                $.notify(response.data.message, "success"); 
                                                setTimeout(function(){
                                                        GetNewGrowthStatus($('#lead_id').val());
                                                },100);
                                        }else{
                                                $.notify(response.data.message, "error"); 
                                                $('#upload-btn-newgrowth').attr('disabled',false);  
                                        }
                                       
                                }
                        });
                }
        }
        function DeleteDocuments(documentid,leadid,type_id){
                var docname=$('#text-'+type_id).html();
                $('#btn-'+documentid).attr('disabled',true);  
                $.ajax({
                        type: "POST",
                        dataType:"json",
                        url: SiteUrl+"/newgrowth/delete_document",
                        data: {
                             "document_id":documentid,
                             "lead_id":leadid ,
                             "merchant_id":$('#merchant_id').val()
                        },
                        beforeSend:function(){
                                $('#delete-'+documentid).html('<div class="spinner-border text-light" style="height:13px;width:13px;" role="status">'+
                                        '<span class="sr-only">Loading...</span>'+
                                '</div>');
                        },
                        success: function(response) {
                               $.notify('Document Deleted Successfully', "success"); 
                               $('#sign-'+documentid).attr('class','fa fa-exclamation-circle text-danger');
                               $('#btn-'+documentid).attr('onclick',`NewGrowthDocForm('`+type_id+`','`+docname+`','`+leadid+`')`);
                               $('#btn-'+documentid).attr('disabled',false);  
                               $('#btn-'+documentid).html('upload');
                        }
                });
        }
</script>
