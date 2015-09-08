<?php

	/**
	 *	@property-read string $id
	 *	@property-read string $titre
	 *	@property-read string $date
	 */
	class Article extends Item {

		protected $titre;
		protected $date;
		protected $contenu;
		protected $id;
		protected $commentaires;

		// @TODO ne pas hydrater tout le temps.
		public function __construct($id, $titre = '', $date = 0, $contenu = '') {
			$this->id = $id;

			if ($titre == '' && $date == 0 && $contenu == '') {
				$connexionBDD = connexionBDD();

				$requete = $connexionBDD->query("
					SELECT id, titre, contenu, date
					FROM news
					WHERE id='$id'
					ORDER BY id DESC
					LIMIT 0,1
				");

				$donnees = $requete->fetch();

				$titre = $donnees['titre'];
				$date = $donnees['date'];
				$contenu = $donnees['contenu'];

				unset($connexionBDD);
			}

			$this->titre = $titre;
			$this->date = $date;
			$this->contenu = $contenu;
		}


		// @TODO A mettre dans une librairie.
		public function formatDateFrench() {
			$listeMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

			$this->date = date("j ", strtotime($this->date)).$listeMois[date("n", strtotime($this->date)) - 1].date(" Y, H:i:s", strtotime($this->date));

			return $this;
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
			$connexionBDD = connexionBDD();

			$requete = $connexionBDD->prepare("
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

			unset($connexionBDD);
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
			parent::supprimer('news');
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


		static public function getArticlesMois($year, $month) {
			$mois = "$year/$month";

			$requete = connexionBDD()->prepare("
				SELECT id, titre, contenu, date
				FROM news
				WHERE DATE_FORMAT(date, '%Y/%c') = :mois
				ORDER BY id DESC
			");

			if (false === $requete->execute(array('mois' => $mois))) {
				unset($connexionBDD);
				return false;
			}

			if (false === ($donnees = $requete->fetch())) {
				unset($connexionBDD);
				return false;
			}

			$articles = new Collection();
			do {
				$articles[] = new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
			} while ($donnees = $requete->fetch());

			return $articles;
		}
	}
