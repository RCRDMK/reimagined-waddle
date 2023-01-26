<?php
session_start();

//require_once('dummy_dao.php');
require_once('sqlite_dao.php');
if (isset($_POST["anmelden-passwort"]) && isset($_POST["anmelden-email-adresse"]) &&
    is_string($_POST["anmelden-passwort"]) && is_string($_POST["anmelden-email-adresse"])) {

    $datenbank = new sqlite_dao(); //dummy_dao();//erstelle Datenbank

    $email = htmlspecialchars($_POST["anmelden-email-adresse"]);
    $passwort = htmlspecialchars($_POST["anmelden-passwort"]);
    $_SESSION["email"] = $email;

    $login = $datenbank->login($email, $passwort);//führt die login methode aus und gibt zurück, ob erfolgreich eingeloggt wurde
    if ($login[0]) {
        $_SESSION["login"] = true;
        $_SESSION["u_id"] = $login[1];
        header('Location: ../profil.php?login=true');
        exit;
    } else {
        header("Location: ../anmelden.php?err=login0");
        exit;
        
    }
}
?>