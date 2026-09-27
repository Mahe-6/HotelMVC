<?php

include_once "bd.inc.php";

function getHotelByIdHotel($idHotel) {
    $resultat = false;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM hotel WHERE idHotel=:idHotel");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getHotels() {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM hotel");
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getHotelsByNomHotel($nomHotel) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM hotel WHERE nomHotel LIKE :nomHotel");
        $req->bindValue(':nomHotel', "%" . $nomHotel . "%", PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getHotelsByAdresse($adresseHotel, $codePostal, $villeHotel) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM hotel
                               WHERE adresseHotel LIKE :adresseHotel
                               AND codePostal LIKE :codePostal
                               AND villeHotel LIKE :villeHotel");
        $req->bindValue(':adresseHotel', "%" . $adresseHotel . "%", PDO::PARAM_STR);
        $req->bindValue(':codePostal',   $codePostal . "%",         PDO::PARAM_STR);
        $req->bindValue(':villeHotel',   "%" . $villeHotel . "%",   PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Recherche les hôtels qui proposent TOUS les services cochés
 * 
 */
function getHotelsByServices($idsServices) {
    $resultat = array();
    if (empty($idsServices)) return getHotels();

    try {
        $cnx = connexionPDO();
        $nb = count($idsServices);

        // placeholders : :s0, :s1, :s2 ...
        $placeholders = implode(',', array_map(fn($i) => ":s$i", array_keys($idsServices)));

        $req = $cnx->prepare("
            SELECT h.* FROM hotel h
            WHERE (
                SELECT COUNT(DISTINCT sp.idService)
                FROM serviceproposer sp
                WHERE sp.idHotel = h.idHotel
                AND sp.idService IN ($placeholders)
            ) = :nb
        ");
        foreach ($idsServices as $i => $idService) {
            $req->bindValue(":s$i", $idService, PDO::PARAM_INT);
        }
        $req->bindValue(':nb', $nb, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getHotelsAimesByMailC($mailC) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT hotel.* FROM hotel, aimerhotel
                               WHERE hotel.idHotel = aimerhotel.idHotel
                               AND aimerhotel.mailC = :mailC");
        $req->bindValue(':mailC', $mailC, PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}
?>
