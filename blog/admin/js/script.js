
function formulaire(page, action, id) {
	if(page && action ) {
		$.lightbox(buildPetitContenu('loading'));
					
		var params = {'action' : action};
		if(id) { params.id = id; }
		
		$.post('forms/'+ page, params,  function(data){
			$.lightbox(data);
		})
		.fail(function(jqXHR, textStatus) {
			$.lightbox(buildPetitContenu(textStatus + ' ' + jqXHR.status));	
		});
	}
	else {
		$.lightbox(buildPetitContenu('Il manque des infos !!'));	
	}
}


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

	
});

