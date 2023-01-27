<?php
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();

//Check, ob angemeldet
if (isset($_SESSION["u_id"])) {
    $uid = $_SESSION["u_id"];
} else {
    header("Location:../index.php?err=kel0");
    exit();
}
//Check, ob EID
if (isset($_POST["kommentar-erstellen-eid"])) {
    $eid = htmlspecialchars($_POST["kommentar-erstellen-eid"]);
} else {
    header("Location:../index.php?err=kel1");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../index.php?err=csrf");
    exit();
}

//Check, ob Kommentartext übergeben
if (isset($_POST["kommentar-erstellen-text"])) {
    $text = htmlspecialchars($_POST["kommentar-erstellen-text"]);
} else {
    header("Location:../eintrag.php?eid=$eid&err=kel2");
    exit();
}

//erstelle Kommentar und checke Erfolg:
if ($datenbank->kommentarErstellen($uid, $eid, $text)) {
    header("Location:../eintrag.php?eid=$eid&suc=kel3");
} else {
    header("Location:../eintrag.php?eid=$eid&err=kel4");
}
exit();
