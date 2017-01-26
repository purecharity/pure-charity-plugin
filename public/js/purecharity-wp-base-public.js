(function( jQuery ) {
	'use strict';

	if(jQuery('.donatesubmit').length > 0){
	  jQuery(document).on('click', '.donatesubmit', function(){
	  	// https://purecharity.com/fundraisers/21252/fund/X
	    var redirect_to = jQuery(this).attr('data-url') + jQuery(this).parent().find('input[type=number]:first').val();
	    location.href = redirect_to;
	    return false;
	  });

	  jQuery('form').keypress(function(e){
	    if (e.keyCode == 10 || e.keyCode == 13) 
	      e.preventDefault();
	  });
	}

})( jQuery );
