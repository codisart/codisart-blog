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
					
					if (!$controller->isNumber($page)) {
						$page = 1;
					}
					$nombreArticles = 10;

					$thisBlog = new Blog();
					$articles = $thisBlog->filtreRecherche($expression)->getArticles();


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
					if ($nombreArticles != 0) {
						var_dump($articles);
						$max_pages = ceil($articles->count()/$nombreArticles);

						if ($page > 1 && $page < $max_pages) { ?>
							<div  style="float:left">
								<a href="index.php?page=<?php echo $page-1; echo $nombreArticles === 10 ? '': '&n='.$nombreArticles; ?>">Recents articles</a>
							</div>
						<?php }

						if ($page < $max_pages) { ?>
							<div  style="float:right">
								<a href="index.php?page=<?php echo $page+1; echo $nombreArticles === 10 ? '': '&n='.$nombreArticles; ?>">Anciens articles</a>
							</div>
						<?php }

						if ($page > $max_pages) { ?>
							<div  style="float:left">
								<a href="index.php?page=1">Retour à la première page</a>
							</div>
						<?php }

					}
				?>
				</div>

			</div>

			<div id="secondaire">
				<h3 class="siderTitre">Who am I ?</h3>

				<p class="presentation">
					<img src="images/profil.jpg" width="100" style="float:left" alt="profil"/>

					Bienvenue sur mon blog.<br/>  Je m'appelle <em>LoudVoice</em>.<br/>
					Je suis un passionné de médias en tout genre avec une grosse préférence pour la littérature, le cinéma et les jeux vidéos.<br/>
					J'ai aussi un très grand intéret pour la sociologie, les mathématiques et l'histoire.
					Par passion et hobby, je développe des sites et des applications internet depuis trois ans.<br/>
				</p>


				<h3 class="siderTitre">Recherche</h3>

				<form id="form_recherche" action="index.php">
					<p>
						<input id="champ_recherche" onfocus="inputRecherche(this);" onblur="inputRecherche(this)" type="text" value="Rechercher" />
						<input type="submit" value="OK" />
					</p>
				</form>


				<h3 class="siderTitre">Archives</h3>
				<ul id="archives">
				<?php
					$archives = Blog::getArchives(); // On récupère un simple array.

					foreach ($archives as $mois => $lien):
				?>
					<li><a href="<?php echo $lien; ?>"><?php echo $mois; ?></a></li>
				<?php
					endforeach;
				?>
				</ul>

			</div>

		</div>

		<?php include "blocs/footer.html"; ?>

	</div>

	<script type="text/javascript" src="script.js"></script>

</body>

</html>
