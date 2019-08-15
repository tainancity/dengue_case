$(function () {
    $('#btn-add-cunli').click(function () {
        var clonedBlock = $('.cunli-block').first().clone();
        $('input', clonedBlock).each(function(index, input) {
            if($(input).hasClass('field-delete')) {
                $(input).parent().remove();
            } else if($(input).hasClass('field-note')) {
                $(input).val('');
            } else {
                $(input).val(0);
            }
        });
        clonedBlock.appendTo($('#formContainer'));
        return false;
    });
});