<?php
require_once('RSS.class.php');
require_once('Nouvelle.class.php');
require_once('Abonnement.class.php');
require_once('Utilisateur.class.php');

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

        if (!is_dir('../model/images')) {
            mkdir('../model/images', 0777, true);
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
        try {
            $v_rss = $this->db->query("SELECT * FROM RSS")->fetchAll(PDO::FETCH_CLASS, 'RSS');
            if (!empty($v_rss)) {
		$v_rssn = array();
                foreach ($v_rss as $k => $rss) {
                    $rss->setNouvelles($this->getNouvellesFromId($rss->getId()));
                    // On indice correctement le tableau ($v_rss['id'])
                    $v_rssn[$rss->getId()] = $rss;
                }

                return $v_rssn;
            }
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }

        return array();
    }

    //////////////////////////////////////////////////////////
    // Methodes CRUD sur RSS
    //////////////////////////////////////////////////////////

    // Crée un nouveau flux à partir d'une URL
    // Si le flux existe déjà on ne le crée pas
    // return false si on n'a rien fait, true sinon
    function createRSS($url) {
        try {
            $safeUrl = $this->db->quote($url);
            $object = $this->readRSSfromURL($url);
            if ($object != null) {
                return false;
            }

            $q = "INSERT INTO RSS (url) VALUES ($safeUrl)";
            $r = $this->db->exec($q);

            if ($r < 1) {
                return false;
            }

            return true;
        } catch (PDOException $e) {
            die("PDO Error :" . $e->getMessage());
        }
    }

    // Acces à un objet RSS à partir de son URL
    // return false si il n'existe pas, le rss sinon
    function readRSSfromURL($url) {
        $safeUrl = $this->db->quote($url);
        
        $query = "SELECT * FROM RSS WHERE url = $safeUrl";
        
        try {
            $result = $this->db->query($query)->fetch();
            
            if ($result != false) {
                $rss = new RSS($result['url']);
            } else {
                //$rss = $this->createRSS($url);
                return false;
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
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
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
            /*if ($r < 1) {
                return false;
            }*/
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
            /*if ($r < 1) {
                return false;
            }*/
        } catch (PDOException $ex) {
            die("PDO Error :" . $ex->getMessage());
        }

        return true;
    }

    function deleteRSS($id) {
        if ($this->cleanRSS($id)) {
            $query = "DELETE FROM RSS WHERE id = $id";

            try {
                $r = $this->db->exec($query);

                if ($r < 1) {
                    return false;
                } else {
                    return true;
                }
            } catch (PDOException $ex) {
                die('PDOException: ' . $ex->getMessage());
            }
        } else {
            return false;
        }
    }

    function deleteAllRSS() {
        if ($this->cleanAllRSS()) {
            $query = "DELETE FROM RSS";
            $queryResetID = "DELETE FROM sqlite_sequence WHERE name = 'rss'";

            try {
                $r = $this->db->exec($query);
                $this->db->exec($queryResetID);

                if ($r < 1) {
                    return false;
                } else {
                    return true;
                }
            } catch (PDOException $ex) {
                die("PDO Error :" . $ex->getMessage());
            }
        } else {
            return false;
        }
    }

    function getAllRSSof($user) {
        $results = $this->getAllAbonnements($user);
        if (isset($results) && !empty($results)) {
            $v_rss = array();
            foreach ($results as $result) {
                $v_rss[] = $this->constructRSS($result->getRSSid());
            }
            return $v_rss;
        }
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
    function getNouvellesTitreImg($id) {
        $imgs = $this->getNouvellesFromId($id);
        $imgsLoc = array();

        foreach ($imgs as $img) {
            $imgsLoc[$img->getId()] = array(
                                                'url' => $img->getImageLocale(),
                                                'titre' => $img->getTitre()
                                            );
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

    function isAdmin($user) {
        $user = $this->db->quote($user);

        $query = "SELECT * FROM utilisateur WHERE login = $user";

        try {
            $result = $this->db->query($query)->fetch();
            if ($result != NULL && !empty($result) && $result['isAdmin'] == "true") {
                return true;
            }
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }

        return false;
    }

    function getAllUsers() {
        $query = "SELECT * FROM utilisateur";

        try {
            $results = $this->db->query($query)->fetchAll(PDO::FETCH_CLASS, 'Utilisateur');

            if (isset($results) && !empty($results)) {
                $users = array();
                foreach ($results as $result) {
                    $users[$result->getLogin()] = $result;
                }
                return $users;
            }
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }
    }

    // Créer un nouvel utilisateur avec le login $user et le mot de passe $password
    // Return true si l'utilisateur a été crée, false sinon
    function creerUtilisateur($user, $password) {
        $user = $this->db->quote($user);
        $password = $this->db->quote($password);

        $query = "INSERT INTO utilisateur VALUES ($user, $password, 'false')";

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

    function supprimerUtilisateur($user) {
        $user = $this->db->quote($user);

        $query = "DELETE FROM utilisateur WHERE login = $user";

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

    function promouvoirAdmin($user) {
        $user = $this->db->quote($user);

        $query = "UPDATE utilisateur SET isAdmin = 'true' WHERE login = $user";

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

    function supprimerAdmin($user) {
        $user = $this->db->quote($user);

        $query = "UPDATE utilisateur SET isAdmin = 'false' WHERE login = $user";

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Abonnements
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function getAllAbonnements($user) {
        $user = $this->db->quote($user);
        $query = "SELECT * FROM Abonnement WHERE utilisateur_login = $user";

        try {
            $results = $this->db->query($query)->fetchAll(PDO::FETCH_CLASS, 'Abonnement');

            return $results;
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex);
        }
    }

    function addAbonnement($user, $RSS_id, $nom = "Pas de nom", $categorie = "Defaut") {
        $user = $this->db->quote($user);
        $nom = $this->db->quote($nom);
        $categorie = $this->db->quote($categorie);

        $query = "INSERT INTO abonnement VALUES ($user, $RSS_id, $nom, $categorie)";

        if ($this->getRSSFromId($RSS_id) != NULL) {
            try {
                $result = $this->db->exec($query);

                if ($result < 1) {
                    return false;
                }

                return true;
            } catch (PDOException $ex) {
                die('PDOException: ' . $ex->getMessage());
            }
        } else {
            return false;
        }
    }

    function removeAbonnement($user, $RSS_id) {
        $user = $this->db->quote($user);

        $query = "DELETE FROM abonnement WHERE utilisateur_login = $user AND RSS_id = $RSS_id";

        try {
            $result = $this->db->exec($query);

            if ($result < 1) {
                return false;
            }

            return true;
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }
    }

    function changerNomAbonnement($user, $RSS_id, $nom) {
        $user = $this->db->quote($user);
        $nom = $this->db->quote($nom);

        $query = "UPDATE abonnement SET nom = $nom WHERE utilisateur_login = $user AND RSS_id = $RSS_id";

        try {
            $result = $this->db->exec($query);

            if ($result < 1) {
                return false;
            }

            return true;
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }
    }

    function changerCategorieAbonnement($user, $RSS_id, $categorie) {
        $user = $this->db->quote($user);
        $categorie = $this->db->quote($categorie);

        $query = "UPDATE abonnement SET categorie = $categorie WHERE utilisateur_login = $user AND RSS_id = $RSS_id";

        try {
            $result = $this->db->exec($query);

            if ($result < 1) {
                return false;
            }

            return true;
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }
    }

    function removeAllSubscriptions($user) {
        $user = $this->db->quote($user);

        $query = "DELETE FROM abonnement WHERE utilisateur_login = $user";

        try {
            $result = $this->db->exec($query);

            if ($result < 1) {
                return false;
            }

            return true;
        } catch (PDOException $ex) {
            die('PDOException: ' . $ex->getMessage());
        }
    }

}
