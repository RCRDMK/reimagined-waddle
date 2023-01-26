<?php
session_start();
require_once('sqlite_dao.php');

/*
 * Fehlermeldungen:?err=
 * 0 - Passwörter nicht gleich
 * 1 - Email existiert
 * 2 - Name existiert
 * 3 - unbekannter Fehler
 */
if (isset($_POST["registrieren-passwort"]) && isset($_POST["registrieren-passwort-wiederholen"]) && isset($_POST["registrieren-email-adresse"]) && isset($_POST["registrieren-name"]) //&&
) {//is_string($_POST["registrieren-passwort"]) && is_string($_POST["registrieren-passwort-wiederholen"]) && is_string($_POST["registrieren-email-adresse"]) && is_string($_POST["registrieren-name"])) {//TODO ist is_string notwendig, hat damit beim probieren  icht funktioniert
    if (strcmp($_POST["registrieren-passwort"], $_POST["registrieren-passwort-wiederholen"]) == 0) {
        $datenbank = new sqlite_dao();//erstelle Datenbank
        $email = htmlspecialchars($_POST["registrieren-email-adresse"]);
        $passwort = htmlspecialchars($_POST["registrieren-passwort"]);
        $name = htmlspecialchars($_POST["registrieren-name"]);
        $registrierenArray = $datenbank->registrieren($email, $name, $passwort);
        $_SESSION["email"] = $email;

        switch ($registrierenArray[0]) {
            case 0://registrieren war erfolgreich
                $_SESSION["login"] = true;
                $_SESSION["u_id"] = $registrierenArray[1];
                header("Location: ../profil.php");
                break;
            case 1://Email existiert
                header("Location: ../registrieren.php?err=registrieren1");
                break;
            case 2://Name existiert
                header("Location: ../registrieren.php?err=registrieren2");
                break;
            case 3://unbekannter Fehler
                header("Location: ../registrieren.php?err=registrieren3");
                break;
        }

    } else {//Fehler: Passwörter nicht gleich
        header("Location: ../registrieren.php?err=registrieren0");
    }
}
