<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.service.inc.php";
include_once "$racine/modele/bd.hotel.inc.php";
include_once "$racine/modele/bd.reservation.inc.php";

$menuBurger = array();
$menuBurger[] = Array("url" => "./?action=profil", "label" => "Consulter mon profil");

if (isLoggedOn()) {
    $mailC = getMailCLoggedOn();
    $util  = getClientByMailC($mailC);

    $mesHotelsAimes   = getHotelsAimesByMailC($mailC);
    $mesServicesAimes = getServicesPreferesByMailC($mailC);
    $mesReservations  = getReservationsByMailC($mailC);

    $titre = "Mon profil";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueMonProfil.php";
    include "$racine/vue/pied.html.php";
} else {
    $titre = "Mon profil";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueAuthentification.php";
    include "$racine/vue/pied.html.php";
}
?>
