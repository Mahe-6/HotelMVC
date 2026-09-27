<?php

include_once "bd.inc.php";

function getServices() {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM service");
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getServicesPreferesByMailC($mailC) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT service.* FROM service, servicechercher
                               WHERE service.idService = servicechercher.idService
                               AND servicechercher.mailC = :mailC");
        $req->bindValue(':mailC', $mailC, PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getServiceNonPreferesByMailC($mailC) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM service
                               WHERE idService NOT IN (
                                   SELECT idService FROM servicechercher WHERE mailC = :mailC
                               )");
        $req->bindValue(':mailC', $mailC, PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

function getServicesByIdHotel($idHotel) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT service.* FROM service, serviceproposer
                               WHERE service.idService = serviceproposer.idService
                               AND serviceproposer.idHotel = :idHotel");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) { $resultat[] = $ligne; $ligne = $req->fetch(PDO::FETCH_ASSOC); }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
    return $resultat;
}

/**
 * Remplace tous les services cherchés du client par la nouvelle sélection
 */
function sauvegarderServicesCherches($mailC, $idsServices) {
    try {
        $cnx = connexionPDO();

        // suppression des anciens
        $del = $cnx->prepare("DELETE FROM servicechercher WHERE mailC = :mailC");
        $del->bindValue(':mailC', $mailC, PDO::PARAM_STR);
        $del->execute();

        // insertion des nouveaux
        $ins = $cnx->prepare("INSERT INTO servicechercher (mailC, idService) VALUES (:mailC, :idService)");
        foreach ($idsServices as $idService) {
            $ins->bindValue(':mailC',     $mailC,     PDO::PARAM_STR);
            $ins->bindValue(':idService', $idService, PDO::PARAM_INT);
            $ins->execute();
        }
    } catch (PDOException $e) { print "Erreur : " . $e->getMessage(); die(); }
}
?>
