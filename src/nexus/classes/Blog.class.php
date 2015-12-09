<?php
	class Blog {

		protected $page;
		protected $nombreArticlesPage;
		protected $articles;

		protected $_filtres;
		protected $_where;

		/**
		 * constructeur de la classe
		 */
		public function __construct() {
			$this->page = 1;
			$this->nombreArticlesPage = 10;

			$this->_filtres = array();
		}


		/**
		 *	@return integer le numéro de la page
		 */
		public function getPage() {
			return $this->page;
		}


		/**
		 *	@return integer le nombre d'articles de la page
		 */
		public function getNombreArticlesPage() {
			return $this->nombreArticlesPage;
		}


		/**
		 * 	@TODO throw Exception when no articles
		 *	@return Collection les articles de la page demandée
		 */
		public function getArticles($page = 1, $nombreArticlesPage = 10) {
			if (!empty($this->articles)) {
				return $this->articles;
			}

			$this->page = $page;
			$this->nombreArticlesPage = $nombreArticlesPage;

			$limit = ($this->page - 1)*$this->nombreArticlesPage;

			$where = $this->buildWhereConditions();

			$requete = connexionBDD()->prepare("
				SELECT id, titre, contenu, date
				FROM news
				{$where['condition']}
				ORDER BY date DESC, id DESC
				LIMIT $limit, $nombreArticlesPage
			");

			if (false === $requete->execute($where['values'])) {
				return false;
			}

			$this->articles = new Collection();
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
				$this->nombreArticlesPage = 0;
				return $this->articles;
			}

			do {
				$this->articles[] = new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
			} while ($donnees = $requete->fetch());

			return $this->articles;
		}


		/**
		 *	@return Collection Tous les articles en base de données selon filtres.
		 */
		public function getAllArticles() {
			$articles = new Collection();

			$where = $this->buildWhereConditions();

			$requete = connexionBDD()->prepare("
				SELECT id, titre, contenu, date
				FROM news
				{$where['condition']}
				ORDER BY date DESC, id DESC
			");

			if (false === $requete->execute($where['values'])) {
				return false;
			}

			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
				return $articles;
			}

			do {
				$articles[] = new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
			} while ($donnees = $requete->fetch());

			return $articles;
		}


		/**
		 *	@return int nombre total de tous les articles.
		 */
		public function getNombreAllArticles() {
			$where = $this->buildWhereConditions();

			$requete = connexionBDD()->prepare("
				SELECT COUNT(1) as total
				FROM news
				{$where['condition']}
			");

			if (false === $requete->execute($where['values'])) {
				return false;
			}

			if (false === ($donnees = $requete->fetch())) {
				return 0;
			}

			return $donnees['total'];
		}


		/**
		 * 	@param integer $index numero de l'article dans le tableau contenu
		 *	@return Article l'article
		 */
		public function getArticle($index) {
			return $this->articles[$index];
		}


		/**
		 *	@return Article un article au hasard.
		 */
		public static function getRandomArticle() {
			$requete = connexionBDD()->prepare("
				SELECT id, titre, contenu, date
				FROM news
				ORDER BY rand() LIMIT 1
			");

			if (false === $requete->execute() || false === ($donnees = $requete->fetch())) {
				throw new Exception("Error Processing Request", 1);
			}

			return new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
		}


		public static function getArchives() {
			$requete = connexionBDD()->prepare("
				SELECT
					DISTINCT DATE_FORMAT(date, '%c') as mois,
					DATE_FORMAT(date, '%Y') as year
				FROM news
				ORDER BY date DESC
			");

			if (false === $requete->execute()) {
				// @TODO throw exception
				return false;
			}

			$archives = new Collection();

			if (false === ($donnees = $requete->fetch())) {
				return $archives;
			}

			do {
				$mois = Codisart\Nexus\DateTime::MOIS[$donnees['mois']].' '.$donnees['year'];
				$lien = "archives.php?a={$donnees['year']}&m={$donnees['mois']}";
				$archives[$mois] = $lien;
			}
			while ($donnees = $requete->fetch());

			return $archives;
		}


		public function filtreRecherche($query) {
			$this->articles = null;
			$this->_where = null;

			$this->_filtres[] = array(
				"condition" => "contenu LIKE :term OR titre LIKE :term",
				"value" => array(
					":term" => "%{$query}%"
				)
			);

			return $this;
		}

		/**
		 *	@return Collection $messages collection des messages
		 */
		static public function getAllSuggestions() {
			$requete = connexionBDD()->prepare("
				SELECT id, pseudo, date, mail, message
				FROM messages
				ORDER BY date DESC, id DESC
			");

			if (false === $requete->execute()) {
				// @TODO throw exception
				return false;
			}

			$suggestions = new Collection();

			if (false === ($donnees = $requete->fetch())) {
				return $suggestions;
			}

			do {
				$suggestions[$donnees['id']] = new Suggestion($donnees['id'], $donnees['pseudo'], $donnees['mail'], $donnees['date'], $donnees['message']);
			} while ($donnees = $requete->fetch());

			return $suggestions;
		}

		protected function buildWhereConditions() {
			if (!empty($this->_where['condition'])) {
				return $this->_where;
			}

			$this->_where = array(
				'condition' => "",
				'values' => array()
			);

			if (!empty($this->_filtres)) {
				$this->_where['condition'] = 'WHERE 1 = 1 ';
				foreach ($this->_filtres as $key => $filtre) {
					$this->_where['condition'] .= 'AND '.$filtre['condition'];
					$this->_where['values'] = array_merge($this->_where['values'], $filtre['value']);
				}
			}

			return $this->_where;
		}

	}
