/** plugin jquery placeholder : v0.1 **/

(function($) {

	$.placeholder = function() {
		var inputs = $(':text');

		var test_input = document.createElement('input');    	
    	var is_placeholder_supported = ('placeholder' in test_input);
    	test_input = null;

    	if(!is_placeholder_supported) {

    		inputs.each(function() {
    			var that = $(this);
    			var placeholder = that.attr('placeholder');				

				that.on('focus', function() {
					if(that.val() == placeholder) {
						that.val("");
						that.css('color', '#222222');
						that.css('font-style','normal');
					}
				});

				that.on('blur', function() {
					if(that.val() == "") {
						that.val(placeholder);
						that.css('color', '#909090');
						that.css('font-style','italic');
					}
				});

				that.trigger('blur');
    		});    					
    	}

		return this;
	}

})(jQuery);