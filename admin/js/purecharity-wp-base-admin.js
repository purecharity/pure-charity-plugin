jQuery(function ($) {
    window.setTimeout(function () {
        jQuery(document).ready(function () {
            var main_color = jQuery("#main_color").val();
            jQuery("#main_color").spectrum({
                preferredFormat: "hex",
                color: main_color,
                showInitial: true,
                showInput: true
            });
        });
    }, 1000);

    $('.add-key').on('click', function () {
        var row = $(this).closest('td');
        row.find('fieldset').first().clone().insertAfter(row.find('fieldset').last()).find('input').val('');
    })

    $(document).on('click', '.remove-key', function () {
        if ($(this).closest('td').find('fieldset').length == '1') {
            alert('Sorry you couldn\'t remove last key');
            return false;
        }
        $(this).closest('fieldset').remove();
    });
})