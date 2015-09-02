
<?php	
	header("Content-Type:text/plain; charset=utf-8");

	while (empty($directories)){chdir('..');$directories = glob('nexus');}
	require_once(getcwd().'/nexus/main.php');
	
	$controller = Controller::getInstance();
	
	$controller ->recoverPOST('action')
				->recoverPOST('id');
		
	$titre = $contenu = $form_title = "";
		
	if ('ajouter' === $action || ('modifier' ===  $action && $controller->isNumber($id))) {			
		$form_title = "Nouvel article";
	
		if ('modifier' === $action) {
			$form_title = "Modifer l'article"; 			
			$article = new Article($id);											
		}
		
		?>
			<div class="contenu ">
				<em>Cliquer à l'extérieur de la modale pour la fermer</em>
				
				<h2 class="lb_title"><?php echo $form_title; ?></h2>
				
				<form id="" action="actions/article.php" method="POST">
					<p>
						<label for="titreArticle">Titre : </label>
						<input type="text" class="textbox" name="titreArticle" id="titreArticle" value="<?php echo isset($article) ? $article->titre : ''; ?>"/>
					</p>

					<p>
						<label for="contenuArticle" class="textarea">Contenu : </label>
						<textarea name="contenuArticle" id="contenuArticle" rows="8" cols="51"><?php echo isset($article) ? $article->getContenu() : ''; ?></textarea>
					</p>
					
					<p>
						<input type="hidden" name="action" value="<?php echo $action; ?>" />
						<?php if ($controller->isNumber($id)){ ?><input type="hidden" name="idArticle" value="<?php echo $id; ?>" /><?php } ?>
						<input class="button" type="submit"  value="Enregistrer l'article" />
					</p>
				</form>
				
				<div class="clear"></div>
			</div>
		<?php
		
	}
	else if ($action === 'supprimer' && $controller->isNumber($id)) {

		$form_title = "Suppression de l'article"

			?>
			<div class="contenu petit">
				<em>Cliquer à l'extérieur de la modale pour la fermer</em>
				
				<h2 class="lb_title"><?php echo $form_title; ?></h2>
				
				<form id="" action="actions/article.php" method="POST">
					<p>				
						<input type="hidden" name="action" value="supprimer" />
						<input type="hidden" name="idArticle" value="<?php echo $id ?>" />
						<input type="submit" class="button confirm" value="Valider" />
						<button type="button" class="button confirm" value="Annuler" onclick="cancel();">Annuler</button>
					</p>
				</form>
				
				<div class="clear"></div>
			</div>
				
			<?php
			exit();
	}
	else {
		echo '<span class="error" >Erreur</span>';
	}
	