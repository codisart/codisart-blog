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
						->recoverPOST('idArticle', 'id')
						->recoverPOST('action');
					
					if (!$asali) {
						$controller 
							->recoverPOST('comment', 'comment')
							->recoverPOST('mail', 'mail')
							->recoverPOST('pseudo', 'pseudo');

						if ('ajouter' === $action) {
							if ($controller->isString($comment) && $controller->isEmailAdresse($mail) && $controller->isString($pseudo) && $controller->isNumber($id)) {					
								Commentaire::ajouter($id, $pseudo, $mail, $comment);
							} else  {						
								echo '<h5 class="error">Votre mail n\'est pas valide !</h5>';		
							}
						}	
					}
						
					$controller ->recoverGET('idArticle', 'id');

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
			
				<div class="encart">
					<h3 class="siderTitre">Who am I ?</h3>
					
					<p class="profil">
						<img src="images/profil.jpg" alt="profil"/>
					
						Bienvenue sur mon blog.<br/><br/>Je m'appelle "Talk2loud" <br/><em>aka</em> "Talky" <br/><em>aka</em> "The loudest" <br/><br/>
						<!--Bienvenue sur mon blog.<br/>  Je m'appelle <em>LoudVoice</em>.<br/> 					
						Je suis un passionné de médias en tout genre avec une grosse préférence pour la littérature, le cinéma et les jeux vidéos.<br/>
						J'ai aussi un très grand intéret pour la sociologie, les mathématiques et l'histoire.
						Par passion et hobby, je développe des sites et des applications internet depuis trois ans.<br/>	-->				
					</p>	
				</div>
				
				<div class="encart">
					<h3 class="siderTitre">Recherche</h3>
					
					<form id="form_recherche" action="recherche.php" class="recherche">
						<p>
							<input id="champ_recherche" class="saisie" name="expression" onfocus="inputRecherche(this);" onblur="inputRecherche(this)" type="text" value="Rechercher" />
							<input class="bouton" type="submit" value="OK" />
						</p>
					</form>
				</div>
						
				<div class="encart">		
					<h3 class="siderTitre">Archives</h3>
					
					<ul class="archives">
						<?php							
							$archives = Blog::getArchives();
							
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
	
	<script type="text/javascript" src="script.js"></script>

</body>
</html>