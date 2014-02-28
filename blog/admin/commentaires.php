<?php 
	session_start();
	if(!isset($_SESSION['login'])){header('Location: ../connexion.php');exit;}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<head> 
	<meta charset="utf-8" />
    <title>Session Administrateur</title>	
		
	<link rel="stylesheet" href="css/admin.css" />	
	<link rel="shortcut icon" type="image/x-icon" href="images/admin_favicon.ico" />
</head>
		
<body>
		
	<div id="contenu">
			
		<div id ="navigation">	
			<a class="ongletActif">Accueil</a>
			<a class="onglet" href="deconnexion.php">Se déconnecter</a>
		</div>
		
		<h4><a href="index.php">Retour à la liste des articles.</a></h4>
		
		<hr/>

		<table>
				
			<tr>
			   <th class="pseudo">Pseudo</th>
			   <th class="date">date</th>
			   <th class="commentaires">Message</th>
			   <th class="operations">operations</th>
		   </tr>
			   
			<?php					
				while(empty($directories)){chdir('..'); $directories = glob('nexus');}
				require_once(getcwd().'/nexus/main.php');
				
				GETControler('id_article');
				// if(!controlNumber($page)){ $page = 1;}
				
				$article = new Article($id_article);		
				
				$comments = $article->getCommentaires();//('../views/articleBackOffice.php');

				foreach ($comments as $comment):
		
			?>
				
			<tr class="commentaire" id="commentaire<?php echo $comment->getID(); ?>"> 

				<td class="pseudo"><?php echo $comment->getPseudo(); ?></td>

				<td class="date"><?php echo $comment->getDate(); ?></td>
	
				<td class="contenu"><?php echo $comment->getCommentaire(); ?></td>
				
				<td class="operations">
					<img src="../images/supprimer.png" onclick="supprimerCommentaire('<?php echo $comment->getID(); ?>');" title="Supprimer"/>
				</td>
				
			</tr>			
				
			<?php						
				endforeach;		
			?>
			
		</table>			
			
			
	</div>
	
	
	<script src="script.js"></script>		
</body>

</html>
	