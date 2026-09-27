<?php

function connexionPDO() {
    $login   = "u280362615_ProjetMVC";
    $mdp     = "AFJFGUE6457fhzhh";
    $bd      = "u280362615_projetmvc";
    $serveur = "127.0.0.1";

    try {
        $conn = new PDO(
            "mysql:host=$serveur;dbname=$bd",
            $login,
            $mdp,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        print "Erreur de connexion PDO : " . $e->getMessage();
        die();
    }
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');
    echo "connexionPDO() : \n";
    print_r(connexionPDO());
}
?>
