<?php

	abstract class Item {

        // Methode Magique

        /**
         *  Permet la lecture seule des membres
         */
        final private function __get($nom) {

            if (isset($this->$nom)) {
                return $this->$nom;
            }
            return "<p class=\"error\">Impossible d'accéder à l'attribut <strong>$nom</strong>, désolé !</p>";
        }

        // Fonctions / Méthodes

		public function supprimer($table) {
            if(empty($table) || empty($this->id)) {
                // @TODO throw execption
                return $false;
            }
			$id = $this->id;

			if (!connexionBDD()->query("DELETE FROM $table WHERE id ='$id'")) {
				echo 'Cet article a déjà été supprimé ou n\'existe pas !';
				return false;
			}

			return true;
		}
    }
