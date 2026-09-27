<?php

include_once "bd.inc.php";

function getChambresByIdHotel($idHotel) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM chambrehotel WHERE idHotel = :idHotel");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getChambreByIdChambre($idChambre) {
    $resultat = false;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM chambrehotel WHERE idChambre = :idChambre");
        $req->bindValue(':idChambre', $idChambre, PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Retourne les chambres disponibles d'un hôtel pour une période donnée
 */
function getChambresDisposByIdHotel($idHotel, $dateArrivee, $dateDepart) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            SELECT ch.* FROM chambrehotel ch
            WHERE ch.idHotel = :idHotel
            AND ch.idChambre NOT IN (
                SELECT r.idChambre FROM reserve r
                WHERE r.dateReservation < :dateDepart
                AND r.dateLiberation > :dateArrivee
            )
        ");
        $req->bindValue(':idHotel',    $idHotel,    PDO::PARAM_INT);
        $req->bindValue(':dateArrivee', $dateArrivee, PDO::PARAM_STR);
        $req->bindValue(':dateDepart',  $dateDepart,  PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Retourne les photos d'une chambre
 */
function getPhotosByIdChambre($idChambre) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM photochambre WHERE idChambre = :idChambre");
        $req->bindValue(':idChambre', $idChambre, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}
?>
