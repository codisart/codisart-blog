<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Accueil</title>

	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles/general.css" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
</head>

<?php require_once('nexus/main.php'); ?>
<body>

	<div id="global">
		<?=$templates->render('header') ?>

		<div id="contenu">

			<div id="principal">
				<?php
					$controller = Controller::getInstance();
					$controller ->recoverGET('page')
								->recoverGET('p', 'page')
								->recoverGET('n', 'nombreArticles');

					$page = $controller->isNumber($page) ? (int) $page : 1;
					$nombreArticles = $controller->isNumber($nombreArticles) ? $nombreArticles : 10;

					// Definition de la première page
					define('FIRST_PAGE', 1);

					// Affichage si première page.
					echo (FIRST_PAGE === $page) ? '<div id=""><br/><h2>Derniers Articles</h2><br/></div><hr />' : "";

					$thisBlog = new Blog();
					try {
						$articles = $thisBlog->getArticles($page, $nombreArticles);
						$maxPages = ceil($thisBlog->getNombreAllArticles()/$nombreArticles);
					}
					catch (Exception $e) {
						echo '<!-- LOG : '.$e->getMessage().'-->';
						$articles = new Collection;
						$maxPages = 0;
					}

					if (!count($articles)) {
						echo "<p>Il n'y a aucun article à afficher.</p>";
					}
					else {
					// Affichage view
						foreach ($articles as $article) {
				?>
				<br/>

				<div class="article">
					<?=$templates->render('article/row', array('article' => $article)) ?>
				</div>

				<hr/>
				<?php
						}
					}
				?>

				<div id="navigationBlog">
					<?=$templates->render('navigation', array(
						'url' => 'index.php?',
						'maxPages' => $maxPages,
						'page' => $page,
						'nombreArticles' => $nombreArticles,
					)) ?>
				</div>
			</div>

			<div id="secondaire">
				<?=$templates->render('sidebar') ?>
			</div>

		</div>

	<?=$templates->render('footer') ?>

	</div>

</body>

</html>
