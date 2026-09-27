<?php

include_once "bd.utilisateur.inc.php";

function login($mailC, $mdpC) {
    if (!isset($_SESSION)) {
        session_start();
    }

    $client = getClientByMailC($mailC);

    // Vérification que le client existe avant de comparer
    if ($client && isset($client["mdpC"])) {
        $mdpBD = $client["mdpC"];
        if (trim($mdpBD) == trim(crypt($mdpC, $mdpBD))) {
            $_SESSION["mailC"] = $mailC;
            $_SESSION["mdpC"]  = $mdpBD;
        }
    }
}

function logout() {
    if (!isset($_SESSION)) {
        session_start();
    }
    unset($_SESSION["mailC"]);
    unset($_SESSION["mdpC"]);
}

function getMailCLoggedOn() {
    if (isLoggedOn()) {
        return $_SESSION["mailC"];
    }
    return "";
}

function isLoggedOn() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $ret = false;

    if (isset($_SESSION["mailC"])) {
        $client = getClientByMailC($_SESSION["mailC"]);
        
        if ($client &&
            $client["mailC"] == $_SESSION["mailC"] &&
            $client["mdpC"]  == $_SESSION["mdpC"]
        ) {
            $ret = true;
        }
    }
    return $ret;
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');

    login("admin@gmail.com", "test");
    if (isLoggedOn()) {
        echo "logged";
    } else {
        echo "not logged";
    }
    logout();
}
?>
