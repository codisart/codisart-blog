<?php 
	if (!isset($_SESSION)){session_start();}
	if (!isset($_SESSION['login'])){require 'connexion.php';exit();}
?>

<!DOCTYPE html>
<html lang="fr" >

<head> 
	<meta charset="utf-8" /> 

	<title>CodisArt - Back Office - Divers</title>	
	
	<link rel="stylesheet" href="css/admin.css" />	
	<link rel="shortcut icon" type="image/x-icon" href="images/admin_favicon.ico" />
</head>


<body>
	
	<div class="global">
	
		<header>
			<h1>Bienvenue sur le back-office du blog !</h1>			
		</header>
	
	
		<nav class="nav">
			<ul>
				<li class="tab"><a class="option" href="index.php">Articles</a></li></li>
				<li class="tab"><a class="option" href="suggestions.php">Suggestions</a></li>
				<li class="tab actif"><a class="option" href="divers.php">Divers</a></li>
				<li class="tab"><a class="option" href="deconnexion.php">Se déconnecter</a></li>
			</ul>
		</nav>
	

		<div class="contenu grand">
		
			<button class="button" id="bannir-adresse">Bannir une adresse IP</button>
			<button class="button" id="">Langue</button>
			<button class="button" id="">Catégorie</button>
			<button class="button" id="">Bannir une adresse IP</button>
				
		</div>	
	
		<footer>
			<h3>© punkka</h3>
			<h4>Since 2010</h4>			
		</footer>		
		
	</div>
	
	<div id="brouillard" onclick="cacher(this.id);cacher('lightbox');$('lightbox').innerHTML='';"></div>
	<div id="lightbox"></div>
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="../script_jquery.js"></script>
	
	<script type="text/javascript">
		$(document).ready( function() {
			
		});
	</script>
		
</body>

</html>
	