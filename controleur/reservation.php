<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.chambre.inc.php";
include_once "$racine/modele/bd.reservation.inc.php";
include_once "$racine/modele/bd.hotel.inc.php";

if (!isLoggedOn()) {
    $titre = "Réservation";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueAuthentification.php";
    include "$racine/vue/pied.html.php";
    return;
}

$mailC = getMailCLoggedOn();
$msg   = "";
$reserve = false;
$etape = "dates";

$idHotel = "";
if (isset($_GET["idHotel"]))        $idHotel = $_GET["idHotel"];
elseif (isset($_POST["idHotel"]))   $idHotel = $_POST["idHotel"];

if (isset($_POST["step"]) && $_POST["step"] == "dates") {
    $etape       = "chambres";
    $dateArrivee = $_POST["dateArrivee"] ?? "";
    $dateDepart  = $_POST["dateDepart"]  ?? "";

    if ($dateArrivee == "" || $dateDepart == "") {
        $msg = "Veuillez renseigner les deux dates."; $etape = "dates";
    } elseif ($dateArrivee >= $dateDepart) {
        $msg = "La date d'arrivée doit être antérieure à la date de départ."; $etape = "dates";
    } else {
        $chambresDispos = getChambresDisposByIdHotel($idHotel, $dateArrivee, $dateDepart);
        // charger les photos pour chaque chambre dispo
        foreach ($chambresDispos as &$chambre) {
            $chambre['photos'] = getPhotosByIdChambre($chambre['idChambre']);
        }
        unset($chambre);
        if (empty($chambresDispos)) {
            $msg = "Aucune chambre disponible pour ces dates."; $etape = "dates";
        }
    }
}

if (isset($_POST["step"]) && $_POST["step"] == "chambre") {
    $idChambre   = $_POST["idChambre"]   ?? "";
    $dateArrivee = $_POST["dateArrivee"] ?? "";
    $dateDepart  = $_POST["dateDepart"]  ?? "";

    if ($idChambre == "" || $dateArrivee == "" || $dateDepart == "") {
        $msg = "Données manquantes, veuillez recommencer."; $etape = "dates";
    } else {
        $dejaReserve = getReservationById($mailC, $idChambre);
        if ($dejaReserve) {
            $msg = "Vous avez déjà une réservation pour cette chambre."; $etape = "dates";
        } else {
            $ret = addReservation($mailC, $idChambre, $dateArrivee, $dateDepart);
            if ($ret) {
                $reserve   = true;
                $laChambre = getChambreByIdChambre($idChambre);
                $etape     = "confirmation";
            } else {
                $msg = "La réservation n'a pas pu être enregistrée."; $etape = "dates";
            }
        }
    }
}

$unHotel = getHotelByIdHotel($idHotel);
$titre   = "Réservation — " . ($unHotel ? $unHotel['nomHotel'] : "Hôtel");
include "$racine/vue/entete.html.php";
if ($etape == "confirmation") {
    include "$racine/vue/vueConfirmationReservation.php";
} else {
    include "$racine/vue/vueReservation.php";
}
include "$racine/vue/pied.html.php";
?>
