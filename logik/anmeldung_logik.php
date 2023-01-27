<?php
/**
 * Anmelden, Abmelden und Registrieren
 */

session_start();

require_once('sqlite_dao.php');
$datenbank = new sqlite_dao();// erstelle Datenbank


if (isset($_POST["anmelden-passwort"]) && isset($_POST["anmelden-email-adresse"]) &&
    is_string($_POST["anmelden-passwort"]) && is_string($_POST["anmelden-email-adresse"])) {//Anmelden

    $email = htmlspecialchars($_POST["anmelden-email-adresse"]);
    $passwort = htmlspecialchars($_POST["anmelden-passwort"]);

    $_SESSION["email"] = $email;
    $_SESSION["csrf"] = uniqid("", true);

    $login = $datenbank->login($email, $passwort);              //führt die login methode aus und gibt zurück, ob erfolgreich eingeloggt wurde
    if ($login[0]) {
        $_SESSION["u_id"] = $login[1];
        header('Location: ../profil.php?anm=true');
    } else {
        header("Location: ../anmelden.php?err=login0");

    }
    exit;
} else { //Abmelden
    if ($_SESSION["u_id"]) {
        //CSRF Token gesetzt
        if (!isset($_GET["csrf"]) || $_GET["csrf"] != $_SESSION["csrf"]) {
            header("Location:../index.php?err=csrf");
        } else {
            session_destroy();
            header('Location: ../index.php?suc=abm');
        }
    } else {
        header('Location: ../index.php?err=anm0');
    }
    exit();
}