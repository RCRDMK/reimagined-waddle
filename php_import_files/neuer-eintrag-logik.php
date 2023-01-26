<?php
/*Getter:
 * neuer-eintrag-kategorie
 * neuer-eintrag-titel
 * neuer-eintrag-beschreibung
 * neuer-eintrag-tags
 * neuer-eintrag-hochladen <-File
 */

/*Kategorien:
 * text
 * bild
 * video
 * dokument
 */

/*Fehler-Codes: ?err=
 * 0: Eins der Felder ist nicht ausgefüllt
 * 1: Kategorie Text: Text fehlt
 * 2: Kategorie Bild: falsches Format
 * 3: Kategorie Video: falsches Format
 * 4: Kategorie Dokument: falsches Format
 * 5: Eintrag konnte nicht hochgeladen werden
 * 6: Eintrag konnte nicht in Datenbank hinterlegt werden
 */

/*
 * Erlaubte Formate:
 * Bild: jpg, jpeg, png, gif
 * Video: mp4, webm, ogg -> HTML Video kann nur die -> https://www.w3schools.com/html/html5_video.asp
 * Dokument: pdf
 */
session_start();
require_once('sqlite_dao.php');
//TODO: neuer-eintrag-hochladen darf leer sein, wenn Text Post
if (isset($_POST["neuer-eintrag-kategorie"]) && isset($_POST["neuer-eintrag-titel"]) && isset($_POST["neuer-eintrag-beschreibung"]) && isset($_POST["neuer-eintrag-tags"]) && isset($_FILES["neuer-eintrag-hochladen"])) {

    $kategorie = htmlspecialchars($_POST["neuer-eintrag-kategorie"]);
    $titel = htmlspecialchars($_POST["neuer-eintrag-titel"]);
    $beschreibung = htmlspecialchars($_POST["neuer-eintrag-beschreibung"]);
    $tags = htmlspecialchars($_POST["neuer-eintrag-tags"]);

    //File:
    $inhalt = $_FILES["neuer-eintrag-hochladen"];
    $type = $_FILES["neuer-eintrag-hochladen"]["type"]; //TODO: Bessere Alternative finden, scheinbar soll das nicht so sicher sein.
    $fileName = $_FILES["neuer-eintrag-hochladen"]['name'];
    $fileEndung = "." . substr($fileName, strrpos($fileName, '.') + 1);
    $fileTmpName = $_FILES["neuer-eintrag-hochladen"]["tmp_name"];
    switch ($kategorie) {//check ob file mit Kategorie übereinstimmt
        case "text":
            //TODO: Text-Eintrag erstmal ignorieren, da kein File hochgeladen wird. Man könnte, das Textfeld der Beschreibung verwenden
            // (Hochladen Button ausblenden und das Beschreibungsfeld in "Hier deinen Text eingeben" umbenennen)
            header("Location: ../neuer-eintrag.php?err=1"); //
            exit();
            break;
        case "bild":
            if (!($type == "image/png" || $type == "image/gif" || $type == "image/jpeg")) {//Check, ob kein Bild
                header("Location: ../neuer-eintrag.php?err=ne2");
                exit();
            }
            break;
        case"video":
            if (!($type == "video/ogg" || $type == "video/mp4" || $type == "video/webm")) {//Check, ob kein Video/falsches Format
                header("Location: ../neuer-eintrag.php?err=ne3");
                exit();
            }
            break;
        case"dokument":
            if ($type != "application/pdf") {//Check, ob kein PDF
                header("Location: ../neuer-eintrag.php?err=ne4");
                exit();
            }
            break;
    }
    $datenbank = new sqlite_dao();
    $eid = $datenbank->eintragErstellen($_SESSION["u_id"], $titel, $fileName, $kategorie, $beschreibung, $tags);
    if ($eid > 0) {//check ob eintrag in Datenbank angelegt wurde
        if (move_uploaded_file($fileTmpName, "../datenbank/upload/" . $eid . $fileEndung)) {
            header("Location: ../eintrag.php?e_id=" . $eid);
        } else {
            //TODO eintrag aus Datenbank löschen, wenn upload fehlschlägt
            header("Location: ../neuer-eintrag.php?err=ne5");
        }
    } else {
        header("Location: ../neuer-eintrag.php?err=ne6");
    }
} else {header("Location: ../neuer-eintrag.php?err=ne0");
}