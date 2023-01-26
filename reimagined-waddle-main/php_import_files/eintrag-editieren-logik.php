<?php
//TODO: Daten überprüfen und und Datenbank Methode rufen
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();
$uid = $_SESSION["u_id"];


if (isset($_POST["eintrag-editieren-eid"]) && isset($_POST["eintrag-editieren-titel"]) &&
    isset($_POST["eintrag-editieren-beschreibung"]) && isset($_POST["eintrag-editieren-tags"])) {

    $eid = htmlspecialchars($_POST["eintrag-editieren-eid"]);
    $titel = htmlspecialchars($_POST["eintrag-editieren-titel"]);
    $beschreibung = htmlspecialchars($_POST["eintrag-editieren-beschreibung"]);
    $tags = htmlspecialchars($_POST["eintrag-editieren-tags"]);

    $updateInt = $datenbank->eintragEditieren($uid, $eid, $titel, $beschreibung, $tags);
    if ($updateInt >= 0) {
        header("Location:../eintrag.php?e_id=$eid");//TODO:ErfolgVariable und Erfolg in Eintrag anzeigen
    } else {
        switch ($updateInt) {
            case -1:
                header("Location:index.php?err=ee6");
                break;
            case -2:
                header("Location:index.php?err=ee9");
                break;

        }
    }
}
echo "Fehler: ";