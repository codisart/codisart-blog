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
	<noscript>
        <div>
        	<p>Veuillez activer Javascript !</p>
        </div>
    </noscript>
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

				$page = $controller->isNumber($page) ? $page : 1;
				$nombreArticles = $controller->isNumber($nombreArticles) ? $nombreArticles : 10;

				// Definition de la première page
				define('FIRST_PAGE', 1);

				// Affichage si première page.
				echo (FIRST_PAGE === $page) ? '<div id=""><br/><h2>Derniers Articles</h2><br/></div><hr />' : "";

				$thisBlog = new Blog();
				$articles = $thisBlog->getArticles($page, $nombreArticles);
				$maxPages = ceil(Blog::getNombreAllArticles()/$nombreArticles);

				// Affichage view
				foreach ($articles as $article):
			?>
				<br/>

				<div class="article">

					<div class="entete bleu"></div>

					<h3><a href="article.php?idArticle=<?php echo $article->id; ?>"><?php echo $article->titre; ?></a></h3>

					<h6>par <span>punkka</span>, posté le <?php echo $article->date; ?></h6>

					<p>
					<?php echo nl2br($article->getContenu()); ?>
					</p>

					<em>
						<a style="float:left;" href="article.php?idArticle=<?php echo $article->id; ?>#nombreCommentaires">
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
			?>
				<div id="navigationBlog">
					<?php include "blocs/navigation.php"; ?>
				</div>
			</div>

			<div id="secondaire">
				<?php include "blocs/sidebar.php"; ?>
			</div>

		</div>

	<?php include "blocs/footer.html"; ?>

	</div>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.placeholder.js"></script>

	<script>
		(function($) {
			$(document).ready(function() {
				$.placeholder();
			})
		})(jQuery);
	</script>

</body>

</html>
