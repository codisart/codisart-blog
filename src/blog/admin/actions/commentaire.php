<?php
	session_start();
	if (!isset($_SESSION['login'])){header('Location: ../connexion.php');exit;}

	while(empty($directories)){chdir('..'); $directories = glob('nexus');}
	require_once(getcwd().'/nexus/main.php');

	$controller = Controller::getInstance();
	$controller ->recoverPOST('idCommentaire', 'id')
				->recoverPOST('action');

	if ($controller->isNumber($id) && 'supprimer' === $action) {
		Commentaire::supprimer($id);
	}
	// @TODO Retour sur la page des commentaires avec l'id de l'article parent.
	header('Location: ../commentaires.php');
