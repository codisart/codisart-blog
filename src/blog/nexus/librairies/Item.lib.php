<?php

/**
 *	@property-read string $id
 */
abstract class Item {

	// Methode Magique

	/**
	 *  Permet la lecture seule des membres
	 */
	final public function __get($name) {
		$reflection = new ReflectionClass($this);
		$properties = array_keys($reflection->getdefaultProperties());

		if (isset($this->$name)) {
			return $this->$name;
		}
		else if(in_array($name, $properties)) {
			$this->hydrate();
			return $this->$name;
		}
		// @TODO throw Exception
		return false;
	}

	private function hydrate() {
		return true;
	}
	// Fonctions / Méthodes


	public static function save($datas) {
		$cols = implode(',', array_keys($datas));
		$questionMarks = implode(',' , array_fill(0, count($cols), '?'));

		$requete = connexionBDD()->prepare(
			"INSERT INTO ".
			$table.
			" (".
			$cols.
			") VALUES (".
			$questionMarks.
			")");

		if (!$requete->execute(array($titre, $contenu))) {
			return false;
		}

		return true;
	}

	/**
	 * @param string $table
	 */
	public function supprimer($table) {
		if (empty($table) || empty($this->id)) {
			// @TODO throw execption
			return false;
		}
		$id = $this->id;

		if (!connexionBDD()->query("DELETE FROM $table WHERE id ='$id'")) {
			echo 'Cet article a déjà été supprimé ou n\'existe pas !';
			return false;
		}

		return true;
	}
}
