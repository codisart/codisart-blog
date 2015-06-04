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
					
				// Affichage view
				foreach ($articles as $article):
			?>
				<br/>

				<div class="article">
					
					<div class="entete bleu"></div>
					
					<h3><a href="article.php?idArticle=<?php echo $article->id;?>"><?php echo $article->titre; ?></a></h3>
				
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
				<?php
					if ($nombreArticles != 0) {
						$max_pages = ceil(Blog::getAllArticles()->count()/$nombreArticles);

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
			
				<div class="encart">
					<h3 class="siderTitre">Who am I ?</h3>
					
					<p class="profil">
						<img src="images/profil.jpg" alt="profil"/>
					
						Bienvenue sur mon blog.<br/><br/>Passionné de<br/> programmation,<br/> je développe des sites<br/> et des applications<br/> internet depuis 4 ans.
						<br/>Je travaille dans une SS2I.<!--Bienvenue sur mon blog.<br/>  Je m'appelle <em>LoudVoice</em>.<br/> 					
						Je suis un passionné de médias en tout genre avec une grosse préférence pour la littérature, le cinéma et les jeux vidéos.<br/>
						J'ai aussi un très grand intéret pour la sociologie, les mathématiques et l'histoire.
						Par passion et hobby, je développe des sites et des applications internet depuis trois ans.<br/>	
						onfocus="inputRecherche(this);" onblur="inputRecherche(this)" type="text" value="Rechercher" 
						-->				
					</p>	
				</div>
				
				<div class="encart">
					<h3 class="siderTitre">Recherche</h3>
					
					<form id="form_recherche" action="recherche.php" class="recherche">
						<p>
							<input id="champ_recherche" class="saisie" name="expression" placeholder="rechercher" type="text"/>
							<input class="bouton" type="submit" value="OK" />
						</p>
					</form>
				</div>
						
				<div class="encart">		
					<h3 class="siderTitre">Archives</h3>
					
					<ul class="archives">
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
				
				<div class="encart">
					<h3 class="siderTitre" title="Article aléatoire"><a href="article.php?idArticle=<?php echo Blog::getRandomArticle()->id; ?>">Random</a></h3>				
				</div>			
				
			</div>			
		
		</div>
	
	<?php include "blocs/footer.html"; ?>

	</div>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>	
	<script type="text/javascript" src="js/jquery.placeholder.js"></script>
	<?php //ScriptLoader::loadJQueryPlugin("placeholder"); ?>

	<script>
		(function($) {	
			$(document).ready(function() {
				$.placeholder();
			})
		})(jQuery);
	</script>

</body>

</html>