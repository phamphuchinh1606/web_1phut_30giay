var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    [{'header': 1}, {'header': 2}],
    [{'list': 'ordered'}, {'list': 'bullet'}],
    [{'script': 'sub'}, {'script': 'super'}],
    [{'indent': '-1'}, {'indent': '+1'}],
    [{'direction': 'rtl'}],
    [{'size': ['small', false, 'large', 'huge']}],
    [{'header': [1, 2, 3, 4, 5, 6, false]}],
    [{'color': []}, {'background': []}],
    [{'font': []}],
    [{'align': []}],
    ['clean'],
    ['link', 'image', 'video']
];
$('.editor_quill').each(function(){
     let editorId = $(this).attr('id');
     if(editorId == "editor"){
         $thisHtml = $(this);
         $inputHidden = $(this).parent().find('input.editor');
         let editor = new Quill('#'+editorId,
             {modules: {toolbar: toolbarOptions},
                 placeholder: 'Compose an epic...',
                 theme: 'snow'});
         editor.on('editor-change', function(eventName, ...args) {
             let images = $thisHtml.find('img');
             if(images.length > 0){

                 for (var i=0; i< images.length; i++) {
                     let src =  images[i].getAttribute('src');
                     if(src.startsWith('data:image')){
                         let elementImage = images[i];
                         $.ajax({
                             type:'POST',
                             url:'/admin/upload-image-quill-editor',
                             data: {
                                 src_image: src
                             },
                             headers: {
                                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                             },
                             success:function(data){
                                 if(data.status == 'success'){
                                     elementImage.src = data.src_image;
                                     $inputHidden.val(editor.root.innerHTML);
                                 }
                             }
                         });
                     }

                 }
             }
             $inputHidden.val(editor.root.innerHTML);
         });
     }
});

