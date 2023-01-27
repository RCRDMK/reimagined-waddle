<?php
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();

//Check, ob angemeldet
if (isset($_SESSION["u_id"])) {
    $uid = htmlspecialchars($_SESSION["u_id"]);
} else {
    header("Location:../index.php?err=kll0");
    exit();
}
//Check, ob EID
if (isset($_POST["kommentar-loeschen-eid"])) {
    $eid = htmlspecialchars($_POST["kommentar-loeschen-eid"]);
} else {
    header("Location:../index.php?err=kll1");
    exit();
}

//Check, ob KID
if (isset($_POST["kommentar-loeschen-kid"])) {
    $kid = htmlspecialchars($_POST["kommentar-loeschen-kid"]);
} else {
    header("Location:../eintrag.php?eid=$eid&err=kll2");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../index.php?err=csrf");
    exit();
}

//Kommentar löschen und Rückmeldung, ob Erfolg
if($datenbank->kommentarLoeschen($kid,$uid)){
    header("Location:../eintrag.php?eid=$eid&suc=kll3");
}else{
    header("Location:../eintrag.php?eid=$eid&err=kll4");
}
exit();