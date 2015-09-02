<?php
	session_start();

	if (!isset($_SESSION['login'])) {
		header('Location: ../connexion.php');
		exit;
	}	
	
	while (empty($directories)){chdir('..'); $directories = glob('nexus');}
	require_once(getcwd().'/nexus/main.php');
	
	$controller = Controller::getInstance();	
	$controller 	->recoverPOST('titreArticle', 'titre')
					->recoverPOST('contenuArticle', 'contenu')
					->recoverPOST('idArticle', 'id')
					->recoverPOST('action');	
	
	if ('modifier' === $action && $controller->isNumber($id) && $controller->isString($titre)) {
		$article = new Article($id);		
		$article->setContenu($contenu)->setTitre($titre);
	}
	else if ('ajouter' === $action && $controller->isString($titre) && "" !== $contenu) {
		Article::ajouter($titre, $contenu);
	}
	else if ('supprimer' === $action && $controller->isNumber($id)) {
		$article = new Article($id);		
		$article->supprimer();
	}
		
	header('Location: ../');