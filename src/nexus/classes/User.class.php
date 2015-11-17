<?php

	class User {

		public function __construct() {

		}

		static public function validLogin($username, $password) {
			$passwordToCompare = self::getPassword($username);

			if ($username == 'punkka' && $password == $passwordToCompare) {
				return true;
			}
		}

		/**
		 * retourne le password de l'utilisateur
		 * @param  string $username pseudo de l'utilisateur
		 * @return string
		 */
		static public function getPassword($username) {

			// requete table Users
			$requete = connexionBDD()->query("
				SELECT password
				FROM users
				WHERE name = '$username'
				LIMIT 0,1
			");

			if (false === ($donnees = $requete->fetch())) {
				return false;
			}
			$password = $donnees['password'];

			return $password;
		}
	}
