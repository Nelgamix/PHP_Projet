<?php

$dao = new DAO();

class DAO {
    private $db; // L'objet de la base de donnée

    // Ouverture de la base de donnée
    function __construct() {
        $dsn = 'sqlite:../model/rss.db'; // Data source name
        try {
            $this->db = new PDO($dsn);
        } catch (PDOException $e) {
            exit("Erreur ouverture BD : " . $e->getMessage());
        }
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur RSS
    //////////////////////////////////////////////////////////

    // Crée un nouveau flux à partir d'une URL
    // Si le flux existe déjà on ne le crée pas
    function createRSS($url) {
        try {
            $safeUrl = $this->db->quote($url);
            $q = "INSERT INTO RSS (url) VALUES ($safeUrl)";
            $r = $this->db->exec($q);
            if ($r == 0) {
                die("createRSS error: no rss inserted\n");
            }

            return $this->readRSSfromURL($url);
        } catch (PDOException $e) {
            die("PDO Error :" . $e->getMessage());
        }
    }

    // Acces à un objet RSS à partir de son URL
    function readRSSfromURL($url) {
        $safeUrl = $this->db->quote($url);
        
        $query = "SELECT * FROM RSS WHERE url = $safeUrl";
        
        try {
            $result = $this->db->query($query)->fetch();
            
            if ($result != false) {
                $rss = new RSS($result['url']);
            } else {
                $rss = $this->createRSS($url);
            }
        } catch (Exception $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
        
        return $rss;
    }

    // Met à jour un flux
    function updateRSS(RSS $rss) {
        // Met à jour uniquement le titre et la date
        $titre = $this->db->quote($rss->getTitre());
        $q = "UPDATE RSS SET titre = $titre, date='{$rss->getDate()}' WHERE url='{$rss->getUrl()}'";
        $RSS_id = "SELECT id FROM RSS WHERE url = '{$rss->getUrl()}'";
        try {
            $r = $this->db->exec($q);
            $RSS_ids = $this->db->query($RSS_id)->fetch();
            if ($r == 0) {
                die("updateRSS error: no rss updated\n");
            }
        } catch (PDOException $e) {
            die("PDO Error :" . $e->getMessage());
        }
        
        return $RSS_ids;
    }

    function getRSSFromId($id) {
        $query = "SELECT * FROM RSS WHERE id = $id";
        try {
            $r = $this->db->query($query);
            if ($r != NULL) {
                $object = $r->fetch();
                $rss = new RSS($object['url']);
                $rss->update();

                return $rss;
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur Nouvelle
    //////////////////////////////////////////////////////////

    // Acces à une nouvelle à partir de son titre et l'ID du flux
    function readNouvellefromTitre($titre, $RSS_id) {
        $safeTitre = $this->db->quote($titre);
        $safeId = $this->db->quote($RSS_id);
        
        $query = "SELECT * FROM Nouvelle WHERE titre = $safeTitre AND RSS_id = $safeId";
        
        try {
            $result = $this->db->query($query)->fetch();
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
        
        return $result;
    }
    
    // Renvoie toutes les nouvelles d'un flux RSS
    function getNouvellesFromRSS($url) {
        $safeUrl = $this->db->quote($url);
        $query = "SELECT N.titre, N.url, N.date, N.description, N.image FROM Nouvelle N, RSS R WHERE R.url = $safeUrl AND R.id = N.RSS_id";
        
        try {
            $results = $this->db->query($query)->fetchAll(PDO::FETCH_CLASS, "Nouvelle");
            
            return $results;
        } catch (Exception $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }

    // Crée une nouvelle dans la base à partir d'un objet nouvelle
    // et de l'id du flux auquelle elle appartient
    function createNouvelle(Nouvelle $n, $RSS_id) {
        if ($this->readNouvellefromTitre($n->getTitre(), $RSS_id) == NULL) {
            $safeId = $this->db->quote($RSS_id);
            $safePubDate = $this->db->quote($n->getDate());
            $safeTitre = $this->db->quote($n->getTitre());
            $safeDescription = $this->db->quote($n->getDescription());
            $safeLink = $this->db->quote($n->getUrl());
            $safeImage = $this->db->quote($n->getImage());

            $query = "INSERT INTO Nouvelle (date, titre, description, url, image, RSS_id) " .
                     "VALUES ($safePubDate, $safeTitre, $safeDescription, $safeLink, $safeImage, $safeId)";
            
            try {
                $result = $this->db->exec($query);
                if ($result == 0) {
                    die ("Error: nouvelle not inserted\n");
                }
            } catch (Exception $ex) {
                die("PDO Error :" . $ex->getMessage());
            }
        }
        
        $this->updateImageNouvelle($n, $RSS_id);
    }

    // Met à jour le champ image de la nouvelle dans la base
    function updateImageNouvelle(Nouvelle $n, $RSS_id) {
        $imageUrl = $n->getImage();
        $nouvelleUrl = $this->getIdNouvelle($n);
        $imageUrlLocal = "images/" . $RSS_id . "_" . $nouvelleUrl . ".jpg";
        //echo('RSS ID: ' . $RSS_id . ' and URL: ' . $nouvelleUrl . "\n");
        
        if (!file_exists($imageUrlLocal)) {
            file_put_contents($imageUrlLocal, file_get_contents($imageUrl));
            //echo("Created!\n");
        }
    }
    
    function getIdNouvelle(Nouvelle $n) {
        $safeUrl = $this->db->quote($n->getUrl());
        $queryRSS_id = "SELECT id FROM Nouvelle WHERE url = $safeUrl";
        
        try {
            $result = $this->db->query($queryRSS_id)->fetch();
        } catch (Exception $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
        
        return $result['id'];
    }
    
    function getRSSIdFromNouvelle(Nouvelle $n) {
        $safeUrl = $this->db->quote($n->getUrl());
        $queryRSS_id = "SELECT RSS_id FROM Nouvelle WHERE url = $safeUrl";
        
        try {
            $result = $this->db->query($queryRSS_id)->fetch();
        } catch (Exception $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
        
        return $result['RSS_id'];
    }

    function getNouvelleFromId($id) {
        $query = "SELECT * FROM Nouvelle WHERE id = $id";
        try {
            $r = $this->db->query($query);
            if ($r != NULL) {
                $object = $r->fetchAll(PDO::FETCH_CLASS, 'Nouvelle')[0];
                d($object);
                return $object;
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }
}
