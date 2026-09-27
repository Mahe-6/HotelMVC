<?php

include_once "bd.inc.php";

function getPhotosByIdHotel($idHotel) {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from photohotel where idHotel=:idHotel");
        $req->bindValue(':idHotel', $idHotel, PDO::PARAM_INT);
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

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');

    echo "getPhotosByIdHotel(1) : \n";
    print_r(getPhotosByIdHotel(1));
}
?>
