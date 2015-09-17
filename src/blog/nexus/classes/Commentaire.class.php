<?php

	class Commentaire extends Item {

		protected $id;
		protected $pseudo;
		protected $date;
		protected $contenu;

		public function __construct($id) {
			$this->id = $id;
		}

		protected function hydrate() {
			$requete = connexionBDD()->query("
				SELECT id, pseudo, date, commentaire
				FROM commentaires
				WHERE id='{$this->id}'
				ORDER BY id DESC
				LIMIT 0,1
			");

			$donnees = $requete->fetch();

			$this->pseudo = $donnees['pseudo'];
			$this->date = $donnees['date'];
			$this->contenu = $donnees['contenu'];
		}

		public static function ajouter($idArticle, $pseudo, $mail, $comment) {

			if ($pseudo != "" && $mail != "" && $comment != "") {
				$requete = connexionBDD()->prepare("INSERT INTO commentaires (id_news, pseudo, mail, commentaire) VALUES (?, ?, ?, ?)");

				if (!$requete->execute(array($idArticle, $pseudo, $mail, $comment))) {
					return false;
				}
				return true;
			}

			echo '<h5 class="error">Vous n\'avez pas rempli correctement le formulaire</h5>';
			return false;
		}


		public function supprimer() {
			parent::supprimer('commentaires');
		}

		public function getDateOn2Rows() {
			$date = $this->date;

			return str_replace(' ', "<br/>", $date);
		}

		public function setPseudo($pseudo) {
			$this->pseudo = $pseudo;
		}


		public function setDate($date) {
			$this->date = $date;
		}


		public function setCommentaire($commentaire) {
			$this->contenu = $commentaire;
		}
	}
