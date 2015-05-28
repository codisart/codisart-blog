<?php
	
	class User {
		private $username;
		private $password;
		
		
		public function __construct() {		
			
		}

		static public function validLogin($username, $password) {
			$passwordToCompare = self::getPassword($username);
			//$passwordToCompare = 'cl697710';

			if($username == 'punkka' && $password == $passwordToCompare) {
				return true;
			}
		}

		static public function getPassword($username) {
			// requete table Users
			$connexionBDD = connexionBDD();
						
			$requete = $connexionBDD->query("SELECT password
												FROM users 
												WHERE name ='$username'
												LIMIT 0,1
												");

			if (false === ($donnees = $requete->fetch())) {
				return false;
			}
			else {
				$password = $donnees['password'];
			}
						
			$connexionBDD = NULL;

			return $password;
		}
	}