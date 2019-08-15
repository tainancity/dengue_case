$(function () {
    $('#btn-source-cunli').click(function () {
        var clonedBlock = $('.cunli-block', $('#formSourceContainer')).first().clone();
        $('input', clonedBlock).each(function(index, input) {
            if($(input).hasClass('field-delete')) {
                $(input).parent().remove();
            } else if($(input).hasClass('field-note')) {
                $(input).val('');
            } else {
                $(input).val(0);
            }
        });
        clonedBlock.appendTo($('#formSourceContainer'));
        return false;
    });
    $('#btn-volunteer-cunli').click(function () {
        var clonedBlock = $('.cunli-block', $('#formVolunteerContainer')).first().clone();
        $('input', clonedBlock).each(function(index, input) {
            if($(input).hasClass('field-delete')) {
                $(input).parent().remove();
            } else if($(input).hasClass('field-note')) {
                $(input).val('');
            } else {
                $(input).val(0);
            }
        });
        clonedBlock.appendTo($('#formVolunteerContainer'));
        return false;
    });
});