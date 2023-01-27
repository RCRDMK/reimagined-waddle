<?php
require_once('sqlite_dao.php');
$datenbank = new sqlite_dao();// erstelle Datenbank
session_start();

//email-validieren und tmp_account anlegen
if (isset($_POST["registrieren-email-adresse-check"])) {
    $mail = htmlspecialchars($_POST["registrieren-email-adresse-check"]);
    if ($datenbank->registrierungMail($mail)) {
        header("Location: ../registrieren.php?reg=mail");//Mail wurde erfolgreich versendet
    } else {
        header("Location: ../registrieren.php?err=reg0");//Mail konnte nicht gesendet werden
    }
    exit();
} else if (isset($_POST["registrieren-schrittZwei-mail"]) && isset($_POST["registrieren-name"]) && isset($_POST["registrieren-passwort"]) && isset($_POST["registrieren-passwort-wiederholen"]) && isset($_POST["registrieren-regID"])) {
    $mail = htmlspecialchars($_POST["registrieren-schrittZwei-mail"]);
    $name = htmlspecialchars($_POST["registrieren-name"]);
    $passwort = htmlspecialchars($_POST["registrieren-passwort"]);
    $passwortWdh = htmlspecialchars($_POST["registrieren-passwort-wiederholen"]);
    $regID = htmlspecialchars($_POST["registrieren-regID"]);

    if ($passwort == $passwortWdh) {//Passwörter stimmen überein?
        $uid = $datenbank->registrierungAbschluss($regID, $mail, $name, $passwort);

        if ($uid >= 0) {
            $_SESSION["u_id"] = $uid;
            $_SESSION["csrf"] = uniqid("", true);
            header("Location: ../profil.php?suc=reg1&pid=" . $uid);//erfolgreich registriert
        } else if ($uid == -1) {
            header("Location: ../registrieren.php?err=reg2&reg=" . $regID); //name vergeben
        } else if ($uid == -2) {
            header("Location: ../registrieren.php?err=reg3&reg=" . $regID); //E-Mail oder Registrierungs-Link falsch
        } else if ($uid == -3) {
            header("Location: ../registrieren.php?err=reg4&reg=" . $regID); //unbekannter Fehler
        }
    } else {
        header("Location: ../registrieren.php?err=reg5&reg=" . $regID);//Passwörter stimmen nicht überein
    }
    exit();
} else {
    header("Location: ../index.php");
    exit();
}








