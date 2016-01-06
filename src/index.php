<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Accueil</title>

	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles/general.css" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

	<noscript>
        <style> #global{display:none;} body{background: white;}</style>
    </noscript>
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
						$articles = null;
						$maxPages = 0;
					}

					if (empty($articles)) {
						echo "<p>Il n'y a aucun article à afficher </p>";
					}
					else {
					// Affichage view
						foreach ($articles as $article) {
				?>
				<br/>

				<div class="article">
					<?php include "blocs/article-row.php"; ?>
				</div>

				<hr/>
				<?php
						}
					}
				?>

				<div id="navigationBlog">
					<?php
						$url = 'index.php?';
						include "blocs/navigation.php";
					?>
				</div>
			</div>

			<div id="secondaire">
				<?php include "blocs/sidebar.php"; ?>
			</div>

		</div>

	<?php include "blocs/footer.html"; ?>

	</div>

</body>

</html>
