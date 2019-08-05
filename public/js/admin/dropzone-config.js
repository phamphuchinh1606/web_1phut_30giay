let total_photos_counter = 0;
let name = "";
let images = [];
Dropzone.options.myDropzone = {
    uploadMultiple: false,
    parallelUploads: 2,
    maxFilesize: 16,
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Xóa ảnh',
    dictFileTooBig: 'Image is larger than 16MB',
    timeout: 10000,
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {
        this.on("removedfile", function (file) {
            let data = {
                id: file.customName,
                _token: $('[name="_token"]').attr('content'),
                file_name_upload: file.file_name_upload
            };
            $.post({
                url: "/admin/delete-image",
                data: data,
                dataType: 'json',
                success: function (data) {
                    total_photos_counter--;
                    $("#counter").text("# " + total_photos_counter);
                }
            });
        });
    },
    success: function (file, done) {
        total_photos_counter++;
        $("#counter").text("# " + total_photos_counter);
        if(done.status == "success"){
            let urlImage = done.src_image;
            // file.previewElement.getElementsByTagName("img")[0].src = urlImage;
            file["dataURL"] = urlImage;
            file["file_name_upload"] = done.file_name_upload;
            file["customName"] = name;
            $('input[name=product_images]').val(done.file_name_upload);
            images.push(done.file_name_upload);
            addImage();
        }else{
            file["customName"] = name;
            file["file_name_upload"] = name;
        }
    }
};

function addImage(){
    let rootImages = $('.root_product_images');
    rootImages.find('.product_images').remove();
    images.forEach(function(image){
        rootImages.append('<input type="hidden" class="form-control product_images" name="product_images[]" value="' + image + '"/>');
    });
}

function deleteImage(){

}
