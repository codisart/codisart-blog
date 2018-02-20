<?php

    /**
     * @property string $_table
     */
    class Commentaire extends Item {
        protected $_table = 'commentaires';

        protected $id;
        protected $pseudo;
        protected $date;
        protected $contenu;

        public function __construct($id) {
            $this->id = $id;
        }

        protected function hydrate() {
            $requete = connexionBDD()->query("
				SELECT id, pseudo, date, commentaire
				FROM commentaires
				WHERE id='{$this->id}'
				ORDER BY id DESC
				LIMIT 0,1
			");

            $donnees = $requete->fetch();

            $this->pseudo = $donnees['pseudo'];
            $this->date = $donnees['date'];
            $this->contenu = $donnees['contenu'];
        }


        public static function ajouter($idArticle, $pseudo, $mail, $comment) {
            if (!empty($idArticle) && !empty($pseudo) && !empty($mail) && !empty($comment)) {
                return self::save(
                    array(
                        'id_news'	=> $idArticle,
                        'pseudo' 	=> $pseudo,
                        'mail' 		=> $mail,
                        'commentaire' 	=> $comment,
                    ),
                    'commentaires'
                );
            }
        }

        /**
         * Renvoie la date de l'objet avec un retour à la ligne entre la date et l'heure.
         * @return string
         */
        public function getDateOn2Rows() {
            return str_replace(' ', "<br/>", $this->date);
        }

        public function getArticle() {
            $requete = connexionBDD()->query("
				SELECT news.id, news.titre, news.contenu, news.date
				FROM news
					INNER JOIN commentaires ON news.id = commentaires.id_news
				WHERE commentaires.id='{$this->id}'
				ORDER BY id DESC
				LIMIT 0,1
			");

            if (false === ($donnees = $requete->fetch())) {
                return null;
            }

            return new Article($donnees['id'], $donnees['titre'], $donnees['date'], $donnees['contenu']);
        }
        public function setPseudo($pseudo) {
            $this->pseudo = $pseudo;
        }


        public function setDate($date) {
            $this->date = $date;
        }


        public function setCommentaire($commentaire) {
            $this->contenu = $commentaire;
        }
    }
