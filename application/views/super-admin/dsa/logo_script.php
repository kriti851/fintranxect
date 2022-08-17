<script>
    function ShowImage(file){
        $('#logo_error').html('');
        $('#success_message').html('');
        var extension = file.files[0].name.split('.').pop().toLowerCase();
        if(extension=='png' || extension=='jpg' || extension=='jpeg'){
            $('#file_ext').val(extension);
            readURL(file);
            document.getElementById(file.id).value=null;
            $('#LargeImageModel').modal('show');
        }else{
            $('#logo_error').html('Only .jpg,.jpeg,.png extension allowed');
        }
        
    }
    function dismissModal(){
        $('#append_image').html('');
        $('#LargeImageModel').modal('hide');
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var html='<div class="">'+
                    '<img id="to-large-image" src="'+e.target.result+'" style="width:100% !important;height:100% !important;" src="#">'+
                '</div>';
                $('#append_image').html(html);
            };
            reader.readAsDataURL(input.files[0]);
            setTimeout(initCropper, 1000);
        }
    }
    function initCropper(){
        var image = document.getElementById('to-large-image');
        var cropper = new Cropper(image, {
            //aspectRatio: 1.8/ 1,
            data:{ 
                width: '500px',
                height: '250px',
            },
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            crop: function(e) {
                console.log(e.detail.x);
                console.log(e.detail.y);
            }
        });
        document.getElementById('crop_button').addEventListener('click', function(){
            var imgurl =  cropper.getCroppedCanvas().toDataURL();
            html ='<image style="margin-top:10px;" id="cropped_image" class="quote-imgs-thumbs" src="'+imgurl+'" >'
            $('#cropped_result').html(html);
            $('#append_upload_btn').html('<button onclick="UploadLogo()" class="btn btn-primary">Upload</button>');
            dismissModal();
        })
    }
    function UploadLogo(){
        $('#logo_error').html('');
        if($('#file_ext').val()!=""){
            var dsaid=$('#dsa_id').val();
            var file_ext=$('#file_ext').val();
            var _base_image=document.getElementById("cropped_image").src;;
            console.log(_base_image);
            if(_base_image!=""){
                $.ajax({
                    url:SiteUrl+'dsa/LogoUpload',
                    dataType:'json',
                    method:'POST',
                    data:{'dsa_id':dsaid,'extension':file_ext,'_base_image':_base_image},
                    success:function(response){
                        $('#append_upload_btn').html('');
                        $('#success_message').html('Logo Uploaded Successfully');
                    }
                });
            }else{
                $('#logo_error').html('Something went Wrong!');
            }
        }else{
            $('#logo_error').html('Something went Wrong!');
        }
    }
</script>