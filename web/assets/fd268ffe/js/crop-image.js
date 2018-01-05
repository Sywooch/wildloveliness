var f,
    img,
    ias,
    srcImgPath,
    srcImgExt,
    srcImgName,
    srcImgWidth,
    srcImgHeight,
    selWidth,
    selHeight,
    resWidth,
    resHeight,
    visibleImgWidth,
    visibleImgHeight,
    ratioIndex,
    x1,
    y1,
    cropMethodURL = '/admin/filemanager/default/cropimage',
    ratios = {
        ratio1: 'Свое',
        ratio2: '16:9',
        ratio3: '1:1'
    },
    activeRatio = 'ratio2';





function initCropModal(){
    $('#cropImageModal .modal-body').html('<img id="photo" src="' + f.fullPath + '" alt="Cropping image" />');
    $('#cropImageModal').modal({backdrop:'static'}).modal('show'); // показываем модальное окно с изображением для обрезки
    // инициализируем плагин обрезки изображений
    ias =  $('img#photo').imgAreaSelect({
        instance: true,
        handles: true,
        parent: '#cropImageModal .modal-dialog',
        aspectRatio: ratios[activeRatio],
        onInit: function(img, selection) {
            appendOptsPanel();
            attachEventHandlers();
        },
        onSelectStart: function(img, selection){
            visibleImgWidth = Math.round($(img).width());
            visibleImgHeight = Math.round($(img).height());
            ratioIndex = srcImgWidth/visibleImgWidth;
        },
        onSelectChange: function(img, selection) {
            selWidth = Math.floor((selection.width)*ratioIndex);
            selHeight = Math.floor((selection.height)*ratioIndex);

            $('#selWidth').val(selWidth);
            $('#selHeight').val(selHeight);

            $('#resImgWidth').val(selWidth);
            $('#resImgHeight').val(selHeight);

        },
        onSelectEnd: function (img, selection) {
            x1 = Math.floor((selection.x1)*ratioIndex);
            y1 = Math.floor((selection.y1)*ratioIndex);
        }
    });
}

function appendOptsPanel() {

    $('#cropImageModal .modal-body').append(''+
        '<div id="cropOpts" class="panel panel-default">' +
            '<div class="panel-heading" role="tab" id="headingOne">' +
                '<h4 class="panel-title"><a id="cropOptionsToggleBtn" role="button" data-toggle="collapse" data-parent="#accordion" href="#cropOptsPanel" aria-expanded="true" aria-controls="collapseOne">Скрыть</a></h4>' +
            '</div>' +
            '<div id="cropOptsPanel" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">' +
            '<div class="panel-body">' +

            '<label>Исходный размер: '+ srcImgWidth +'x'+ srcImgHeight +'</label>' +



            '<label>Размеры выделения</label>' +
            '<form class="form-inline">' +
            '<div class="form-group">' +
            '<label for="selWidth">W</label>' +
            '<input type="text" class="form-control" id="selWidth" placeholder="0">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="selHeight">H</label>' +
            '<input type="text" class="form-control" id="selHeight" placeholder="0">' +
            '</div>' +
            '</form>' +

            '<hr/>' +

            '<label>Итоговый размер</label>' +
            '<form class="form-inline">' +
            '<div class="form-group">' +
            '<label for="srcImgWidth">W</label>' +
            '<input type="text" class="form-control" id="resImgWidth" placeholder="0">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="srcImgHeight">H</label>' +
            '<input type="text" class="form-control" id="resImgHeight" placeholder="0">' +
            '</div>' +
            '</form>' +

            '<hr/>' +

            insertAspectRatios(ratios, activeRatio) +

            '</div>' +
            '</div>' +
        '</div>'
    );
}


function insertAspectRatios(ratios, activeRatio){
    var ratiosHtml =    '<label>Соотношение сторон</label>' +
        '<form class="form-inline aspectRatioArea">';
    for(var ratioid in ratios){
        var isChecked = (ratioid == activeRatio) ? 'checked' : '';
        ratiosHtml += '' +
        '<div class="form-group">' +
        '<label class="ratioValue">' + ratios[ratioid] +'</label>' +
        '<input ' + isChecked + ' class="tgl tgl-ios" id="' + ratioid + '" data-ratio="' + ratios[ratioid] + '" type="checkbox"/>' +
        '<label class="tgl-btn" for="' + ratioid + '"></label>' +
        '</div>';
    }
    ratiosHtml += '</form>';
    return ratiosHtml;
}


function sendCropRequest(){
    $.ajax({
        url: cropMethodURL,
        type: 'POST',
        beforeSend: function() {
            resWidth = $('#resImgWidth').val();
            resHeight = $('#resImgHeight').val();
        },
        data: {
            srcImgPath: srcImgPath,
            srcImgName: srcImgName,
            srcImgExt: srcImgExt,
            srcImgWidth: srcImgWidth,
            srcImgHeight: srcImgHeight,
            selWidth: selWidth,
            selHeight: selHeight,
            //resWidth: resWidth,
            //resHeight: resHeight,
            x1: x1,
            y1: y1
        },
        async:true,
        cache: false,
        success: function(data){
            $('#cropImageModal').modal('hide'); // скрываем окно обрезки изображения
            var d = getSelectedDir(); d.ListFiles(true); // обновляем список файлов в текущей выбранной директории
        },
        error: function(data, string){
            alert(t('E_LoadingAjax') + ' ' + cropMethodURL);
        }
    });
}

function attachEventHandlers(){
    // смена соотношения сторон
    $('.aspectRatioArea :checkbox').change(function(){
        $('.aspectRatioArea :checkbox').prop( "checked", false );
        $(this).prop( "checked", true );
        ias.setOptions({ aspectRatio: $(this).attr('data-ratio')});
        ias.update();
    });

    // подключаем обработчик на нажатие кнопки "обрезать.."
    $('#cropImgBtn').on('click', sendCropRequest);
    // скрываем область обрезки при скрытии модального окна
    $('#cropImageModal').on('hide.bs.modal', function () {
        ias.cancelSelection();
        $('#cropImgBtn').off('click');
    });

    // смена заголовка окна с опциями
    var cropOptsPanel = $('#cropOptsPanel');
    cropOptsPanel.on('show.bs.collapse', function () {$('#cropOptionsToggleBtn').text('Скрыть')});
    cropOptsPanel.on('hide.bs.collapse', function () {$('#cropOptionsToggleBtn').text('Показать')});
}


function cropImage(){
    f = getSelectedFiles()[0]; // получаем выбранный файл
    if(!(isImage(f))) return false;
    initCropModal();

    srcImgPath = f.path;
    srcImgExt = f.ext;
    srcImgName = f.name;
    srcImgWidth = f.width;
    srcImgHeight = f.height;
}




















