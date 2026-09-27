<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url" => "#top",  "label" => "Conditions générales");
$menuBurger[] = Array("url" => "#accpt","label" => "Acceptation");
$menuBurger[] = Array("url" => "#desc", "label" => "Description");
$menuBurger[] = Array("url" => "#fonc", "label" => "Fonctionnalités");
$menuBurger[] = Array("url" => "#mode", "label" => "Modération");
$menuBurger[] = Array("url" => "#sanc", "label" => "Sanctions");
$menuBurger[] = Array("url" => "#moti", "label" => "Motifs");
$menuBurger[] = Array("url" => "#gene", "label" => "Généralités");
$menuBurger[] = Array("url" => "#prot", "label" => "Données personnelles");
$menuBurger[] = Array("url" => "#bila", "label" => "Bilan des fonctionnalités");

// affichage
$titre = "Conditions générales d'utilisation";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueCgu.php";
include "$racine/vue/pied.html.php";
?>
