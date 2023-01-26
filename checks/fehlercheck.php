<!--Fehler-Codes: ?err=
 * 0: Eins der Felder ist nicht ausgefüllt
 * 1: Kategorie Text: Text fehlt
 * 2: Kategorie Bild: falsches Format
 * 3: Kategorie Video: falsches Format
 * 4: Kategorie Dokument: falsches Format
 * 5: Eintrag konnte nicht hochgeladen werden
 * 6: Eintrag konnte nicht in Datenbank hinterlegt werden
 * 7: Eintrag konnte nicht gefunden werden
 * 8: User konnte nicht gefunden werden
 * 9: Sonstige Fehler, die in der echo Anweisung beschrieben werden
-->

<?php

if (isset($_GET["err"])){
    $errorCode = $_GET["err"];
    switch ($errorCode) {
        case "login0":
            echo "<h4>Falsche Email-Adresse und/oder Passwort! Bitte überprüfe deine Eingaben noch einmal</h4>";
            break;
        case "registrieren0":
            echo "<h4>Die Passwörter stimmen nicht überein! Bitte gib sie erneut ein</h4>";
            break;
        case "registrieren1":
            echo "<h4>Diese E-Mail Adresse ist schon vergeben. Bitte benutze eine andere</h4>";
            break;
        case "registrieren2":
            echo "<h4>Dieser Benutzername ist schon vergeben. Bitte benutze einen anderen</h4>";
            break;
        case "registrieren3":
            echo "<h4>Ein unbekannter Fehler ist aufgetreten</h4>";
            break;
        case "ne0":
            echo "<h4>Bitte stelle sicher, dass alle Felder ausgefüllt sind</h4>";
            break;
        case "ne2":
            echo "<h4>Falsches Format! Für Bilder sind nur die Formate .jpg, .jpeg, .png und .gif</h4>";
            break;
        case "ne3":
            echo "<h4>Falsches Format! Für Video sind nur die Formate .mp4, .webm und .ogg</h4>";
            break;
        case "ne4":
            echo "<h4>Falsches Format! Dokumente können nur als .pdf hochgeladen werden</h4>";
            break;
        case "ne5":
            echo "<h4>Eintrag konnte nicht erstellt werden</h4>";
            break;
        case "ne6":
            echo "<h4>Eintrag konnte nicht gespeichert werden</h4>";
            break;
        case "ee6":
            echo "<h4>Du hast nicht die Rechte, diesen Eintrag zu bearbeiten</h4>";
            break;
        case "ee7":
            echo "<h4>Der Eintrag konnte nicht gefunden werden</h4>";
            break;
        case "ee8":
            echo "<h4>Dieses Profil konnte nicht gefunden werden</h4>";
            break;
        case "ee9":
            echo "<h4>Der Eintrag konnte nicht aktualisiert werden. Bitte versuche es noch einmal!</h4>";
            break;
         case "lz6":
            echo "<h4>Eintrag konnte nicht als Lesezeichen gespeichert werden</h4>";
            break;
        case "lz7":
            echo "<h4>Fehler! Eintrag existiert nicht!</h4>";
            break;
        case "lz8":
            echo "<h4>Fehler! Profil existiert nicht!</h4>";
            break;
         case "lz9":
            echo "<h4>Das Lesezeichen konnte nicht entfernt werden</h4>";
            break;
        case "profil-lz9":
            echo "<h4>Es ist ein unbekannter Fehler aufgetreten. Bitte lade die Seite neu!</h4>";
            break;
         case "index9":
            echo "<h4>Das Profil konnte nicht gefunden werden</h4>";
            break;
    }
}
?>