<?php

include_once "bd.inc.php";

function getClients() {
    
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from client");
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

function getClientByMailC($mailC) {
    $resultat = false;

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from client where mailC=:mailC");
        $req->bindValue(':mailC', $mailC, PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function addClient($mailC, $mdpC, $pseudo) {
    $resultat = false;

    try {
        $cnx = connexionPDO();

        $mdpCCrypt = crypt($mdpC, "sel");
        $req = $cnx->prepare("insert into client (mailC, mdpC, pseudo) values(:mailC, :mdpC, :pseudo)");
        $req->bindValue(':mailC',  $mailC,     PDO::PARAM_STR);
        $req->bindValue(':mdpC',   $mdpCCrypt, PDO::PARAM_STR);
        $req->bindValue(':pseudo', $pseudo,    PDO::PARAM_STR);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');

    echo "getClients() : \n";
    print_r(getClients());

    echo "getClientByMailC('admin@gmail.com') : \n";
    print_r(getClientByMailC("admin@gmail.com"));

    echo "addClient('test2@gmail.com', 'test', 'TestUser') : \n";
    print_r(addClient("test2@gmail.com", "test", "TestUser"));
}
?>
