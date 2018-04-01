<?php

namespace Blog;

use Codisart\Item;

/**
 * @property string $_table
 * @property-read string $adresse
 */
class Suggestion extends Item {

	protected $_table = 'messages';

	protected $id;
	protected $page;
	protected $adresse;
	protected $pseudo;
	protected $mail;
	protected $date;
	protected $message;

	public function __construct($id, $pseudo = '', $mail = '', $date = 0, $message = '') {
		if (!$this->init($id)) {
			$this->id = $id;

			$this->pseudo = !empty($pseudo) ? $pseudo : null;
			$this->mail = !empty($mail) ? $mail : null;
			$this->date = !empty($date) ? $date : null;
			$this->message = !empty($message) ? $message : null;
		}
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

	/**
	 * Ajouter une nouvelle suggestion en vase de données
	 * @param  string $pseudo  le pseudo de l'internaute ayant ajouté la suggestion
	 * @param  string $mail    l'adresse email de l'internaute ayant ajouté la suggestion
	 * @param  string $contenu le contenu de la suggestion
	 * @return bool
	 */
	public static function ajouter($pseudo, $mail, $contenu) {
		if (empty($pseudo) || empty($mail) || empty($contenu)) {
			throw new \Exception('Les paramètres ne sont pas correctement renseignés.');
		}

		$requete = connexionBDD()->prepare("INSERT INTO messages (pseudo, mail, message) VALUES (?, ?, ?)");
		return $requete->execute([$pseudo, $mail, $contenu]);
	}

	/**
	 * Renvoie la date de l'objet avec un retour à la ligne entre la date et l'heure.
	 * @return string
	 */
	public function getDateOn2Rows() {
		return str_replace(' ', "\n", $this->date);
	}

}
