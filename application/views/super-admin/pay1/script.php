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
</script>
