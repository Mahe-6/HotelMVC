<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.utilisateur.inc.php";

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url" => "./?action=connexion",  "label" => "Connexion");
$menuBurger[] = Array("url" => "./?action=inscription", "label" => "Inscription");

$inscrit = false;
$msg = "";

// recuperation et traitement des donnees POST
if (isset($_POST["mailC"]) && isset($_POST["mdpC"]) && isset($_POST["pseudo"])) {
    if ($_POST["mailC"] != "" && $_POST["mdpC"] != "" && $_POST["pseudo"] != "") {
        $mailC  = $_POST["mailC"];
        $mdpC   = $_POST["mdpC"];
        $pseudo = $_POST["pseudo"];

        $ret = addClient($mailC, $mdpC, $pseudo);
        if ($ret) {
            $inscrit = true;
        } else {
            $msg = "L'utilisateur n'a pas pu être enregistré.";
        }
    } else {
        $msg = "Veuillez renseigner tous les champs.";
    }
}

// affichage
if ($inscrit) {
    $titre = "Inscription confirmée";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueConfirmationInscription.php";
    include "$racine/vue/pied.html.php";
} else {
    $titre = "Inscription";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueInscription.php";
    include "$racine/vue/pied.html.php";
}
?>
