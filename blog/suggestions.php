<!DOCTYPE html>
<html lang="fr" >

<head>
	<title>Suggestions</title>
	
	<meta charset="utf-8" /> 
	
	<link href="styles/general.css" rel="stylesheet" />

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
</head>
	
	
<body>

	<div id="global">
			
		<?php  
			include "blocs/header.php"; 
		?>
		
		<div id="contenu" class="contenu suggestions">				
			
			<h1 id="messageAccueil">
				Je suis à la recherche d'idées d'applications web innovantes à réaliser.<br/>
				Si vous avez des suggestions, n'hésitez pas à m'en faire part :<br/>
			</h1> 
			
			<h2 id="boutonForm" >Laissez-moi une suggestion !</h2>
			
			<form id="formMessage" action="suggestions.php" onsubmit="return verificationForm();" method="post">			
				
				<img src="images/fermer.png" />
				<h2>Laisser un message :</h2>
				
				<p>
					<input id="pseudo" name="pseudo" type="text" required="required" value=""/>
					<label for="pseudo" >Pseudo <em>(obligatoire)</em></label>
				</p>
				
				<p>
					<input id="mail" name="email" type="text" required="required" value="" />
					<label for="mail" >Email <em>(obligatoire : ne sera pas affiché)</em></label>
				</p>
				
				<p>
					<textarea id="suggestion" name="suggestion" cols="50" rows="9" required="required"></textarea>
				</p>
				
				<p>
					<input type="text" name="asali" id="asali" value="" />
					<input id="submit" name="submit" value="Valider" type="submit" class="button">
				</p>
			</form>
				
				
	
			<?php
				require_once('nexus/main.php');
					
				$controller = Controller::getInstance();
				$controller->recoverPOST('asali');

				if(!$asali) {
					$controller->recoverPOST('suggestion')->recoverPOST('email')->recoverPOST('pseudo');
				}				
				if($controller->isPlainText($suggestion) && $controller->isEmailAdresse($email) && $controller->isString($pseudo)) {	
					Suggestion::ajouter($pseudo,$email,$suggestion);
					unset($pseudo, $email, $suggestion);
				}
				
				$controller->recoverGET('limite');				
				$limite = $controller->isNumber($limite) ? $limite : 15;
				
				$suggestions = Blog::getSuggestions($limite);
				
				$nbreMess = $suggestions->count();				
				
				foreach($suggestions as $suggestion):
			?>
				<div class="message">
					<h3><?php echo htmlspecialchars($suggestion->pseudo); ?>  <em><?php echo $suggestion->date; ?></em></h3>
								
					<p>
						<?php echo nl2br($suggestion->message);  ?>
					</p>
				<!--h4>
					<img src="images/mail.png" title="mail" style="float:left;" /> : <?php //echo $message->email;  ?>
				</h4-->
			</div>
			<?php
				endforeach;
			?>

			<div id="navigationSuggestions">				
				<?php 
					echo "<span>plus de suggestions</span>";
				?>
			</div>
			
		
		</div>

	<?php include "blocs/footer.html"; ?>		   

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="../script_jquery.js"></script>
	<script>
	 $(document).ready( function() {
	 	$('#boutonForm').on('click', function (){
	 		$('#formMessage').show();
	 	});

	 	$('#formMessage img').on('click', function (){
	 		$('#formMessage').hide();
	 	});
	 });
	</script>
	
</body>
</html>