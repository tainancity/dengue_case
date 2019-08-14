var cunliPool = {};
$(function () {
    $('#btn-add-cunli').click(function () {
        var clonedBlock = $('.cunli-block').first().clone();
        clonedBlock.appendTo($('#formContainer'));
        return false;
    });
    $('.select-area', $('.cunli-block')).change(cunliSelectArea).trigger('change');
    $('#ExpandAreaId').change(cunliSelectArea).trigger('change');
    $('#ExpandTheDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});

var cunliSelectArea = function () {
    var areaId = $(this).val();
    if (cunliPool[areaId]) {
        var optionText = '';
        for (k in cunliPool[areaId]) {
            optionText += '<option value="' + k + '">' + cunliPool[areaId][k] + '</option>';
        }
        $('.select-cunli').html(optionText);
    } else {
        $.getJSON(baseUrl + 'areas/cunli/' + areaId, {}, function (c) {
            cunliPool[areaId] = c;
            var optionText = '';
            for (k in c) {
                optionText += '<option value="' + k + '">' + c[k] + '</option>';
            }
            $('.select-cunli').html(optionText);
        })
    }
}