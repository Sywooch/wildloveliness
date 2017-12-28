
//
//$(document).ready(function(){
//    $('img#photo').imgAreaSelect({
//        handles: true,
//        onSelectEnd: function (img, selection) {
//            console.log('width: ' + selection.width + '; height: ' + selection.height);
//            console.log('width: ' + selection.width + '; height: ' + selection.height);
//        }
//    });
//});
















function cropImage(){



    var imgFile = getSelectedFiles()[0];
    console.log(imgFile);
    $('#cropImageModal .modal-body').html(
        '<img id="photo" src="'+ imgFile.fullPath +'" alt="Some image description" />' +
        ''

    );

    var ias =  $('img#photo').imgAreaSelect({
        instance: true,
        handles: true,
        parent: '#cropImageModal .modal-dialog',
        onSelectEnd: function (img, selection) {
            console.log('width: ' + selection.width + '; height: ' + selection.height);
            console.log('width: ' + selection.width + '; height: ' + selection.height);
        }
    });

    $(document).ready(function(){
        $('#cropImageModal').modal('show');
        $('#cropImageModal').on('hide.bs.modal', function (e) {
            ias.cancelSelection();
        })
    });




}

function someFunction(){

}