<?php

	class Message {

		private $pseudo;
		private $date;
		private $mail;
		private $contenu;
		private $id;

		/**
		 * Constructeur de classe
		 * @param integer  $id     l'identifiant du message en base de donnée
		 * @param string  $pseudo  le pseudo de l'internaute qui a écrit le message
		 * @param integer $date    la date à laquelle l'internaute a écrit son message
		 * @param string  $mail    l'adresse email de l'internaute qui a écrit le message
		 * @param string  $contenu le contenu du message
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
		 * Supprime un message de la base de données
		 */
		public function supprimer() {
			$requete = connexionBDD()->prepare("DELETE FROM messages WHERE id = :id");

			if (empty($this->id)) {
				throw new Exception("L'identifiant de message $this->id n'est pas valide");
			}

			if (!$requete->execute(array('id' => $this->id)) {
				throw new Exception("Le message identifié par $this->id a déjà été supprimé ou n\'existe pas !");
			}
		}
	}
