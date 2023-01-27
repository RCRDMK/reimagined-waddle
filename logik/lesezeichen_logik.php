<?php
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();


//Check, ob angemeldet
if (isset($_SESSION["u_id"])) {
    $uid = htmlspecialchars($_SESSION["u_id"]);
} else {
    header("Location: ../index.php?err=lsl0");
    exit();
}

//Check, ob EID
if (isset($_POST["lesezeichen-eid"])) {
    $eid = htmlspecialchars($_POST["lesezeichen-eid"]);
} else {
    header("Location: ../index.php?err=lsl1");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../eintrag.php?eid=$eid&err=csrf");
    exit();
}

//Lesezeichen löschen oder erstellen
if ($datenbank->isLesezeichenGesetzt($uid, $eid)) {//Lesezeichen löschen
    $erfolg = $datenbank->lesezeichenEntfernen($uid, $eid);
    if ($erfolg) {
        header("Location:../eintrag.php?eid=$eid&suc=lsl2");
    } else {
        header("Location:../eintrag.php?eid=$eid&err=lsl3");
    }
} else {
    $erfolg = $datenbank->lesezeichenSetzen($uid, $eid);
    if ($erfolg) {
        header("Location:../eintrag.php?eid=$eid&suc=lsl4");
    } else {
        header("Location:../eintrag.php?eid=$eid&err=lsl5");
    }
}

//Check, ob Erfolg, sonst Fehlermeldung

exit();


