<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/authentification.inc.php";

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url" => "./?action=connexion",  "label" => "Connexion");
$menuBurger[] = Array("url" => "./?action=inscription", "label" => "Inscription");

// recuperation des donnees POST
if (isset($_POST["mailC"]) && isset($_POST["mdpC"])) {
    $mailC = $_POST["mailC"];
    $mdpC  = $_POST["mdpC"];
} else {
    $mailC = "";
    $mdpC  = "";
}

// tentative de connexion
login($mailC, $mdpC);

if (isLoggedOn()) {
    // si connecté, on redirige vers le profil
    include "$racine/controleur/monProfil.php";
} else {
    // sinon on affiche le formulaire de connexion
    $titre = "Connexion";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueAuthentification.php";
    include "$racine/vue/pied.html.php";
}
?>
