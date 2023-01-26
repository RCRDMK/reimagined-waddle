<?php
session_start();
if (isset($_POST["profil-eid"])) {
    if (isset($_POST["profil-lesezeichen"])) {
        switch ($_POST["profil-lesezeichen"]) {
            case "Profil":
                $_SESSION["lesezeichenAnzeigen"] = false;
                break;
            case "Lesezeichen":
                $_SESSION["lesezeichenAnzeigen"] = true;
                break;
        }
        header("Location:../profil.php?id=".$_POST["profil-eid"]);
    } else {
        header("Location:../profil.php?err=profil-lz9&" . $_POST["profil-eid"]);
    }
} else {
    header("Location:../index.php?err=lz7");
}