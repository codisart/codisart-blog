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
		<?=$templates->render('header') ?>

		<div id="contenu">

			<div id="principal">
				<?php
					$controller = Controller::getInstance();
					$controller ->recoverGET('expression')
								->recoverGET('page');

					if (!$controller->isString($expression)) {
						header('Location: ./index.php');
						exit;
					}

					echo '<div id=""><br/><h2>Recherche de l\'expression : '.$expression.'</h2><br/></div><hr />';

					if (!$controller->isNumber($page)) {
						$page = 1;
					}
					$nombreArticles = 10;

					$thisBlog = new Blog();
					try {
						$articles = $thisBlog->filtreRecherche($expression)->getArticles($page, $nombreArticles);
						$maxPages = ceil($thisBlog->getNombreAllArticles()/$nombreArticles);
					}
					catch (Exception $e) {
						echo '<!-- LOG : '.$e->getMessage().'-->';
						$articles = new \Codisart\Collection;
						$maxPages = 0;
					}

					if (!count($articles)) {
						echo "<p>Votre recherche n'a rien donnée.</p>";
					}
					else {
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
                        'url' => "recherche.php?expression=$expression",
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
