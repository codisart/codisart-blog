<?php

	/**
	 * @property string $_table
	 */
	class Commentaire extends Item {
		protected $_table = 'commentaires';

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

		public function getDateOn2Rows() {
			$date = $this->date;

			return str_replace(' ', "<br/>", $date);
		}

		public function getArticle() {
			$requete = connexionBDD()->query("
				SELECT news.id, news.titre, news.contenu, news.date
				FROM news
					INNER JOIN commentaires ON news.id = commentaires.id_news
				WHERE commentaires.id='{$this->id}'
				ORDER BY id DESC
				LIMIT 0,1
			");

			if (false === ($donnees = $requete->fetch())) {
				return null;
			}

			return new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
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
