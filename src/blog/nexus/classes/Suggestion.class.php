<?php

	/**
	 *	@property-read string $adresse
	 */
	class Suggestion extends Item {

		protected $page;
		protected $adresse;
		protected $pseudo;
		protected $mail;
		protected $date;
		protected $message;

		public function __construct($id, $pseudo = '', $mail = '', $date = 0, $message = '') {
			$this->id = $id;

			if ($pseudo == '' && $mail == '' && $date == 0 && $message == '') {
				$connexionBDD = connexionBDD();

				$requete = $connexionBDD->query("
					SELECT id, pseudo, mail, date, message
					FROM messages
					WHERE id='$id'
					ORDER BY id DESC
					LIMIT 0,1
				");

				$donnees = $requete->fetch();

				$pseudo = $donnees['pseudo'];
				$mail = $donnees['mail'];
				$date = $donnees['date'];
				$message = $donnees['message'];

				unset($connexionBDD);
			}

			$this->pseudo = $pseudo;
			$this->mail = $mail;
			$this->date = $date;
			$this->message = $message;
		}



		/**
		 *	@return Collection les messages de la page demandée.
		 */
		public function getCommentaires($page, $nombreMessagesPage = 10) {
			$this->page = $page;
			$this->nombreMessagesPage = $nombreMessagesPage;

			$this->messages = new Collection();

			$limit = ($this->page-1)*$this->nombreMessagesPage;

			$requete = connexionBDD()->query("SELECT id, pseudo, date, mail, message
															FROM messages
															ORDER BY id DESC
															LIMIT $limit, $nombreMessagesPage");


			if (false === ($donnees = $requete->fetch())) {
				--$page;

				if ($page <= 0) {
					echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
					$this->nombreMessagesPage = 0;
				}

				header('Location : '.$this->adresse.'?page='.$page);
			}

			do {
				$this->messages[$donnees['id']] = new Commentaire($donnees['id'], $donnees['pseudo'], $donnees['date'], $donnees['message']);
			} while ($donnees = $requete->fetch());

			return $this->messages;
		}


		// Fonctions / Méthodes
		public static function ajouter($pseudo, $mail, $contenu) {
			// @TODO add exception
			if ($pseudo != "" && $mail != "" && $contenu != "") {
				$requete = connexionBDD()->prepare("INSERT INTO messages (pseudo, mail, message) VALUES (?, ?, ?)");

				return !$requete->execute(array($pseudo, $mail, $contenu));
			}

			echo '<h5 class="error">Vous n\'avez pas rempli correctement  le formulaire</h5>';
			return false;
		}

		public function supprimer() {
			parent::supprimer('messages');
		}

		public function getDateOn2Rows() {
			$date = $this->date;

			return str_replace(' ', "\n", $date);
		}

	}
