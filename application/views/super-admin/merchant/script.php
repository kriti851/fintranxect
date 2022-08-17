<script>
    
    function convertToBase64(fileToLoad,randid) {
        var fileReader = new FileReader();
        var base64;
        fileReader.onload = function(fileLoadedEvent) {
        };
        fileReader.readAsDataURL(fileToLoad);
    }
    function ShowSelectFile(image,classid){
        $('#'+classid).html('');
        for(var i=0;i<image.files.length;i++){
            var randid=new Date().getUTCMilliseconds();
            $('#'+classid).append('<div class="m-2"><i class="fa fa-file" aria-hidden="true"></i> '+image.files[i].name+
            '</div>');
            convertToBase64(image.files[i],randid);
        }
    }
    function ImportExcel(){
        $('#excel_error').html('');
        var ext = $('#csvexcel').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['xlsx','csv']) == -1) {
            $('#excel_error').html('Only xlsx,csv file Allowed');
            return false;
        }
        var formData = new FormData();
        formData.append('csvexcel',document.getElementById("csvexcel").files[0]);
        var bar= $('.progress-bar');
        var percent= $('.progress-bar');
        $.ajax({
            type: "POST",
            url: SiteUrl+"merchant/import_cases",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (request, xhr) {
                $('#progress_display').show();
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function(response) {
                if(response.status=='fail'){
                    $('#progress_display').hide();
                    $('#excel_error').html(response.message);
                }else{
                    var message="Import has been successfully finished. Total "+response.data.import_case+" cases executed";
                    $('#success_message').html(message);
                    var html ='<div class="text-center">'+
                            '<div class="alert alert-success" role="alert">'+message+'</div>'+
                        '</div>';
                    if(response.data.unimportCase!=""){
                        html+='<div class="alert alert-danger" role="alert">List of cases that have not been executed<ul>';
                        var unexecute=response.data.unimportCase;
                            for(var i=0;i<unexecute.length;i++){
                                html+='<li>'+unexecute[i]+' already exists.</li>';
                            }
                        html+='</ul></div>';
                    }else{
                        html+='<div class="mt-4"></div>'
                    }
                    $('#change_upload_body').html(html);
                    $('#change_upload_footer').html('<button type="button" class="btn btn-default" onclick="location.reload()">Close</button>');
                        
                }
            },
            xhr: function(){
                var xhr = $.ajaxSettings.xhr() ;
                xhr.upload.onprogress = function(data){
                    var perc = Math.round((data.loaded / data.total) * 100);
                    $('.progress-bar').text(perc + '%');
                    $('.progress-bar').css('width',perc + '%');
                };
                return xhr ;
            },
        });
    }
    function ApplyDownload(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        if(val!=""){
            $('#filter_case_form').submit();
        }else{
            $.notify('Please select business type.','error');
        }
    }
    $('input[name="rangepicker"]').daterangepicker();
</script>