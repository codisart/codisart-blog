<?php
	
	class Article
	{
		private $titre;
		private $date;
		private $contenu;
		private $id;		
		private $commentaires;
		
		
		public function __construct($id,$titre = '', $date = 0, $contenu = '')
		{		
			$this->id = $id;
			
			if($titre == '' && $date == 0 && $contenu == '')
			{				
				$connexionBDD = connexionBDD();
				
				$requete = $connexionBDD->query("SELECT id, titre, contenu, date
																	FROM news 
																	WHERE id='$id'
																	ORDER BY id DESC 
																	LIMIT 0,1");			
			
				$donnees = $requete->fetch();
				
				$titre = $donnees['titre'];
				$date = $donnees['date'];
				$contenu = $donnees['contenu'];
				
				$connexionBDD = NULL;				
			}
			
			$this->titre = $titre;
			$this->date = $date;
			$this->contenu = $contenu;
		}
		
		
		// Methode Magique
		
		/**
		 *  Permet la lecture seule des membres
		 */		
		public function __get ($nom)
        {
            if(isset($this->$nom))
			{
				return $this->$nom;
			}
			else 
			{
				return "<p class=\"error\">Impossible d'accéder à l'attribut <strong>$nom</strong>, désolé !</p>";
			}
        }
		
		
		
		
		// A mettre dnas une librairie
		public function formatDateFrench()
		{			
			$listeMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
			
			$this->date = date("j ",strtotime($this->date)).$listeMois[date("n",strtotime($this->date)) -1].date(" Y, H:i:s",strtotime($this->date));
			
			return $this;
		}

		
		public function getContenu()
		{		
			return nl2br($this->contenu);
		}			
		
		
		public function getContenuLimite($nbreMots = 20) {
			
			$contenu = $this->get_Contenu();
			$contenu_limite = '';
			
			if(substr_count($contenu, ' ') - $nbreMots > 10)
			{
				$contenu = explode(' ',$contenu);
				for( $i = 0  ; $i < 20 ; $i++)
				{
					$contenu_limite .= $contenu[$i].' ';
				}
				
				$contenu_limite .= '...<br/><em><a href="article.php?idArticle='.$this->get_ID().'">Lire la suite -></a></em>';
				return $contenu_limite;
			}
			else 
			{
				return $contenu;
			}							
		}
				
		
		public function getAllCommentaires() {
			$connexionBDD = connexionBDD();
			
			$requete = $connexionBDD->prepare("SELECT id, pseudo, date, commentaire
																		FROM commentaires 
																		WHERE id_news = :id
																		ORDER BY date DESC");
			
			$this->commentaires = new Collection();	

			if(false === $requete->execute(array('id' => $this->id))) {	
				$connexionBDD = NULL;
				return $this->commentaires;
			}			
			
			if (false === ($donnees = $requete->fetch())) {
				$connexionBDD = NULL;
				return $this->commentaires;
			}
			else {
				do {
					$this->commentaires[] = new Commentaire($donnees['id'],$donnees['pseudo'], $donnees['date'], $donnees['commentaire']);							
				}
				while ($donnees = $requete->fetch());
			}
						
			$connexionBDD = NULL;			
			return $this->commentaires;
		}
		
						
		//Setters 
		public function setContenu($newContenu) {		
			if($newContenu === $this->contenu) {			
				return $this;
			}
			
			$id = $this->id;			
			$this->contenu = $newContenu;		
			
			$connexionBDD = connexionBDD();
			
			$requete = $connexionBDD->prepare("UPDATE news SET contenu = ? WHERE id ='$id'");
			$requete->execute(array($newContenu));
			
			return $this;
		}
		
		
		public function setTitre($newTitre) {		
			if($newTitre === $this->titre) {			
				return $this;
			}
			
			$id = $this->id;
			$this->titre = $newTitre;
			
			$connexionBDD = connexionBDD();
			
			$requete = $connexionBDD->prepare("UPDATE news SET titre = ? WHERE id ='$id'");
			$requete->execute(array($newTitre));
			
			return $this;			
		}
		
		
		// Fonctions / Méthodes		
		public function supprimer() {
			$id = $this->id;					
				
			if(!connexionBDD()->query("DELETE FROM news WHERE id ='$id'")) {
				echo 'Cet article a déjà été supprimé ou n\'existe pas !';
			}			
			
			return true;
		}	
		
		
		public function ajouter($titre, $contenu) {
			$connexionBDD = connexionBDD();
			
			$requete = $connexionBDD->prepare("INSERT INTO news (titre, contenu) VALUES ( ?, ?)");
			
			if(!$requete->execute(array($titre, $contenu))) {				
				echo 'Cet article a déjà été supprimé ou n\'existe pas !';
			}			
				
			$connexionBDD = NULL;
		}	
		
		
		static public function getArticlesMois($year, $month) {
			$mois = "$year/$month";
			
			$requete = connexionBDD()->prepare("SELECT id, titre, contenu, date
													FROM news 
													WHERE DATE_FORMAT(date, '%Y/%c') = :mois
													ORDER BY id DESC");
			
			if(false === $requete->execute(array('mois' => $mois))) {				
				$connexionBDD = NULL;
				return false;
			}

			if (false === ($donnees = $requete->fetch())) {
				$connexionBDD = NULL;
				return false;
			}
			else {
				do {
					$articles[] = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);
				}
				while ($donnees = $requete->fetch());
			}

			// while ($donnees = $requete->fetch())
			// {
			// 	$articles[] = new Article($donnees['id'],$donnees['titre'], $donnees['date'], $donnees['contenu']);							
			// }
			
			return $articles;			
		}	
	}