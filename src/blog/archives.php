<!DOCTYPE html>
<html lang="fr" >

<head>
	<title>Accueil</title>

	<meta charset="utf-8" />

	<link href="styles/general.css" rel="stylesheet" />
	<link href="styles/index.css" rel="stylesheet" />

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
</head>

<body>

	<div id="global">
		<?php
			include "blocs/header.php";
		?>
		<div id="contenu">
			<div id="principal">

				<?php
					require_once('nexus/main.php');

					$controller = Controller::getInstance();

					$controller ->recoverGET('a', 'annee')
								->recoverGET('m', 'mois');

					if (!$controller->isNumber($annee) || !$controller->isNumber($mois)) {
						header('Location: ./');
						exit;
					}

					$listeMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

				?>
					<div id=""><br/><h2><?php echo "{$listeMois[$mois-1]} $annee"; ?></h2><br/></div><hr />

				<?php
					$articles = Article::getArticlesMois($annee, $mois);

					if (false != $articles) :
						foreach ($articles as $article) :
				?>
					<br/>
					<div class="article">

						<div class="entete bleu"></div>

						<h3><?php echo $article->titre; ?></h3>

						<h6>by <span>zeroth</span>, posté le <?php echo $article->date; ?></h6>

						<p>
							<?php echo nl2br($article->getContenu()); ?>
						</p>

						<em>
							<a style="float:left;" href="commentaires.php?idArticle=<?php echo $article->id; ?>">
								Commentaires(<?php echo $article->getAllCommentaires()->count(); ?>)
							</a>
							<a style="float:right;" href="">
								Catégorie
							</a>
						</em>

					</div>

					<hr/>
				<?php
						endforeach;
					else:
				?>
					<h5 class="error">Il n'y a pas d'articles enregistrés pour cette période donnée.</h5>
					<div><a id="retourArticle" href="index.php">Retour à la liste des articles</a></div>
				<?php

					endif;
				?>
			</div>

			<div id="secondaire">
				<?php include "blocs/sidebar.php"; ?>
			</div>
		</div>

		<?php include "blocs/footer.html"; ?>

	</div>

	<script type="text/javascript" src="script.js"></script>

</body>
</html>
