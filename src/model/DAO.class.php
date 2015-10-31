<?php
require_once('RSS.class.php');
require_once('Nouvelle.class.php');

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

    function constructRSS($id) {
        // 1: construit RSS
        // 2: construit ses nouvelles
        // 3: return
        try {
            $rss = $this->db->query("SELECT * FROM RSS WHERE id = $id")->fetchAll(PDO::FETCH_CLASS, 'RSS');
            if (!empty($rss)) {
                $rss = $rss[0];
                $rss->setNouvelles($this->getNouvellesFromId($id));
                return $rss;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }
    }

    function constructAllRSS() {
        $v_rss = array();

        for ($i = 1;;$i++) {
            $rss = $this->constructRSS($i);
            if ($rss == null) {
                break;
            }
            $v_rss[] = $rss;
        }

        return $v_rss;
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
        $q = "UPDATE RSS SET titre = $titre, date = '{$rss->getDate()}' WHERE url = '{$rss->getUrl()}'";
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
            $r = $this->db->query($query)->fetch();
            if ($r != NULL && !empty($r)) {
                $rss = new RSS($r['url']);
                $rss->update();
                return $rss;
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }

    function cleanRSS($id) {
        // clean images
        foreach (glob("../model/images/" . $id . "_*.jpg") as $image) {
            unlink($image);
        }

        // clean les nouvelles
        $query = "DELETE FROM Nouvelle WHERE RSS_id = $id";
        try {
            $r = $this->db->exec($query);
            if ($r < 1) {
                return false;
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }

        return true;
    }

    function cleanAllRSS() {
        // clean images
        foreach (glob("../model/images/*.jpg") as $image) {
            unlink($image);
        }

        // clean les nouvelles
        $query = "DELETE FROM Nouvelle";
        $queryResetID = "DELETE FROM sqlite_sequence WHERE name = 'nouvelle'";
        try {
            $r = $this->db->exec($query);
            $this->db->exec($queryResetID);
            if ($r < 1) {
                return false;
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }

        return true;
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur Nouvelle
    //////////////////////////////////////////////////////////

    // Acces à une nouvelle à partir de son titre et l'ID du flux
    function readNouvellefromTitre($titre, $RSS_id) {
        $safeTitre = $this->db->quote($titre);
        
        $query = "SELECT * FROM Nouvelle WHERE titre = $safeTitre AND RSS_id = $RSS_id";
        
        try {
            $result = $this->db->query($query)->fetch();
            if ($result != NULL && !empty($result))
                return $result[0];
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }
    
    // Renvoie toutes les nouvelles d'un flux RSS
    function getNouvellesFromRSS($url) {
        $safeUrl = $this->db->quote($url);
        $query = "SELECT N.titre, N.url, N.date, N.description, N.image FROM Nouvelle N, RSS R WHERE R.url = $safeUrl AND R.id = N.RSS_id ORDER BY N.id DESC";
        
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
        if (!($imageUrl == 'default')) {
            $nouvelleUrl = $this->getIdNouvelle($n);
            $imageUrlLocal = '../model/images/' . $RSS_id . '_' . $nouvelleUrl . '.jpg';

            if (!file_exists($imageUrlLocal)) {
                file_put_contents($imageUrlLocal, file_get_contents($imageUrl));
            }
        } else {
            $imageUrlLocal = '../model/images/default.jpg';
            $imageUrl = 'http://image-link-archive.meteor.com/images/placeholder-640x480.png'; // URL d'une image à mettre en default

            if (!file_exists($imageUrlLocal)) {
                file_put_contents($imageUrlLocal, file_get_contents($imageUrl));
            }
        }
    }
    
    function getIdNouvelle(Nouvelle $n) {
        $safeUrl = $this->db->quote($n->getUrl());
        $queryRSS_id = "SELECT id FROM Nouvelle WHERE url = $safeUrl";
        
        try {
            $result = $this->db->query($queryRSS_id)->fetch();
            return $result['id'];
        } catch (Exception $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
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
            $r = $this->db->query($query)->fetchAll(PDO::FETCH_CLASS, 'Nouvelle');
            if ($r != NULL && !empty($r)) {
                return $r[0];
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }

    function getNouvellesFromId($id) {
        $query = "SELECT * FROM Nouvelle WHERE RSS_id = $id ORDER BY id DESC";
        try {
            $r = $this->db->query($query)->fetchAll(PDO::FETCH_CLASS, 'Nouvelle');
            if ($r != NULL && !empty($r)) {
                return $r;
            }
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }
    }

    // Renvoie toutes les images des nouvelles d'un flux RSS
    function getNouvellesImgFromId($id) {
        $imgs = $this->getNouvellesFromId($id);
        $imgsLoc = array();

        foreach ($imgs as $img) {
            $imgsLoc[$img->getId()] = $img->getImageLocale();
        }

        return $imgsLoc;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // USERS
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function tryLogin($user, $password) {
        $user = $this->db->quote($user);
        $password = $this->db->quote($password);

        $query = "SELECT * FROM utilisateur WHERE login = $user AND mp = $password";

        try {
            $result = $this->db->query($query)->fetch();
            if ($result != NULL && !empty($result)) {
                return true;
            }
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }

        return false;
    }

    // Créer un nouvel utilisateur avec le login $user et le mot de passe $password
    // Return true si l'utilisateur a été crée, false sinon
    function creerUtilisateur($user, $password) {
        $user = $this->db->quote($user);
        $password = $this->db->quote($password);

        $query = "INSERT INTO utilisateur VALUES ($user, $password)";

        try {
            $result = $this->db->exec($query);
            if ($result > 0) {
                return true;
            }
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }

        return false;
    }


}
