<?php
	class Blog {

		private $page;
		private $nombreArticlesPage;
		private $articles;		

		/**		 
		 * constructeur de la classe
		 */	
		public function __construct() {
		
		}


		/**
		 *	@return le numéro de la page
		 */		
		public function getPage() {
			return $this->page;
		}
		
		
		/**
		 *	@return le nombre d'articles de la page
		 */		
		public function getNombreArticlesPage() {
			return $this->nombreArticlesPage;
		}
		
		
		/**
		 *	@return une Collection contenant les articles
		 */		
		public function getArticles($page, $nombreArticlesPage = 10) {			 
			$this->page = $page;
			$this->nombreArticlesPage = $nombreArticlesPage;
			
			$this->articles = new Collection();
			
			$limit = ($this->page -1)*$this->nombreArticlesPage;
						
			$connexionBDD = connexionBDD();
			$requete = $connexionBDD->query("SELECT id, titre, contenu, date
												FROM news 
												ORDER BY date DESC, id DESC 
												LIMIT $limit, $nombreArticlesPage");
			
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
				$this->nombreArticlesPage = 0;
			}
			else {
				do {
					$this->articles[] = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);							
				}
				while ($donnees = $requete->fetch());
			}
															
			$connexionBDD = NULL;				
			
			return $this->articles;
		}
		

		/**
		 *	@return une collection contenant tous les articles
		 */		
		public static function getAllArticles() {			 			
			$articles = new Collection();
						
			$connexionBDD = connexionBDD();
			$requete = $connexionBDD->query("SELECT id, titre, contenu, date
												FROM news 
												ORDER BY date DESC, id DESC");
			
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
			}
			else {
				do {
					$articles[] = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);							
				}
				while ($donnees = $requete->fetch());
			}
															
			$connexionBDD = NULL;				
			
			return $articles;
		}
		

		/**
		 *	@return un tableau contenant tous les articles
		 */		
		public static function getNombreAllArticles() {
			$connexionBDD = connexionBDD();
			 			
			$articles = new Collection();
						
			$requete = $connexionBDD->query("SELECT COUNT(id)
													FROM news
													");
			
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
			}
			else {
				do {
					$articles[] = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);							
				}
				while ($donnees = $requete->fetch());
			}
															
			$connexionBDD = NULL;				
			
			return $articles;
		}
				
		
		/**
		 * 	@param int $index numero  de l'article dans le tableau contenu
		 *	@return Article l'article 
		 */	
		public function getArticle($index) {
			return $this->articles[$index];
		}
		
		
		/**
		 * 	@param int $index numero  de l'article dans le tableau contenu
		 *	@return Article $article l'article 
		 */	
		public static function getRandomArticle() {					
			$connexionBDD = connexionBDD();

			$requete = $connexionBDD->query("SELECT id, titre, contenu, date
															FROM news 
															ORDER BY rand() LIMIT 1");
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'article sélectionné</h5>';
			}
			else {
				$article = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);
			}
															
			$connexionBDD = NULL;
			
			return $article;
		}
		
		
		
		
		
		public static function getArchives() {
			$connexionBDD = connexionBDD();
			
			$requete = $connexionBDD->query("SELECT DISTINCT DATE_FORMAT(date, '%c') as mois, DATE_FORMAT(date, '%Y') as year 
																	FROM news 
																	ORDER BY date DESC");
			
			$listeMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
			
			$archives = new Collection();
			
			while ($donnees = $requete->fetch()) {								
				$mois = $listeMois[$donnees['mois'] - 1].' '.$donnees['year'];
				$lien = "archives.php?a={$donnees['year']}&m={$donnees['mois']}";
				$archives[$mois] = $lien;						
			}		
				
			return $archives;
		}	
		
		
		public function filtreRecherche($query) {
			$connexionBDD = connexionBDD();			
			
			$page = $this->page;
			$nombreArticlesPage = $this->nombreArticlesPage;
			
			$limit = ($page -1)*$nombreArticlesPage;	
								
			$requete = $connexionBDD->query("SELECT id, titre, contenu, date
																FROM news 
																WHERE contenu LIKE '%$query%'
																	OR titre LIKE '%$query%'
																ORDER BY date DESC, id DESC 
																LIMIT $limit, $nombreArticlesPage");
						
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas d\'articles sélectionnés</h5>';
				$this->nombreArticlesPage = 0;
			}
			else {
				do {
					$this->articles[] = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);							
				}
				while ($donnees = $requete->fetch());
			}
									
			$connexionBDD = NULL;		
			
			return $this;
		}

		/**
		 *	@return Collection $messages collection des messages
		 */
		public function getAllSuggestions() {
			$messages = new Collection();		
						
			$connexionBDD = connexionBDD();				
			$requete = $connexionBDD->query("SELECT id, pseudo, date, mail, message
												FROM messages
												ORDER BY date DESC, id DESC");
			
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas de messages sélectionnés</h5>';				
			}
			else {
				do {
					$messages[$donnees['id']] = new Commentaire($donnees['id'],$donnees['pseudo'], $donnees['date'], $donnees['message']);
				}
				while ($donnees = $requete->fetch());
			}
													
			return $messages;
		}
		
		
		/**
		 * 	@param int $limite nombres de suggestions à récupérer
		 * 	@param int $origin première suggestion à récupérer
		 *	@return Collection $suggestions collection des suggestions
		 */
		static public function getSuggestions($limite, $origin = 0) {
			$suggestions = new Collection();
			// $this->limite = $limite;
			// $this->origin = $origin;

			$connexionBDD = connexionBDD();
			$requete = $connexionBDD->query("SELECT id, pseudo, date, mail, message
												FROM messages
												ORDER BY date DESC, id DESC
												LIMIT $origin, $limite");
			
			if (false === ($donnees = $requete->fetch())) {
				echo '<h5 class="error">Il n\'y a pas de messages sélectionnés</h5>';				
			}
			else {
				do {
					$suggestions[$donnees['id']] = new Suggestion($donnees['id'],$donnees['pseudo'], $donnees['mail'], $donnees['date'], $donnees['message']);
				}
				while ($donnees = $requete->fetch());
			}
													
			return $suggestions;
		}
		
	}