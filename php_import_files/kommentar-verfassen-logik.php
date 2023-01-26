<?php
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();
if (isset($_POST["eintrag-neuer-kommentar-eid"])) {//Check, ob Eintrag ausgewählt wurde
    $eid = $_POST["eintrag-neuer-kommentar-eid"];
    if (isset($_SESSION["u_id"]) && $_SESSION["u_id"] >= 0) {//Check, ob User angemeldet
        $uid = $_SESSION["u_id"];
        if (isset($_POST["eintrag-neuer-kommentar-text"])) {//Check, ob Text existiert
            $text = htmlspecialchars($_POST["eintrag-neuer-kommentar-text"]);
            $kommentarErstellt = $datenbank->kommentarErstellen($uid, $eid, $text);
            if ($kommentarErstellt) {//gehe zurück zum Eintrag, Kommentar erfolgreich erstellt
                header("Location:../eintrag.php");
                exit();
            } else {//gehe zurück zum Eintrag, Kommentar wurde nicht erstellt
                header("Location:../eintrag.php?e_id=" . $eid . "&err=");//TODO FehlerCode Kommentar nicht erstellt
                exit();
            }
        } else {
            header("Location:../eintrag.php?e_id=" . $eid . "&err=");//TODO FehlerCode text fehlt
            exit();
        }
    } else {//Weiterleitung zum Eintrag, wenn User nicht angemeldet
        header("Location:../eintrag.php?e_id=" . $eid . "&err=");//TODO FehlerCode u_id fehlt
        exit();
    }
} else {//Weiterleitung nach index, wenn kein Eintrag zugeordnet werden kann
    header("Location:../index.php?err=");//TODO FehlerCode e_id fehlt
    exit();
}
