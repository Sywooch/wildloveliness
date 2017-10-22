$(document).ready(function() {
    // конфигурирование datepicker'a
    $('[id$="birthdate"]').datepicker({
        format: "dd.mm.yyyy",
        todayBtn: "linked",
        language: "ru",
        toggleActive: true,
        todayHighlight: true,
        autoclose: true,

    });
});