$(document).ready(function() {
    //Subida de ficheros de modo asíncrono en la vista de Item
    $('#multiple_images_images').fileupload({
        dataType: 'json',
        done: function (e, data) {
            var result_request = data.result;
            var wrap     = $('.upload-image').closest('.wrap-upload'),
                msg      = $(wrap).find('.msg-upload');
            $('.upload-image').removeClass('spinner');//loading
            $('.upload-image').find('i').removeClass('hidden');//icon plus

            if(result_request.request_result){
                icon = 'check';
                //insertamos la imagen
                var new_image = '<div class="image-box-item"><div class="image-item" style="background-image:url(' + result_request.request_pathImage + ');"></div><div class="options"><div class="image-item-no-main"><a class="main" href="' + result_request.request_pathMain + '"><i class="fa fa-star-o"></i> </a><a title="Delete" class="delete" href="'+ result_request.request_pathDelete +'"><i class="fa fa-trash-o"></i></a></div></div></div>';
                $(wrap).before(new_image);
            }else{
                icon = 'times';
            }

            $(msg).removeClass('hidden');//msg
            $(msg).html('<i class="fa fa-' + icon + '"></i> ' + result_request.request_msg);
        }
    });

    $('#multiple_images_images').bind('fileuploadsubmit', function (e, data) {
        var wrap     = $('.upload-image').closest('.wrap-upload'),
            msg      = $(wrap).find('.msg-upload');

        $(msg).addClass('hidden');//msg
        $('.upload-image').addClass('spinner');//loading
        $('.upload-image').find('i').addClass('hidden');//icon plus
    })
});