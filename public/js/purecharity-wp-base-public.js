function toggle_not_found(klass) {
    if (jQuery(klass).length == 0) {
        jQuery('.fr-not-found').show()
    } else {
        jQuery('.fr-not-found').hide()
    }
}

(function (jQuery) {
    'use strict';

    if (jQuery('.donatesubmit').length > 0) {
        jQuery(document).on('click', '.donatesubmit', function () {
            // https://purecharity.com/fundraisers/21252/fund/X
            var redirect_to = jQuery(this).attr('data-url') + jQuery(this).parent().find('input[type=number]:first').val();
            location.href = redirect_to;
            return false;
        });

        jQuery('form').keypress(function (e) {
            if (e.keyCode == 10 || e.keyCode == 13)
                e.preventDefault();
        });
    }

    if (jQuery('#fr-embed-code').length > 0) {
        var textBox = document.getElementById("fr-embed-code");
        textBox.onfocus = function () {
            textBox.select();

            // Work around Chrome's little problem
            textBox.onmouseup = function () {
                // Prevent further mouseup intervention
                textBox.onmouseup = null;
                return false;
            };
        };
    }

    jQuery('#fr-tabs div.tab-div').hide();
    jQuery('#fr-tabs div:first').show();
    jQuery('#fr-tabs ul li:first').addClass('active');

    jQuery('#fr-tabs ul li a').click(function () {
        jQuery('#fr-tabs ul li').removeClass('active');
        jQuery(this).parent().addClass('active');
        var currentTab = jQuery(this).attr('href');
        jQuery('#fr-tabs div.tab-div').hide();
        jQuery(currentTab).show();
        return false;
    });

    var cw = jQuery('.gc-avatar').width();
    jQuery('.gc-avatar').css({'height': cw + 'px'});

    jQuery('#gc-tabs div').hide();
    jQuery('#gc-tabs div:first').show();
    jQuery('#gc-tabs ul li:first').addClass('active');

    jQuery('#gc-tabs ul:first li a').click(function () {
        jQuery('#gc-tabs ul:first li').removeClass('active');
        jQuery(this).parent().addClass('active');
        var currentTab = jQuery(this).attr('href');
        jQuery('#gc-tabs div').hide();
        jQuery(currentTab).show();
        return false;
    });

})(jQuery);

jQuery(document).ready(function () {
    jQuery(document).on('change', '.pcsponsor-filters select', function () {
        filterSponsorships();
    })

    jQuery(document).on('click', '.submit', function () {
        jQuery(this).parents('form').submit();
        return false;
    });

});

window.params = {};
var filterSponsorships = function () {
    // Get the values
    var query_string = [];
    if (jQuery('select[name=age]').val() != "0") {
        query_string.push("age=" + jQuery('select[name=age]').val())
    }
    if (jQuery('select[name=gender]').val() != "0") {
        query_string.push("gender=" + jQuery('select[name=gender]').val())
    }
    if (jQuery('select[name=location]').val() != "0") {
        query_string.push("location=" + jQuery('select[name=location]').val())
    }

    location.href = "?" + query_string.join("&")
};

