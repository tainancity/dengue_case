var cunliPool = {};
$(function () {
    $('#CdcPointDateFound').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcPointIssueDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcPointIssueReplyDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcPointRecheckDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcPointRecheck2Date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcPointParentAreaId').change(cunliSelectArea).trigger('change');
    $('#CdcPointAreaId').change(function() {
        $('#CdcPointAddress').val($('#CdcPointParentAreaId option:selected').text() + $('#CdcPointAreaId option:selected').text());
    });
});

var cunliSelectArea = function () {
    var areaId = $(this).val();
    if (cunliPool[areaId]) {
        var optionText = '';
        for (k in cunliPool[areaId]) {
            optionText += '<option value="' + k + '">' + cunliPool[areaId][k] + '</option>';
        }
        $('#CdcPointAreaId').html(optionText).trigger('change');
    } else {
        $.getJSON(baseUrl + 'areas/cunli/' + areaId, {}, function (c) {
            cunliPool[areaId] = c;
            var optionText = '';
            for (k in c) {
                optionText += '<option value="' + k + '">' + c[k] + '</option>';
            }
            $('#CdcPointAreaId').html(optionText).trigger('change');
        })
    }
}