<?php	
	header("Content-Type:text/plain; charset=utf-8");

	while (empty($directories)) {chdir('..'); $directories = glob('nexus'); }
	require_once(getcwd().'/nexus/main.php');
	
	$controller = Controller::getInstance();
	
	$controller ->recoverPOST('action')
				->recoverPOST('id');

	if ($action === 'supprimer' && $controller->isNumber($id)) {
		$form_title = "Suppression de la suggestion"
			?>
			<div class="contenu petit">
				<em>Cliquer à l'extérieur de la modale pour la fermer</em>
				
				<h2 class="lb_title"><?php echo $form_title; ?></h2>
				
				<form id="" action="actions/suggestion.php" method="POST">
					<p>				
						<input type="hidden" name="action" value="supprimer" />
						<input type="hidden" name="idSuggestion" value="<?php echo $id ?>" />
						<input type="submit" class="button confirm" value="Valider" />
						<button type="button" class="button confirm" value="Annuler" onclick="cancel();">Annuler</button>
					</p>
				</form>
				
				<div class="clear"></div>
			</div>
				
			<?php
        exit();
    }