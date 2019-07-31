var cunliPool = {};
$(function () {
    $('#btn-add-cunli').click(function () {
        var clonedBlock = $('.cunli-block').first().clone();
        $('.select-area', clonedBlock).change(cunliSelectArea).trigger('change');
        clonedBlock.appendTo($('#formContainer'));
        return false;
    });
    $('.select-area', $('.cunli-block')).change(cunliSelectArea).trigger('change');
    $('#CenterSourceTheDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});

var cunliSelectArea = function () {
    var areaId = $(this).val();
    var blockScope = $(this).parent().parent();
    if (cunliPool[areaId]) {
        var optionText = '';
        for (k in cunliPool[areaId]) {
            optionText += '<option value="' + k + '">' + cunliPool[areaId][k] + '</option>';
        }
        $('.select-cunli', blockScope).html(optionText);
    } else {
        $.getJSON(baseUrl + 'areas/cunli/' + areaId, {}, function (c) {
            cunliPool[areaId] = c;
            var optionText = '';
            for (k in c) {
                optionText += '<option value="' + k + '">' + c[k] + '</option>';
            }
            $('.select-cunli', blockScope).html(optionText);
        })
    }
}