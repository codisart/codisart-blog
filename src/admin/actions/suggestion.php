<?php
	session_start();

	if (!isset($_SESSION['login'])) {header('Location: ../connexion.php'); exit;}	
	
	while (empty($directories)){chdir('..'); $directories = glob('nexus');}
	require_once(getcwd().'/nexus/main.php');
	
	$controller = Controller::getInstance();	
	$controller->recoverPOST('idSuggestion', 'id')
				->recoverPOST('action');

	if ('supprimer' === $action && $controller->isNumber($id)) {
		$suggestion = new Suggestion($id);		
		$suggestion->supprimer();
	}
		
	header('Location: ../suggestions.php');