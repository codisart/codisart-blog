<?php

	class Message {

		private $pseudo;
		private $date;
		private $mail;
		private $contenu;
		private $id;
		
		public function __construct($id, $pseudo = "", $date = 0, $mail = "", $contenu = "") {
			
			$this->id = $id;
			
			if($pseudo == '' && $date == 0 && $mail == "" && $contenu == '') {
				$pseudo = "Toto";
				$date= "12";
				$mail = "toto@gmail.com";
				$contenu ="Blahblahblah";
			}

			$this->pseudo = $pseudo;
			$this->date = $date;
			$this->mail = $mail;
			$this->contenu = $contenu;
		}
		
		//fonctions get / Getters 
		public function getPseudo() {		
			return $this->pseudo;
		}
		
		public function getDate() {		
			return $this->date;
		}
		
		public function getEmail() {		
			return $this->mail;
		}

		public function getContenu() {		
			return nl2br(htmlspecialchars($this->contenu));
		}

		public function getID() {		
			return $this->id;
		}
		
		public static function getTotal() {
			$connexionBDD = connexionBDD();
			
			$requete = $connexionBDD->query("SELECT COUNT(*) AS total
																	FROM messages");
																	
			$donnees = $requete->fetch();
																	
			return $donnees['total'];
		}
		
		
		//fonctions / Méthodes				
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
		
		public function supprimer()  {
			$id = $this->id;
					
			$connexionBDD = connexionBDD();
				
			if(!$connexionBDD->query("DELETE FROM messages WHERE id ='$id'")) {
				echo 'Ce message a déjà été supprimé ou n\'existe pas !';
			}			
				
			$connexionBDD = NULL;
		}	
	}