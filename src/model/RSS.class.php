<?php
require_once('Nouvelle.class.php');
require_once('DAO.class.php');

class RSS {
    private $titre; // Titre du flux
    private $url;   // Chemin URL pour télécharger un nouvel état du flux
    private $date;  // Date du dernier téléchargement du flux
    private $nouvelles; // Liste des nouvelles du flux

    // Contructeur
    function __construct($url = "") {
        if ($url != "") $this->url = $url;
    }

    function setNouvelles($nouvelles) { $this->nouvelles = $nouvelles; }
    function setDate($date) { $this->date = $date; }

    // Fonctions getter
    function getTitre()     {
        if (!isset($this->titre) || $this->titre == "") {
            return 'Url: ' . $this->url;
        } else {
            return $this->titre;
        }
    }
    function getUrl()       { return $this->url; }
    function getDate()      { if (isset($this->date) && $this->date != '') return $this->date; else return 'Jamais'; }
    function getNouvelles() { return $this->nouvelles; }
    function getId()        { return $this->id; }

    function deleteNouvelle($k) { unset($this->nouvelles[$k]); }
    
    // Met à jour le flux
    function update() {
        global $dao;
        
        // On corrige les erreurs de typo dans les RSS (merci les developpeurs de RSS...)
        $content = file_get_contents($this->url);
        if (!isset($content)) {
            throw new Exception('Document invalide: impossible de récupérer le fichier');
        } else if (substr($content, 0, 5) === "<?xml") {
            $content = str_replace('&', '&amp;', $content);
        } else {
            throw new Exception('Document invalide: non xml');
        }

        // Cree un objet pour accueillir le contenu du RSS : un document XML
        $doc = new DOMDocument;

        // Parse le fichier XML
        if (!$doc->loadXML($content)) {
            throw new Exception('Document invalide: parse fail');
        }

        // Recupère les éléments principaux du flux
        $nodeTitle =    $doc->getElementsByTagName('title');
        $nodePubDate =  $doc->getElementsByTagName('pubDate');
        
        // On les met à jour
        $this->titre =  $nodeTitle->item(0)->textContent;
        $this->date =   $nodePubDate->item(0)->textContent;
        
        // Mise à jour du RSS dans la BDD (et récupération de l'id assigné au flux)
        $this->id = $dao->updateRSS($this)['id'];

        // Fetch et reverse les items trouvés
        $items = array();
        foreach ($doc->getElementsByTagName('item') as $item) {
            $items[] = $item;
        }
        $items = array_reverse($items);

        // Parcours les items, crée une nouvelle, la met à jour, et tente de l'insérer dans la BDD
        foreach ($items as $node) {
            $nouvelle = new Nouvelle();

            // Met à jour la nouvelle avec l'information téléchargée
            $nouvelle->update($node);

            // Tente de la créer dans la BDD, ne sera pas fait si elle existe déjà
            $dao->createNouvelle($nouvelle, $this->id);
        }

        // On récupère les nouvelles depuis la bdd
        $this->nouvelles = $dao->getNouvellesFromRSS($this->url);
    }
}

