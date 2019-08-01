$(function () {
    $('#the_date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#the_date').change(function() {
        location.href = baseUrl + 'areas/report/' + $(this).val();
    });
});