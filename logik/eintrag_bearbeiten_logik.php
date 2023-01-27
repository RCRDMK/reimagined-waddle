<?php
session_start();
include_once("sqlite_dao.php");
$datenbank = new sqlite_dao();

//angemeldet, Check
if (isset($_SESSION["u_id"])) {
    $uid = $_SESSION["u_id"];
} else {
    header("Location: ../index.php?err=eel0");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../index.php?err=csrf");
    exit();
}

if (isset($_POST["eintrag-editieren-eid"]) && isset($_POST["bearbeiten-titel"]) && isset($_POST["bearbeiten-beschreibung"]) && isset($_POST["bearbeiten-tags"])) {
    $eid = htmlspecialchars($_POST["eintrag-editieren-eid"]);
    $titel = htmlspecialchars($_POST["bearbeiten-titel"]);
    $beschreibung = htmlspecialchars($_POST["bearbeiten-beschreibung"]);
    $tags = htmlspecialchars($_POST["bearbeiten-tags"]);
    $erfolg = $datenbank->eintragEditieren($uid, $eid, $titel, $beschreibung, $tags);
    if ($erfolg >= 0) {//Erfolg
        header("Location: ../eintrag.php?eid=$eid&suc=eel2");
        exit();

    } else if ($erfolg = -1) {//darf nicht bearbeiten
        header("Location: ../eintrag.php?eid=$eid&err=eel3");
        exit();
    } else if ($erfolg = -2) {//update fehlgeschlagen
        header("Location: ../eintrag.php?eid=$eid&err=eel4");
        exit();
    }

} else {//POST fehlt
    header("Location: ../index.php?err=eel1");
    exit();
}