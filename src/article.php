<!DOCTYPE html>
<html lang="fr" >

<head>
	<title>Accueil</title>

	<meta charset="utf-8" />

	<link href="styles/general.css" rel="stylesheet" />
	<!--link href="styles/index.css" rel="stylesheet" /-->

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
</head>


<body>

	<div id="global">
		<?php
			include "blocs/header.php";
		?>

		<div id="contenu">

			<div id="principal">

				<a id="retourArticle" href="index.php">Retour à la liste des articles</a>

				<?php
					require_once('nexus/main.php');

					$controller = Controller::getInstance();
					$controller
						->recoverPOST('asali')
						->recoverPOST('idArticle', 'id');

					if (!$asali) {
						$controller
							->recoverPOST('comment', 'comment')
							->recoverPOST('mail', 'mail')
							->recoverPOST('pseudo', 'pseudo')
							->recoverPOST('action');

						if ('ajouter' === $action) {
							if ($controller->isString($comment) && $controller->isEmailAddress($mail) && $controller->isString($pseudo) && $controller->isNumber($id)) {
								Commentaire::ajouter($id, $pseudo, $mail, $comment);
							}
							else {
								echo '<h5 class="error">Votre mail n\'est pas valide !</h5>';
							}
						}
					}

					$controller->recoverGET('idArticle', 'id');
					$article = new Article($id);
				?>

				<br/>

				<div class="article">

					<div class="entete bleu"></div>

					<h3><a href="commentaires.php?idArticle=<?php echo $article->id; ?>"><?php echo $article->titre; ?></a></h3>

					<h6>by <span>punkka</span>, posté le <?php echo $article->date; ?></h6>

					<p>
						<?php echo nl2br($article->getContenu()); ?>
					</p>

					<em>
						<a style="float:right;" href="">
							Catégorie
						</a>
					</em>

				</div>

				<hr/>
				<?php
					$comments = $article->getAllCommentaires();
				?>
				<h2 id="nombreCommentaires" ><?php echo $comments->count(); ?> commentaires postés. <a href="#formCommentaire">Laisser un commentaire</a></h2>

				<?php
					foreach ($comments as $comment):
				?>
					<div class="commentaire">
						<h3><?php echo $comment->pseudo; ?> <em><?php echo $comment->date; ?></em></h3>

						<p>
							<?php echo $comment->contenu; ?>
						</p>
					</div>
				<?php
					endforeach;
				?>

				<hr/>

				<form id="formCommentaire" action="article.php?idArticle=<?php echo $id; ?>" method="POST">
					<h2>Laisser un commentaire :</h2>

					<p>
						<input id="pseudo" name="pseudo" type="text" required="required" value="" >
						<label for="pseudo" >Pseudo <em>(obligatoire)</em></label>
						<input type="hidden" name="idArticle" value="<?php echo $id; ?>">
						<input type="hidden" name="action" value="ajouter">
					</p>

					<p>
						<input id="mail" name="mail" type="text" required="required" value="" >
						<label for="mail" >Email <em>(obligatoire)</em> <strong>*ne sera pas publié</strong></label>
					</p>

					<p>
						<textarea id="comment" name="comment" cols="50" rows="9" required="required"></textarea>
					</p>

					<p>
						<input type="text" name="asali" id="asali" value="" />
						<input id="submit" name="submit" value="Valider" type="submit" class="button">
					</p>
				</form>

			</div>

			<div id="secondaire">
				<?php include "blocs/sidebar.php"; ?>
			</div>

		</div>

	<?php include "blocs/footer.html"; ?>

	</div>

</body>
</html>
