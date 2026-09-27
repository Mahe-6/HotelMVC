<?php

include_once "bd.inc.php";

function getAimerById($mailC, $idHotel) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from aimerhotel where mailC=:mailC and idHotel=:idHotel");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->bindValue(':mailC',   $mailC,   PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function addAimer($mailC, $idHotel) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("insert into aimerhotel (mailC, idHotel) values(:mailC, :idHotel)");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->bindValue(':mailC',   $mailC,   PDO::PARAM_STR);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function delAimer($mailC, $idHotel) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("delete from aimerhotel where idHotel=:idHotel and mailC=:mailC");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
        $req->bindValue(':mailC',   $mailC,   PDO::PARAM_STR);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');

    echo "getAimerById('admin@gmail.com', 1) : \n";
    print_r(getAimerById("admin@gmail.com", 1));

    echo "addAimer('admin@gmail.com', 1) : \n";
    print_r(addAimer("admin@gmail.com", 1));

    echo "delAimer('admin@gmail.com', 1) : \n";
    print_r(delAimer("admin@gmail.com", 1));
}
?>
