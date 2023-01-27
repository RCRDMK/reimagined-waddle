<?php
session_start();
include_once("sqlite_dao.php");
$datenbank = new sqlite_dao();

//angemeldet, Check
if (isset($_SESSION["u_id"])) {
    $uid = $_SESSION["u_id"];
} else {
    header("Location: ../index.php?err=ell0");
    exit();
}

//EID, check
if (isset($_POST["eintrag-loeschen-eid"])) {
    $eid = htmlspecialchars($_POST["eintrag-loeschen-eid"]);
} else {
    header("Location: ../index.php?err=ell1");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../index.php?err=csrf");
    exit();
}

//Eintrag löschen
if ($datenbank->eintragLoeschen($uid, $eid)) {//Erfolg
    header("Location: ../index.php?suc=ell2");
} else {//kein Erfolg
    header("Location: ../eintrag.php?eid=$eid&err=ell3");
}
exit();