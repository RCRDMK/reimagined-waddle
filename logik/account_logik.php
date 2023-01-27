<?php
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();

//Check, ob angemeldet, wenn nein, dann Fehler
if (isset($_SESSION["u_id"])) {
    $uid = $_SESSION["u_id"];
} else {
    header("Location: ../index.php?err=acl0");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../index.php?err=csrf");
    exit();
}

//Auswahl der Methode und Ausführung der Methode
if (isset($_POST["loeschen"])) {
    //Account löschen
    if ($datenbank->accountLoeschen($uid)) {//Erfolg
        session_destroy();
        header("Location: ../index.php?suc=acl2");
    } else {//nicht gelöscht
        header("Location: ../index.php?err=acl3");
    }
    exit();

} elseif (isset($_POST["einstellungen-passwort-aendern-passwort-alt"]) && isset($_POST["einstellungen-passwort-aendern-passwort-neu"]) && isset($_POST["passwort-aendern"])) {
    //Passwort ändern
    $pwAlt = htmlspecialchars($_POST["einstellungen-passwort-aendern-passwort-alt"]);
    $pwNeu = htmlspecialchars($_POST["einstellungen-passwort-aendern-passwort-neu"]);

    if ($datenbank->passwortAendern($uid, $pwAlt, $pwNeu)) {//Erfolg
        header("Location: ../index.php?suc=acl4");
    } else {//nicht geändert
        header("Location: ../index.php?err=acl5");
    }
    exit();
} else {//nichts ausgewählt
    header("Location: ../profil.php?err=acl1");
    exit();
}
