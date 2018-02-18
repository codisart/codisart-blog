<?php

	/**
	 * @property string $_table
	 * @property-read string $id
	 * @property-read string $titre
	 * @property-read string $date
	 */
	class Article extends Item {

		protected $_table = 'news';

		protected $titre;
		protected $date;
		protected $contenu;
		protected $id;
		protected $commentaires;

		public function __construct($id, $titre = '', $date = 0, $contenu = '') {
			if (!parent::__construct($id)) {
				$this->id = $id;
				$this->titre = !empty($titre) ? $titre : null;
				$this->date = !empty($date) ? $date : null;
				$this->contenu = !empty($contenu) ? $contenu : null;
			}
		}

		protected function hydrate() {
			$requete = connexionBDD()->prepare("
				SELECT id, titre, contenu, date
				FROM news
				WHERE id=:id
				ORDER BY id DESC
				LIMIT 0,1
			");

			$requete->execute(array('id' => $this->id));
			$donnees = $requete->fetch();

			$this->titre = $donnees['titre'];
			$this->date = $donnees['date'];
			$this->contenu = $donnees['contenu'];
		}

		public function getDate() {
			$date = new Codisart\Nexus\DateTime($this->date);
			return $date->format('j F Y à H:i:s');
		}

		public function getContenu() {
			return nl2br($this->contenu);
		}


		public function getContenuLimite($nbreMots = 20) {

			$contenu = $this->getContenu();
			$contenu_limite = '';

			if (substr_count($contenu, ' ') - $nbreMots > 10) {
				$contenu = explode(' ', $contenu);
				for ($i = 0; $i < 20; $i++) {
					$contenu_limite .= $contenu[$i].' ';
				}

				$contenu_limite .= '...<br/><em><a href="article.php?idArticle='.$this->id.'">Lire la suite -></a></em>';
				return $contenu_limite;
			}
			return $contenu;
		}


		public function getAllCommentaires() {
			$requete = connexionBDD()->prepare("
				SELECT id, pseudo, date, commentaire
				FROM commentaires
				WHERE id_news = :id
				ORDER BY date DESC
			");

			$this->commentaires = new Collection();

			$requete->execute(array('id' => $this->id));

			if (false !== ($donnees = $requete->fetch())) {
				do {
					$commentaire = new Commentaire($donnees['id']);
					$commentaire->setPseudo($donnees['pseudo']);
					$commentaire->setDate($donnees['date']);
					$commentaire->setCommentaire($donnees['commentaire']);
					$this->commentaires[] = $commentaire;

				} while ($donnees = $requete->fetch());
			}

			return $this->commentaires;
		}


		//Setters
		public function setContenu($newContenu) {
			return $this->setAttribute('contenu', $newContenu);
		}


		public function setTitre($newTitre) {
			return $this->setAttribute('titre', $newTitre);
		}

		/**
		 * @param string $name
		 */
		protected function setAttribute($name, $newValue) {
			if ($newValue === $this->$name) {
				return $this;
			}

			$id = $this->id;
			$this->$name = $newValue;

			$connexionBDD = connexionBDD();

			$requete = $connexionBDD->prepare("UPDATE news SET $name = ? WHERE id ='$id'");
			$requete->execute(array($newValue));

			return $this;
		}


		// Fonctions / Méthodes
		public function supprimer() {
			parent::supprimer();
		}


		public static function ajouter($titre, $contenu) {
			if (!empty($titre) && !empty($contenu)) {
				return self::save(
					array(
						'titre' 	=> $titre,
						'contenu' 	=> $contenu,
					),
					'news'
				);
			}
		}
	}
