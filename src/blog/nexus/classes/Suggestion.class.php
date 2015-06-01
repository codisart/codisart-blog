<?php
	
	class Suggestion {
		
		static private $database = "messages";
		
		// private $page;
		// private $adresse;
		// private $nombreMessagesPage;
		// private $viewMessage;
		// private $messages;
		
		/**
		 * @param int $page numéro de la page, int $nombreArticlePage nombre d'articles par page (par défault 10)
		 * constructeur de la classe, initialise les articles de toute la page
		 */
		public function __construct($id, $pseudo = '', $mail = '', $date = 0, $message = '') {
			$this->id = $id;
			
			if($pseudo == '' && $mail == '' && $date == 0 && $message == '') {				
				$connexionBDD = connexionBDD();
				
				$requete = $connexionBDD->query("SELECT id, pseudo, mail, date, message
																	FROM messages 
																	WHERE id='$id'
																	ORDER BY id DESC 
																	LIMIT 0,1");			
			
				$donnees = $requete->fetch();
				
				$pseudo = $donnees['pseudo'];
				$mail = $donnees['mail'];
				$date = $donnees['date'];
				$message = $donnees['message'];
				
				$connexionBDD = NULL;				
			}
			
			$this->pseudo = $pseudo;
			$this->mail = $mail;
			$this->date = $date;
			$this->message = $message;
		}
		
		// Methode Magique
		
		/**
		 *  Permet la lecture seule des membres
		 */		
		public function __get ($nom) {
            if(isset($this->$nom)) {
				return $this->$nom;
			}
			else {
				return "<p class=\"error\">Impossible d'accéder à l'attribut <strong>$nom</strong>, désolé !</p>";
			}
        }
		
		/**
		 *	@return une Collection contenant les messages
		 */		
		public function getCommentaires($page, $nombreMessagesPage = 10) {			 
			$this->page = $page;
			$this->nombreMessagesPage = $nombreMessagesPage;
			
			$this->messages = new Collection();
			
			$limit = ($this->page -1)*$this->nombreMessagesPage;
						
			$requete = connexionBDD()->query("SELECT id, pseudo, date, mail, message
															FROM messages 
															ORDER BY id DESC 
															LIMIT $limit, $nombreMessagesPage");

								
			if (false === ($donnees = $requete->fetch())) {
				$page--;
				if($page <= 0) {
					echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
					$this->nombreMessagesPage = 0;
				}
				header('Location : '.$this->adresse.'?page='.$page);				
			}
			else {
				do {
					$this->messages[$donnees['id']] = new Commentaire($donnees['id'],$donnees['pseudo'], $donnees['date'], $donnees['message']);							
				}
				while ($donnees = $requete->fetch());
			}
															
			$connexionBDD = NULL;				
			
			return $this->messages;
		}		
				
		
		

		// Fonctions / Méthodes		
		public static function ajouter($pseudo, $mail, $contenu) {

			if($pseudo != "" && $mail != "" && $contenu !="") {			
				$connexionBDD = connexionBDD();
											
				$requete = $connexionBDD->prepare("INSERT INTO messages (pseudo, mail, message) VALUES (?, ?, ?)");
			
				if(!$requete->execute(array($pseudo, $mail, $contenu))) {				
					echo '<h5 class="error">Cet article a déjà été supprimé ou n\'existe pas !</h5>';
				}
				else {
					echo '<h5 class="success">votre message a bien été enregistré !!</h5>';
				}
								
				$connexionBDD = NULL;
				
				return true;			
			}
			echo '<h5 class="error">Vous n\'avez pas rempli correctement  le formulaire</h5>';
			return false;
		}
		
		public function supprimer() {
			$id = $this->id;
					
			$connexionBDD = connexionBDD();
				
			if(!$connexionBDD->query("DELETE FROM messages WHERE id ='$id'")) {
				echo 'Ce message a déjà été supprimé ou n\'existe pas !';
			}			
				
			$connexionBDD = NULL;
		}

		public function getDateOn2Rows() {
			$date = $this->date;

			return str_replace(' ', "\n", $date);
		}
			
	}