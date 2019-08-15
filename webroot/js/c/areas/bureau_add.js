var cunliPool = {};
$(function () {
    $('#EducationTheDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#btn-source-cunli').click(function () {
        var clonedBlock = $('.cunli-block', $('#formSourceContainer')).first().clone();
        clonedBlock.appendTo($('#formSourceContainer'));
        return false;
    });
    $('#btn-volunteer-cunli').click(function () {
        var clonedBlock = $('.cunli-block', $('#formVolunteerContainer')).first().clone();
        clonedBlock.appendTo($('#formVolunteerContainer'));
        return false;
    });
    $('#EducationAreaId').change(cunliSelectArea).trigger('change');
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