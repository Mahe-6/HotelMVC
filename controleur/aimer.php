<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.aimer.inc.php";
include_once "$racine/modele/authentification.inc.php";

// recuperation de l'id de l'hotel
$idHotel = $_GET["idHotel"];

// action uniquement si l'utilisateur est connecte
$mailC = getMailCLoggedOn();
if ($mailC != "") {
    $aimer = getAimerById($mailC, $idHotel);

    if ($aimer == false) {
        addAimer($mailC, $idHotel);
    } else {
        delAimer($mailC, $idHotel);
    }
}

// redirection vers la page precedente
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
