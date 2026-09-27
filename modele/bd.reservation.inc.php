<?php

include_once "bd.inc.php";

/**
 * Retourne toutes les réservations d'un client
 */
function getReservationsByMailC($mailC) {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            SELECT r.*, ch.nomChambre, ch.etage, h.nomHotel, h.idHotel
            FROM reserve r
            JOIN chambrehotel ch ON r.idChambre = ch.idChambre
            JOIN hotel h ON ch.idHotel = h.idHotel
            WHERE r.mailC = :mailC
            ORDER BY r.dateReservation DESC
        ");
        $req->bindValue(':mailC', $mailC, PDO::PARAM_STR);
        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Vérifie si une réservation existe déjà pour ce client et cette chambre
 */
function getReservationById($mailC, $idChambre) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM reserve WHERE mailC = :mailC AND idChambre = :idChambre");
        $req->bindValue(':mailC',     $mailC,     PDO::PARAM_STR);
        $req->bindValue(':idChambre', $idChambre, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Ajoute une réservation
 */
function addReservation($mailC, $idChambre, $dateReservation, $dateLiberation) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            INSERT INTO reserve (mailC, idChambre, dateReservation, dateLiberation)
            VALUES (:mailC, :idChambre, :dateReservation, :dateLiberation)
        ");
        $req->bindValue(':mailC',           $mailC,           PDO::PARAM_STR);
        $req->bindValue(':idChambre',       $idChambre,       PDO::PARAM_INT);
        $req->bindValue(':dateReservation', $dateReservation, PDO::PARAM_STR);
        $req->bindValue(':dateLiberation',  $dateLiberation,  PDO::PARAM_STR);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Supprime une réservation
 */
function delReservation($mailC, $idChambre) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE FROM reserve WHERE mailC = :mailC AND idChambre = :idChambre");
        $req->bindValue(':mailC',     $mailC,     PDO::PARAM_STR);
        $req->bindValue(':idChambre', $idChambre, PDO::PARAM_INT);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');

    echo "getReservationsByMailC('admin@gmail.com') : \n";
    print_r(getReservationsByMailC("admin@gmail.com"));
}
?>
