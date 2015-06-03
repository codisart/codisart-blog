<?php 
			
	class Commentaire {
		private $id;
		private $pseudo;
		private $date;
		private $contenu;
		
		public function __construct($id, $pseudo, $date, $contenu) {			
			
			$this->id = $id;
			$this->pseudo = $pseudo;
			$this->date = $date;
			$this->contenu = $contenu;				
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
					
				
		public static function ajouter($idArticle, $pseudo, $mail, $comment) {
			
			if($pseudo != "" && $mail != "" && $comment !="") {			
				$connexionBDD = connexionBDD();
				
				$requete = $connexionBDD->prepare("INSERT INTO commentaires (id_news, pseudo, mail, commentaire) VALUES (?, ?, ?, ?)");
			
				if(!$requete->execute(array($idArticle, $pseudo, $mail, $comment))) {				
					echo '<h5 class="error">On ne peut pas enregistrer ce contenu !</h5>';
				}
				else {
					echo '<h5 class="success">Votre contenu a bien été enregistré !!</h5>';
				}
								
				$connexionBDD = NULL;
				
				return TRUE;			
			}
			
			echo '<h5 class="error">Vous n\'avez pas rempli correctement le formulaire</h5>';
			
			return FALSE;			
		}
		
		
		public static function supprimer($idContenu) {		
			$connexionBDD = connexionBDD();
				
			$requete = $connexionBDD->prepare("DELETE FROM commentaires WHERE id = :id");
			
			if(false === $requete->execute(array('id' => $idContenu))) {				
				echo '<h5 class="error">On ne peut pas supprimer ce contenu !</h5>';
				
				$connexionBDD = NULL;				
				return FALSE;			
			}
			
			$connexionBDD = NULL;	
			return TRUE;			
		}

		public function getDateOn2Rows() {
			$date = $this->date;

			return str_replace(' ', "<br/>", $date);
		}
	}