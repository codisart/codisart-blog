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

			$this->pseudo = !empty($pseudo) ? $pseudo : null;
			$this->mail = !empty($mail) ? $mail : null;
			$this->date = !empty($date) ? $date : null;
			$this->message = !empty($message) ? $message : null;
		}

		protected function hydrate() {
			$requete = connexionBDD()->query("
				SELECT id, pseudo, mail, date, message
				FROM messages
				WHERE id='{$this->id}'
				ORDER BY id DESC
				LIMIT 0,1
			");

			$donnees = $requete->fetch();

			$this->pseudo = $donnees['pseudo'];
			$this->mail = $donnees['mail'];
			$this->date = $donnees['date'];
			$this->message = $donnees['message'];
		}

		// Fonctions / Méthodes
		public static function ajouter($pseudo, $mail, $contenu) {
			if (empty($pseudo) || empty($mail) || empty($contenu)) {
				throw new Exception('Les paramètres ne sont pas correctement renseignés.');
			}

			$requete = connexionBDD()->prepare("INSERT INTO message (pseudo, mail, message) VALUES (?, ?, ?)");
			return $requete->execute(array($pseudo, $mail, $contenu));
		}


		public function supprimer() {
			parent::supprimer('messages');
		}


		public function getDateOn2Rows() {
			$date = $this->date;
			return str_replace(' ', "\n", $date);
		}

	}
