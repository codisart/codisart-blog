<?php
	session_start();
	if (!isset($_SESSION['login'])){header('Location: ../connexion.php');exit;}

	while(empty($directories)){chdir('..'); $directories = glob('nexus');}
	require_once(getcwd().'/nexus/main.php');

	$controller = Controller::getInstance();
	$controller ->recoverPOST('idCommentaire', 'id')
				->recoverPOST('action');

	if ($controller->isNumber($id) && 'supprimer' === $action) {
		$comment = new Commentaire($id);
		$idArticle = $comment->getArticle()->id;
		$comment->supprimer();
		header('Location: ../commentaires.php?id_article='.$idArticle);die;
	}
	header('Location: ../commentaires.php');
