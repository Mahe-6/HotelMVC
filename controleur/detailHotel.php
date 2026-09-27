<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.hotel.inc.php";
include_once "$racine/modele/bd.service.inc.php";
include_once "$racine/modele/bd.photo.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";
include_once "$racine/modele/bd.aimer.inc.php";
include_once "$racine/modele/authentification.inc.php";

$idHotel = $_GET["idHotel"];

// suppression critique
if (isset($_GET["supprimerCritique"])) {
    $mailC = getMailCLoggedOn();
    if ($mailC != "") delCritique($mailC, $idHotel);
    header("Location: ./?action=detail&idHotel=$idHotel");
    exit;
}

// ajout critique
$msgCritique = "";
if (isset($_POST["action_critique"]) && $_POST["action_critique"] == "ajouter") {
    $mailC = getMailCLoggedOn();
    if ($mailC != "") {
        $note        = intval($_POST["note"]);
        $commentaire = trim($_POST["commentaire"]);
        if ($note >= 1 && $note <= 5 && $commentaire != "") {
            $dejaFait = getCritiqueByMailCAndIdHotel($mailC, $idHotel);
            if (!$dejaFait) {
                addCritique($mailC, $idHotel, $note, $commentaire);
            } else {
                $msgCritique = "Vous avez deja redige une critique pour cet hotel.";
            }
        } else {
            $msgCritique = "Veuillez saisir une note (1-5) et un commentaire.";
        }
    }
}

// donnees
$unHotel     = getHotelByIdHotel($idHotel);
$lesServices = getServicesByIdHotel($idHotel);
$lesPhotos   = getPhotosByIdHotel($idHotel);
$noteMoy     = round(getNoteMoyenneByIdHotel($idHotel), 0);
$mailC       = getMailCLoggedOn();
$aimer       = getAimerById($mailC, $idHotel);
$critiques   = getCritiquerByIdHotel($idHotel);

// droits critique
$peutCritiquer = false;
$dejaCritique  = false;
if ($mailC != "") {
    $dejaCritique  = (getCritiqueByMailCAndIdHotel($mailC, $idHotel) != false);
    $peutCritiquer = aDejaReserveHotel($mailC, $idHotel) && !$dejaCritique;
}


$heroHotel = array(
    'idHotel'    => $unHotel['idHotel'],
    'nomHotel'   => $unHotel['nomHotel'],
    'villeHotel' => $unHotel['villeHotel'],
    'codePostal' => $unHotel['codePostal'],
    'note'       => $noteMoy,
    'aime'       => ($aimer != false),
);

$titre = $unHotel['nomHotel'];
include "$racine/vue/entete.html.php";
include "$racine/vue/vueDetailHotel.php";
include "$racine/vue/pied.html.php";
?>
