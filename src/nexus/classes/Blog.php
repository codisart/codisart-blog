<?php

namespace Blog;

use Codisart\Reacher;

class Blog extends Reacher {

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

		$this->_filtres = [];
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

		$limit = ($this->page - 1) * $this->nombreArticlesPage;

		$where = $this->buildWhereConditions();

		$requete = connexionBDD()->prepare("
			SELECT id, titre, contenu, date
			FROM news
			{$where['condition']}
			ORDER BY date DESC, id DESC
			LIMIT $limit, $nombreArticlesPage
		");

		$requete->execute($where['values']);

		return $this->fetchAll($requete, \Blog\Article::class);
	}


	/**
	 *	@return Collection Tous les articles en base de données selon filtres.
	 */
	public function getAllArticles() {
		$where = $this->buildWhereConditions();

		$requete = connexionBDD()->prepare("
			SELECT id, titre, contenu, date
			FROM news
			{$where['condition']}
			ORDER BY date DESC, id DESC
		");

		$requete->execute($where['values']);

		return $this->fetchAll($requete, \Blog\Article::class);
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

		$requete->execute($where['values']);

		if (!($donnees = $requete->fetch())) {
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

		$requete->execute();

		$archives = new \Codisart\Collection();

		while ($requete && $donnees = $requete->fetch()) {
			$mois = \Codisart\Nexus\DateTime::MOIS[$donnees['mois']].' '.$donnees['year'];
			$lien = "archives.php?a={$donnees['year']}&m={$donnees['mois']}";
			$archives[$mois] = $lien;
		}

		return $archives;
	}


	public function filtreRecherche($query) {
		$this->articles = null;
		$this->_where = null;

		$this->_filtres[] = [
			"condition" => "contenu LIKE :term OR titre LIKE :term",
			"value" => [
				":term" => "%{$query}%"
			]
		];

		return $this;
	}

	/**
	 *	@return Collection collection des suggestions
	 */
	public function getAllSuggestions() {
		$requete = connexionBDD()->prepare("
			SELECT id, pseudo, date, mail, message
			FROM messages
			ORDER BY date DESC, id DESC
		");

		$requete->execute();

		return $this->fetchAll($requete, \Blog\Suggestion::class);
	}

	/**
	 * return all articles for a chosen month of a chose year
	 * @param  integer $year  the chosen year
	 * @param  integer $month the chosen month
	 * @return \Codisart\Collection        The list of the articles
	 */
	static public function getArticlesByMonth($year, $month) {
		$formattedMonth = "$year/$month";

		$requete = connexionBDD()->prepare("
			SELECT id, titre, contenu, date
			FROM news
			WHERE DATE_FORMAT(date, '%Y/%c') = :mois
			ORDER BY id DESC
		");

		if (false === $requete->execute(['mois' => $formattedMonth])) {
			return false;
		}

		if (false === ($donnees = $requete->fetch())) {
			return false;
		}

		$articles = new \Codisart\Collection();
		do {
			$articles[] = new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
		} while ($donnees = $requete->fetch());

		return $articles;
	}

	protected function buildWhereConditions() {
		if (!empty($this->_where['condition'])) {
			return $this->_where;
		}

		$this->_where = [
			'condition' => "",
			'values' => []
		];

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
