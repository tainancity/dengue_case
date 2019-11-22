var cunliPool = {};
$(function () {
    $('#CdcIssueDateFound').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcIssueIssueDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcIssueIssueReplyDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcIssueRecheckDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcIssueRecheck2Date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#CdcIssueParentAreaId').change(cunliSelectArea).trigger('change');
});

var cunliSelectArea = function () {
    var areaId = $(this).val();
    if (cunliPool[areaId]) {
        var optionText = '';
        for (k in cunliPool[areaId]) {
            optionText += '<option value="' + k + '">' + cunliPool[areaId][k] + '</option>';
        }
        $('#CdcIssueAreaId').html(optionText).trigger('change');
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
            $('#CdcIssueAreaId').html(optionText).trigger('change');
        })
    }
}