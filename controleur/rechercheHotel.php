<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.hotel.inc.php";
include_once "$racine/modele/bd.service.inc.php";
include_once "$racine/modele/bd.photo.inc.php";
include_once "$racine/modele/authentification.inc.php";

// critere de recherche par defaut
$critere = "nom";
if (isset($_GET["critere"])) {
    $critere = $_GET["critere"];
}

// recuperation des données GET/POST
$nomHotel     = isset($_POST["nomHotel"])     ? $_POST["nomHotel"]     : "";
$adresseHotel = isset($_POST["adresseHotel"]) ? $_POST["adresseHotel"] : "";
$codePostal   = isset($_POST["codePostal"])   ? $_POST["codePostal"]   : "";
$villeHotel   = isset($_POST["villeHotel"])   ? $_POST["villeHotel"]   : "";
$idsServices  = (isset($_POST["services"]) && is_array($_POST["services"]))
                ? array_map('intval', $_POST["services"])
                : array();

// tous les services pour afficher les cases à cocher
$tousLesServices = getServices();

if ($critere == "services" && !empty($idsServices) && isLoggedOn()) {
    $mailC = getMailCLoggedOn();
    sauvegarderServicesCherches($mailC, $idsServices);
}

// recherche
switch ($critere) {
    case 'nom':
        $listeHotels = getHotelsByNomHotel($nomHotel);
        break;
    case 'adresse':
        $listeHotels = getHotelsByAdresse($adresseHotel, $codePostal, $villeHotel);
        break;
    case 'services':
        $listeHotels = getHotelsByServices($idsServices);
        break;
    default:
        $listeHotels = array();
}

$titre = "Recherche d'un hôtel";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueRechercheHotel.php";
if (!empty($_POST)) {
    include "$racine/vue/vueResultRecherche.php";
}
include "$racine/vue/pied.html.php";
?>
