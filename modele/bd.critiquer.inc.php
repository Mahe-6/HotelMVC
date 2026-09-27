<?php

include_once "bd.inc.php";

function getCritiquerByIdHotel($idHotel) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM critiquehotel WHERE idHotel=:idHotel ORDER BY note DESC");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getNoteMoyenneByIdHotel($idHotel) {
    $resultat = 0;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT avg(note) as moyenne FROM critiquehotel WHERE idHotel=:idHotel");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        if ($ligne && $ligne["moyenne"] !== null) $resultat = $ligne["moyenne"];
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Vérifie si le client a déjà critiqué cet hôtel
 */
function getCritiqueByMailCAndIdHotel($mailC, $idHotel) {
    $resultat = false;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM critiquehotel WHERE mailC=:mailC AND idHotel=:idHotel");
        $req->bindValue(':mailC',   $mailC,   PDO::PARAM_STR);
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Vérifie si le client a déjà réservé dans cet hôtel
 */
function aDejaReserveHotel($mailC, $idHotel) {
    $resultat = false;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            SELECT COUNT(*) as nb FROM reserve r
            JOIN chambrehotel ch ON r.idChambre = ch.idChambre
            WHERE r.mailC = :mailC AND ch.idHotel = :idHotel
        ");
        $req->bindValue(':mailC',   $mailC,   PDO::PARAM_STR);
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        $resultat = ($ligne && $ligne['nb'] > 0);
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Ajoute une critique
 */
function addCritique($mailC, $idHotel, $note, $commentaire) {
    $resultat = false;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            INSERT INTO critiquehotel (mailC, idHotel, note, commentaire)
            VALUES (:mailC, :idHotel, :note, :commentaire)
        ");
        $req->bindValue(':mailC',       $mailC,       PDO::PARAM_STR);
        $req->bindValue(':idHotel',     $idHotel,     PDO::PARAM_INT);
        $req->bindValue(':note',        $note,        PDO::PARAM_INT);
        $req->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
        $resultat = $req->execute();
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Supprime une critique
 */
function delCritique($mailC, $idHotel) {
    $resultat = false;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE FROM critiquehotel WHERE mailC=:mailC AND idHotel=:idHotel");
        $req->bindValue(':mailC',   $mailC,   PDO::PARAM_STR);
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $resultat = $req->execute();
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}
?>
