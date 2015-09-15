<?php
	class Blog {

		private $page;
		private $nombreArticlesPage;
		private $articles;

		/**
		 * constructeur de la classe
		 */
		public function __construct() {
			$this->page = 1;
			$this->nombreArticlesPage = 10;
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
		 *	@return Collection les articles de la page demandée
		 */
		public function getArticles($page = 1, $nombreArticlesPage = 10) {
			if (!empty($this->articles)) {
				return $this->articles;
			}

			$this->page = $page;
			$this->nombreArticlesPage = $nombreArticlesPage;

			$limit = ($this->page - 1)*$this->nombreArticlesPage;

			$requete = connexionBDD()->query("
				SELECT id, titre, contenu, date
				FROM news
				ORDER BY date DESC, id DESC
				LIMIT $limit, $nombreArticlesPage
			");

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
		 *	@return Collection Tous les articles en base de données.
		 */
		public static function getAllArticles() {
			$articles = new Collection();

			$requete = connexionBDD()->query("
				SELECT id, titre, contenu, date
				FROM news
				ORDER BY date DESC, id DESC
			");

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
		public static function getNombreAllArticles() {

			$requete = connexionBDD()->query("
				SELECT COUNT(1) as total
				FROM news
			");

			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles enregistrés</h5>';
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
			$requete = connexionBDD()->query("
				SELECT id, titre, contenu, date
				FROM news
				ORDER BY rand() LIMIT 1
			");

			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'article sélectionné</h5>';
				return null;
			}

			$article = new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);

			return $article;
		}

		public static function getArchives() {

			$requete = connexionBDD()->query("
				SELECT
					DISTINCT DATE_FORMAT(date, '%c') as mois,
					DATE_FORMAT(date, '%Y') as year
				FROM news
				ORDER BY date DESC
			");

			$archives = new Collection();

			if (false === ($donnees = $requete->fetch())) {
				return $archives;
			}

			do {
				$mois = Codisart\Nexus\DateTime::Mois[$donnees['mois']].' '.$donnees['year'];
				$lien = "archives.php?a={$donnees['year']}&m={$donnees['mois']}";
				$archives[$mois] = $lien;
			}
			while ($donnees = $requete->fetch());

			return $archives;
		}


		public function filtreRecherche($query) {
			$page = $this->page;
			$nombreArticlesPage = $this->nombreArticlesPage;

			$limit = ($page - 1)*$nombreArticlesPage;

			$requete = connexionBDD()->query("
				SELECT id, titre, contenu, date
				FROM news
				WHERE contenu LIKE '%".$query."%'
					OR titre LIKE '%".$query."%'
				ORDER BY date DESC, id DESC
				LIMIT ".$limit.", ".$nombreArticlesPage
			);

			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
				return $this;
			}

			$this->articles = new Collection();
			do {
				$this->articles[] = new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
			} while ($donnees = $requete->fetch());

			return $this;
		}

		/**
		 *	@return Collection $messages collection des messages
		 */
		static public function getAllSuggestions() {
			$suggestions = new Collection();

			$requete = connexionBDD()->query("
				SELECT id, pseudo, date, mail, message
				FROM messages
				ORDER BY date DESC, id DESC
			");

			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas de messages sélectionnés</h5>';
				return $suggestions;
			}

			do {
				$suggestions[$donnees['id']] = new Suggestion($donnees['id'], $donnees['pseudo'], $donnees['mail'], $donnees['date'], $donnees['message']);
			} while ($donnees = $requete->fetch());

			return $suggestions;
		}

	}
