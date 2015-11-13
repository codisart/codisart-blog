<?php

	class Message {

		private $pseudo;
		private $date;
		private $mail;
		private $contenu;
		private $id;

		/**
		 * [__construct description]
		 * @param [type]  $id      [description]
		 * @param string  $pseudo  [description]
		 * @param integer $date    [description]
		 * @param string  $mail    [description]
		 * @param string  $contenu [description]
		 */
		public function __construct($id, $pseudo = "", $date = 0, $mail = "", $contenu = "") {

			$this->id = $id;

			if ($pseudo == '' && $date == 0 && $mail == "" && $contenu == '') {
				$pseudo = "Toto";
				$date = "12";
				$mail = "toto@gmail.com";
				$contenu = "Blahblahblah";
			}

			$this->pseudo = $pseudo;
			$this->date = $date;
			$this->mail = $mail;
			$this->contenu = $contenu;
		}

		/**
		 * Retourne le pseudo de l'internaute qui a écrit le message
		 * @return string
		 */
		public function getPseudo() {
			return $this->pseudo;
		}

		/**
		 * Retourne la date à laquelle l'internaute a écrit son message
		 * @return string
		 */
		public function getDate() {
			return $this->date;
		}

		/**
		 * Retourne l'adresse email de l'internaute qui a écrit le message
		 * @return string
		 */
		public function getEmail() {
			return $this->mail;
		}

		/**
		 * Retourne le contenu du message
		 * @return string
		 */
		public function getContenu() {
			return nl2br(htmlspecialchars($this->contenu));
		}

		/**
		 * Retourne l'identifiant du message en base de donnée
		 * @return integer
		 */
		public function getID() {
			return $this->id;
		}

		/**
		 * Retourne le nombre total de messages en base de données
		 * @return integer
		 */
		public static function getTotal() {
			$requete = connexionBDD()->query("
				SELECT COUNT(1) AS total
				FROM messages
			");

			$donnees = $requete->fetch();
			return $donnees['total'];
		}

		/**
		 * Retourne un booléen explicitant le résultat de l'ajout d'un nouveau message en base de données
		 * @param  string $pseudo  le pseudo de l'internaute qui a écrit le message
		 * @param  string $mail    l'adresse email de l'internaute qui a écrit le message
		 * @param  string $contenu le contenu du message
		 * @return boolean
		 */
		public static function ajouter($pseudo, $mail, $contenu) {

			if ($pseudo != "" && $mail != "" && $contenu != "") {
				$requete = connexionBDD()->prepare("INSERT INTO messages (pseudo, mail, message) VALUES (?, ?, ?)");

				if (!$requete->execute(array($pseudo, $mail, $contenu))) {
					return false;
				}

				return true;
			}

			echo '<h5 class="error">Vous n\'avez pas rempli correctement  le formulaire</h5>';
			return false;
		}

		/**
		 * @TODO Throw Exception
		 * [supprimer description]
		 * @return [type] [description]
		 */
		public function supprimer() {
			if (!connexionBDD()->query("DELETE FROM messages WHERE id ='$this->id'")) {
				echo '<h5 class="error">Ce message a déjà été supprimé ou n\'existe pas !</h5>';
			}
		}
	}
