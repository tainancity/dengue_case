$(function () {
    $('#ClinicReportTheDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#btn-add-area').click(function () {
        var clonedBlock = $('.area-block').first().clone();
        clonedBlock.appendTo($('#formContainer'));
        return false;
    });
});