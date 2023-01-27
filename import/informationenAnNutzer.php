<?php
//Informationen für den Nutzer
$nachricht = "";

$code = "";

if (isset($_GET["err"])) {
    $code = htmlspecialchars($_GET["err"]);
    $nachricht = "Fehler: ";
} else if (isset($_GET["suc"])) {
    $code = htmlspecialchars($_GET["suc"]);
    $nachricht = "Erfolg: ";
}
if ($code !== "") {
    switch ($code) {
        default:
            $nachricht = "Unbekannter " . $nachricht . $code;
            break;
        case "login0":
            $nachricht = $nachricht . "nicht angemeldet. Passwort oder E-Mail ist falsch";
            break;
        case "eel0":
        case "enl7":
        case "ell0":
        case "kel0":
        case "kll0":
        case "lsl0":
        case "bea0":
        case "pre0":
        case "acl0":
            $nachricht = $nachricht . "nicht angemeldet";
            break;
        case "acl2":
            $nachricht = $nachricht . "Account gelöscht";
            break;
        case "acl3":
            $nachricht = $nachricht . "Account nicht gelöscht";
            break;
        case "acl4":
            $nachricht = $nachricht . "Passwort geändert";
            break;
        case "acl5":
            $nachricht = $nachricht . "Passwort nicht geändert";
            break;
        case "acl1":
            $nachricht = $nachricht . "Passwort nicht geändert; Daten wurden nicht übergeben";
            break;
        case "anm":
            $nachricht = $nachricht . "angemeldet";
            break;
        case "registrieren2":
            $nachricht = $nachricht . "Name existiert bereits";
            break;
        case "registrieren3":
            $nachricht = $nachricht . "nicht registriert";
            break;
        case "registrieren0":
            $nachricht = $nachricht . "Passwörter stimmen nicht überein";
            break;
        case "abm":
            $nachricht = $nachricht . "abgemeldet";
            break;
        case "eel2":
            $nachricht = $nachricht . "Eintrag bearbeitet";
            break;
        case "bea2":
        case "eel3":
            $nachricht = $nachricht . "Eintrag darf nicht bearbeitet werden";
            break;
        case "eel4":
            $nachricht = $nachricht . "Eintrag konnte nicht bearbeitet werden";
            break;
        case "ell1":
        case "kel1":
        case "kll1":
        case "lsl1":
        case "eintrag0":
        case "bea1":
        case "eel1":
            $nachricht = $nachricht . "kein Eintrag ausgewählt";
            break;
        case "enl1":
            $nachricht = $nachricht . "Text kann momentan nicht erstellt werden";
            break;
        case "enl2":
            $nachricht = $nachricht . "kein Bild oder falsches Format";
            break;
        case "enl3":
            $nachricht = $nachricht . "kein Video oder falsches Format";
            break;
        case "enl4":
            $nachricht = $nachricht . "kein PDF-Dokument";
            break;
        case "enl5":
            $nachricht = $nachricht . "Datei konnte nicht hochgeladen werden";
            break;
        case "enl6":
            $nachricht = $nachricht . "Eintrag konnte nicht erstellt werden";
            break;
        case "kel2":
        case "enl0":
            $nachricht = $nachricht . "Daten fehlen";
            break;
        case "ell2":
            $nachricht = $nachricht . "Eintrag gelöscht";
            break;
        case "ell3":
            $nachricht = $nachricht . "Eintrag nicht gelöscht";
            break;
        case "kel3":
            $nachricht = $nachricht . "Kommentar erstellt";
            break;
        case "kel4":
            $nachricht = $nachricht . "Kommentar nicht erstellt";
            break;
        case "kll2":
            $nachricht = $nachricht . "kein Kommentar ausgewählt";
            break;
        case "kll3":
            $nachricht = $nachricht . "Kommentar gelöscht";
            break;
        case "kll4":
            $nachricht = $nachricht . "Kommentar nicht gelöscht";
            break;
        case "lsl2":
            $nachricht = $nachricht . "Lesezeichen gelöscht";
            break;
        case "lsl3":
            $nachricht = $nachricht . "Lesezeichen nicht gelöscht";
            break;

        case "lsl4":
            $nachricht = $nachricht . "Lesezeichen gesetzt";
            break;
        case "lsl5":
            $nachricht = $nachricht . "Lesezeichen nicht gesetzt";
            break;

        case "reg0":
            $nachricht = $nachricht . "Validierung-Mail konnte nicht gesendet werden";
            break;
        case "reg1":
            $nachricht = $nachricht . "registriert und angemeldet";
            break;
        case "reg2":
            $nachricht = $nachricht . "Benutzername bereits vergeben";
            break;
        case "reg3":
            $nachricht = $nachricht . "E-Mail oder Registrierungs-Link falsch";
            break;
        case "reg4":
            $nachricht = $nachricht . "Unbekannter Fehler bei Registrierung";
            break;
        case "reg5":
            $nachricht = $nachricht . "Passwörter stimmen nicht überein";
            break;
        case "anm0":
            $nachricht = $nachricht . "bereits angemeldet";
            break;
        case "neu0":
            $nachricht = $nachricht . "nicht angemeldet";
            break;
        case "profil0":
            $nachricht = $nachricht . "kein Profil ausgewählt";
            break;
        case "profil1":
            $nachricht = $nachricht . "kein Profil gefunden";
            break;
        case "pre1":
            $nachricht = $nachricht . "kein Account in Datenbank";
            break;
        case "csrf":
            $nachricht = $nachricht . "Security-Token Fehler";
    }

    ?><h3 class="body"><?php echo $nachricht ?></h3><?php
}
?>
