<?php

/**
 *	@property-read 	string $id
 *	@property 		string $_table
 */
abstract class Item {

	// Methode Magique

	/**
	 *  Permet la lecture seule des propriétes des classes filles.
	 *  @return mixed
	 */
	final public function __get($name) {
		$reflection = new ReflectionClass($this);
		$properties = array_keys($reflection->getdefaultProperties());

		if (isset($this->$name)) {
			return $this->$name;
		}
		else if (in_array($name, $properties)) {
			$this->hydrate();
			return $this->$name;
		}

		throw new Exception("The property $name doesn't exist.");
	}

	/**
	 * @return void
	 */
	abstract protected function hydrate();
	// Fonctions / Méthodes

	/**
	 * @param string $table
	 */
	public static function save(array $datas, $table) {
		$colonnesNamesArr = array_keys($datas);
		$colonnesNamesStr = implode(',', array_keys($datas));
		foreach ($colonnesNamesArr as &$value) {
			$value = ':'.$value;
		}
		$marqueursStr = implode(',', $colonnesNamesArr);

		$requete = connexionBDD()->prepare(
			"INSERT INTO ".
			$table.
			" (".
			$colonnesNamesStr.
			") VALUES (".
			$marqueursStr.
			")"
		);

		if (!$requete->execute($datas)) {
			return false;
		}

		return true;
	}

	public function supprimer() {
		if (empty($this->_table) || empty($this->id)) {
			throw new Exception("L'opération de supression de cet article ne peut pas s'effectuer.");
		}

		$requete = connexionBDD()->prepare("DELETE FROM $this->_table WHERE id = :id");

		if (!$requete->execute(array('id' => $this->id))) {
			throw new Exception("Le message identifié par $this->id a déjà été supprimé de la table $this->_table ou n\'existe pas !");
		}

		return true;
	}
}
