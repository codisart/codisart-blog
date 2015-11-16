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
					$controller
						->recoverGET('expression')
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
					$articles = $thisBlog->filtreRecherche($expression)->getArticles($page, $nombreArticles);
					$maxPages = ceil($thisBlog->getNombreAllArticles()/$nombreArticles);

					foreach ($articles as $article) :
				?>
					<br/>
					<div class="article">

						<div class="entete bleu"></div>

						<h3><a href="article.php?idArticle=<?php echo $article->id; ?>"><?php echo $article->titre; ?></a></h3>

						<h6>by <span>punkka</span>, posté le <?php echo $article->date; ?></h6>

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
					<?php
						$url = "recherche.php?expression=$expression";
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

	<script type="text/javascript" src="script.js"></script>

</body>

</html>
