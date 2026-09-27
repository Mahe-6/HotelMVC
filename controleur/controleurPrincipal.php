<?php

function controleurPrincipal($action) {
    $lesActions = array();
    $lesActions["defaut"]      = "listeHotel.php";
    $lesActions["liste"]       = "listeHotel.php";
    $lesActions["detail"]      = "detailHotel.php";
    $lesActions["recherche"]   = "rechercheHotel.php";
    $lesActions["connexion"]   = "connexion.php";
    $lesActions["deconnexion"] = "deconnexion.php";
    $lesActions["profil"]      = "monProfil.php";
    $lesActions["cgu"]         = "cgu.php";
    $lesActions["aimer"]       = "aimer.php";
    $lesActions["inscription"] = "inscription.php";
    $lesActions["reservation"] = "reservation.php"; 

    if (array_key_exists($action, $lesActions)) {
        return $lesActions[$action];
    } else {
        return $lesActions["defaut"];
    }
}
?>
