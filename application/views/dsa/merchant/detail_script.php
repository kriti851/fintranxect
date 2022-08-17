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
    function openNav() {
            $("#mySidenav").css("width", "300px");
            $("#main").css("margin-right", "300px");
            $('#style-4').scrollTop($('#style-4')[0].scrollHeight);
            
    }

    function closeNav() {
            $("#mySidenav").css("width", "0px");
            $("#main").css("margin-right", "0px");
            // document.body.style.backgroundColor = "white";
    }
    function SubmitComment(id,by){
            $('#comment_error').html();
            if($('#comments').val()==''){
            $('#comment_error').html('The Comment Field is required');
            return false;
            }
            $.ajax({
                    url: SiteUrl+"merchant/LeaveComments",
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
                                            '<span class="direct-chat-name pull-right"> You </span>'+
                                            '<span class="direct-chat-timestamp pull-left">'+result.date+' |'+by.toLowerCase()+'</span> </div>'+
                                            '<span>' +
                                            '<label class="switch">'+
                                                    '<input type="checkbox" id="isresolved'+result.comment_id+'" onclick="IsResolved(`'+result.comment_id+'`)">'+
                                                    '<span class="slider round"></span>'+
                                            '</label>'+
                                            '</span>'+ 
                                            '<span class="resolved">Resolved?</span>'+
                                            '<div class="direct-chat-text"> '+$('#comments').val()+'</div>'+
                                    '</div>';  
                                    $('#style-4').append(html);  
                                    $('#comments').val(''); 
                                    $('#style-4').scrollTop($('#style-4')[0].scrollHeight);    
                            }        
                    }
            });
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
</script>