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
            var optionText = '<option value="0">--</option>';
            for (k in c) {
                if(dbAreaId !== k) {
                    optionText += '<option value="' + k + '">' + c[k] + '</option>';
                } else {
                    optionText += '<option value="' + k + '" selected="selected">' + c[k] + '</option>';
                }
            }
            $('#CdcPointAreaId').html(optionText).trigger('change');
        })
    }
}