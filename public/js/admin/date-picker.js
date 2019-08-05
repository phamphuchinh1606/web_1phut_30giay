$(function() {
    $('input.date-picker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 2010,
        locale: { cancelLabel: 'Clear' },
        maxYear: parseInt(moment().format('YYYY'),10) + 1
    }, function(start, end, label) {
        // var years = moment().diff(start, 'years');
        // alert("You are " + years + " years old!");
    });
    $('#date').mask('99/99/9999');
});