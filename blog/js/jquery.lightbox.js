
/** plugin jquery lightbox : v0.0 **/

(function($){

	$.lightbox = function(contenu, styles) {
		var lightbox = $("#cia-lightbox"), brouillard = $("#cia-brouillard");
		
		if(lightbox.length === 0) {
			lightbox = $("<div/>").attr("id", "cia-lightbox").hide();
			$("body").append(lightbox);
		}
		
		if(brouillard.length === 0) {
			brouillard = $("<div/>").attr("id", "cia-brouillard").hide();			
			$("body").append(brouillard);
		}
		
		var brouillard_styles = {"position" : "fixed", "background-color" : "rgba(150,150,150,0.7)", "top" : "0%", "z-index" : "1000", "width" : "100%", "height" : "100%"};	
		brouillard.css(brouillard_styles)
			.off()
			.on("click", function() { $.lightbox.hide();});

		lightbox.html(contenu);
		margin_left = -parseInt(lightbox.css("width"))/2;

		var lightbox_styles = {"position" : "fixed", "top" : "22%", "z-index" : "2000", "left" : "50%", "margin-left" : margin_left };	
		lightbox.css("marginLeft", margin_left);
		lightbox.css(lightbox_styles)


		lightbox.show();
		brouillard.show();

		return true;	
	};

	$.lightbox.hide = function() {
		var lightbox = $("#cia-lightbox"), brouillard = $("#cia-brouillard");
		brouillard.remove(); lightbox.html("").remove();
	}
	
})(jQuery);