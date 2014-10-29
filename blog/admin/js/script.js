
function formulaire(page, action, id) {
	if(page && action ) {
		$.lightbox(buildPetitContenu('loading'));
					
		var params = {'action' : action};
		if(id) { params.id = id; }
		
		$.post('forms/'+ page, params,  function(data){
			$.lightbox(data);	
			CKEDITOR.replace( 'contenuArticle', {language: 'fr', skin : 'moono'});
		})
		.fail(function(jqXHR, textStatus) {
			$.lightbox(buildPetitContenu(textStatus + ' ' + jqXHR.status));
		});
	}
	else {
		$.lightbox(buildPetitContenu('Il manque des infos !!'));	
	}
}

/**
 * [buildPetitContenu description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 *
 * TODO : Changer le nom de la fonction
 */
function buildPetitContenu(data) {
	var contenu = "";

	contenu += '<div class="contenu petit">';
	contenu += '	<em>Cliquer à l\'extérieur de la modale pour la fermer</em>';
	contenu += '	<h2>'+ data +'</h2>';
	contenu += '</div>';

	return contenu;
}


function toggleBoutonSupprimerToutesSuggestions() {
	var button_delete_all = $('#delete_all_suggestions');

	var is_any_input_checked = $('.workspace tbody').find('input[type=checkbox]:checked').length > 0;
	button_delete_all.toggle(is_any_input_checked);
}


function hideCheckBoxSelectAll() {
	if($('.workspace tbody').find($('input[type=checkbox]').not(':checked')).length > 0) {
		$('#select_all_suggestions').prop('checked', false);
	}
}

function loadArticles(that) {
	console.log(that.dataset.count);
	console.log(that.dataset.total);

	$.post('forms/'+ page, params,  function(data){
			$.lightbox(data);
		})
	// articles = loadMoreArticles($(this).data('count'), $(this).data('periode'));
				
				// for (article in articles) {

				// }

	// body...
}

/*
function verificationMail(chaine) {
	expression = new RegExp('^[a-z0-9._-]+@[a-z0-9._-]{2,}[.][a-z]{2,4}$');
	
	if (!expression.test(chaine) && chaine != '') {
		$('#mailErreur').innerHTML = 'Veuillez rentrer une adresse valide !!';
		$('#mail').focus();
	}
	else {
		$('#mailErreur').innerHTML = '';
	}	
}
*/



$(document).ready(function() {
	CKEDITOR.config.toolbar = [
	   ['Bold','Italic','Underline','Strike'],
	   ['Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent'],
	   '/',
	   ['NumberedList','BulletedList'],
	   ['Image','-','Link','Unlink','-', 'TextColor','BGColor'],
	   ['Source']
	] ;
	
});

