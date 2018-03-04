<!DOCTYPE html>
<html lang="fr" >

<head>
	<title>Accueil</title>

	<meta charset="utf-8" />

	<link href="css/general.css" rel="stylesheet" />

	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
</head>

<?php require_once('nexus/main.php'); ?>
<body>

	<div id="global">
		<?= $templates->render('header') ?>

		<div id="contenu">
			<div id="principal">

			<?php
				$controller = \Codisart\Controller::getInstance();

				$controller
					->recoverGET('a', 'annee')
					->recoverGET('m', 'mois');

					if (!$controller->isNumber($mois)
						|| !$controller->isNumber($annee)
						|| $mois > 12
						|| $mois < 1
						|| $annee < 2010
					) {
						header('Location: ./');
						exit;
					}

				?>
					<div id=""><br/><h2><?= \Codisart\DateTime::MOIS[$mois]." ".$annee; ?></h2><br/></div><hr />

				<?php
					try {
						$articles = \Blog\Blog::getArticlesByMonth($annee, $mois);
					}
					catch (Exception $e) {
						echo '<!-- LOG : '.$e->getMessage().'-->';
						$articles = null;
					}

					if (!empty($articles)) :
						foreach ($articles as $article) :
				?>
					<br/>

					<div class="article">
						<?=$templates->render('article/row', ['article' => $article]) ?>
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
				<?=$templates->render('sidebar') ?>
			</div>
		</div>

		<?=$templates->render('footer') ?>
	</div>
</body>
</html>
