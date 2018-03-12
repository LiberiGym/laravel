
$(document).ready(function () {
    var form = $('#editForm');
    var id = form.find('input[name=id]').val();
    var tags = $('#tags');
    controls.tags(tags);

    var publishDate = $('#publish_date');
    controls.datetimepicker(publishDate);

    var image = $('#image');
    uploader.add('image', {
        formData: {
            promocion_id: id,
            type: 'image'
        }
    }, function(data){
        if(data.result == 'ok'){
            image.css('background-image', 'url(' + data.file + ')');
        }
    });

});
