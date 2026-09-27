<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.hotel.inc.php";
include_once "$racine/modele/bd.photo.inc.php";

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage
$listeHotel = getHotels();

// appel du script de vue qui permet de gerer l'affichage des donnees
$titre = "Liste des hôtels répertoriés";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueListeHotel.php";
include "$racine/vue/pied.html.php";
?>
