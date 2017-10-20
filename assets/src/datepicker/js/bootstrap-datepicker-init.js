$(document).ready(function() {
    // конфигурирование datepicker'a
    var widget = $('.date').datepicker({
        format: "dd.mm.yyyy",
        todayBtn: "linked",
        language: "ru",
        toggleActive: true,
        todayHighlight: true,
        autoclose: true
    });



    console.log(widget);



    // скрытое поле модели
    var modelInput = $('#litter-birthdate'),
        modelVal = modelInput.val();
    // поле datepickera
    var datepckrInput = $('.date > input'),
        datepckrVal = datepckrInput.val();


    setPckrValue(modelVal);



    //var formatted = d.getDate()+"-"+(d.getMonth()+1)+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();



    function setPckrValue(date){
        d = new Date(date);
        pckrValue = d.getDate() + '.' + (d.getMonth()+1) + '.' + d.getFullYear();
        datepckrInput.val(pckrValue);
    }

    function setModelValue(){

    }







/*
    $('button[type=submit]').hover(function(){
        console.log($('.date-input').val());
    });
*/







/*

    // выбор чекбоксов events_direction
    var eventDirections = $('#eventfilter-events_direction label input[checked]');
    eventDirections.parent().addClass("active");


    //$(document).on('pjax:end', function() {
    //  loadDatepicker();
    //});

    function loadDatepicker() {
        // получаем timestamp из скрытых полей
        var eventsFromDate, eventsToDate;
        eventsFromDate = $('#eventfilter-from_date').val();
        eventsToDate = $('#eventfilter-to_date').val();

        // переводим timestamp в объект даты для передачи в датапикер
        var from = new Date(eventsFromDate*1000);
        var to = new Date(eventsToDate*1000);

        $('#datepicker-calendar').DatePicker({
            inline: true,
            date: [from, to],
            calendars: 3,
            starts: 1,
            next: 'right',
            prev: 'left',
            mode: 'range',
            current: new Date(to.getFullYear(), to.getMonth() - 1, 1),
            onChange: function(dates,el) {
                // update the range display
                $('#date-range-field span').text(dates[0].getDate()+' '+dates[0].getMonthName(true)+', '+dates[0].getFullYear()+' - '+
                dates[1].getDate()+' '+dates[1].getMonthName(true)+', '+dates[1].getFullYear());
            }
        });

        // initialize the special date dropdown field
        $('#date-range-field span').text(from.getDate()+' '+from.getMonthName(true)+', '+from.getFullYear()+' - '+
        to.getDate()+' '+to.getMonthName(true)+', '+to.getFullYear());

        // bind a click handler to the date display field, which when clicked
        // toggles the date picker calendar, flips the up/down indicator arrow,
        // and keeps the borders looking pretty

        // кнопка ГОТОВО
        // при раскомментировании поставить для #datepicker-calendar  height:205px
        $('#datepicker-calendar').append('<input type="submit" name="date" class="btn btn-default btn-md ready" value="Готово">');

        $('#date-range-field').bind('click', toggleDatepicker);
    }
    loadDatepicker();



    function toggleDatepicker(){
        $('#datepicker-calendar').toggle();

        // конфликт с dropdown (при вызове календаря прячем открытые dropdown менюшки)
        //$('.open .dropdown-menu').dropdown('toggle');

        if($('#date-range-field a').text().charCodeAt(0) == 9660) {
            // switch to up-arrow
            $('#date-range-field a').html('&#9650;');
            $('#date-range-field').css({borderBottomLeftRadius:0, borderBottomRightRadius:0});
            $('#date-range-field a').css({borderBottomRightRadius:0});
        } else {
            // switch to down-arrow
            $('#date-range-field a').html('&#9660;');
            $('#date-range-field').css({borderBottomLeftRadius:5, borderBottomRightRadius:5});
            $('#date-range-field a').css({borderBottomRightRadius:5});
        }

        return false;
    }


    // global click handler to hide the widget calendar when it's open, and
    // some other part of the document is clicked.  Note that this works best
    // defined out here rather than built in to the datepicker core because this
    // particular example is actually an 'inline' datepicker which is displayed
    // by an external event, unlike a non-inline datepicker which is automatically
    // displayed/hidden by clicks within/without the datepicker element and datepicker respectively
    $('html').click(function() {
        if($('#datepicker-calendar').is(":visible")) {
            $('#datepicker-calendar').hide();
            $('#date-range-field a').html('&#9660;');
            $('#date-range-field').css({borderBottomLeftRadius:5, borderBottomRightRadius:5});
            $('#date-range-field a').css({borderBottomRightRadius:5});
            getDateFromPickerToInputs();
        }
    });

    // stop the click propagation when clicking on the calendar element
    // so that we don't close it
    $('#datepicker-calendar').click(function(event){
        event.stopPropagation();
    });

    // ОТПРАВКА ВЫБРАННОЙ В ДАТАПИКЕРЕ ДАТЫ КОНТРОЛЛЕРУ
    $('input.ready').click(function(e){
        e.preventDefault();
        getDateFromPickerToInputs();
        toggleDatepicker();
    });

    function getDateFromPickerToInputs(){
        var data = $('#datepicker-calendar').DatePickerGetDate();

        // получаем дату из датапикера
        fromDate = data[0][0];
        toDate = data[0][1];

        // переводим дату в timestamp
        fromDate = Math.round(fromDate.getTime() / 1000)
        toDate = Math.round(toDate.getTime() / 1000)

        // пишем выбранный timestamp в скрытые поля и подписываем форму
        $('#eventfilter-from_date').val(fromDate);
        $('#eventfilter-to_date').val(toDate);
        //$('.date-picker-block form').submit();
    }





*/

});