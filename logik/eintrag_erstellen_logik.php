<?php
session_start();
require_once('sqlite_dao.php');
$datenbank = new sqlite_dao();

//Check, ob angemeldet und setze uid
if (isset($_SESSION["u_id"])) {
    $uid = htmlspecialchars($_SESSION["u_id"]);
} else {//nicht angemeldet
    header("Location: ../index.php?err=enl7");
    exit();
}

//CSRF Token gesetzt
if (!isset($_POST["csrf"]) || $_POST["csrf"] != $_SESSION["csrf"]) {
    header("Location:../index.php?err=csrf");
    exit();
}

//Check, ob alle nötigen Informationen da sind
if (isset($_POST["neu-kategorie"]) && isset($_POST["neu-titel"]) && isset($_POST["neu-beschreibung"]) && isset($_POST["neu-tags"]) && isset($_FILES["neu-hochladen"])) {

    $kategorie = htmlspecialchars($_POST["neu-kategorie"]);
    $titel = htmlspecialchars($_POST["neu-titel"]);
    $beschreibung = htmlspecialchars($_POST["neu-beschreibung"]);
    $tags = htmlspecialchars($_POST["neu-tags"]);

    //File:
    $inhalt = $_FILES["neu-hochladen"];
    $type = $_FILES["neu-hochladen"]["type"];
    $fileName = $_FILES["neu-hochladen"]['name'];
    $fileEndung = "." . substr($fileName, strrpos($fileName, '.') + 1);
    $fileTmpName = $_FILES["neu-hochladen"]["tmp_name"];

    //check, ob file mit Kategorie übereinstimmt
    switch ($kategorie) {
        //break;
        case "bild":
            if (!($type == "image/png" || $type == "image/gif" || $type == "image/jpeg")) {//Check, ob kein Bild
                header("Location: ../eintrag_neu.php?err=enl2");
                exit();
            }
            break;
        case"video":
            if (!($type == "video/ogg" || $type == "video/mp4" || $type == "video/webm")) {//Check, ob kein Video/falsches Format
                header("Location: ../eintrag_neu.php?err=enl3");
                exit();
            }
            break;
        case"dokument":
            if ($type != "application/pdf") {//Check, ob kein PDF
                header("Location: ../eintrag_neu.php?err=enl4");
                exit();
            }
            break;
    }

    //Erstelle Eintrag in Datenbank
    $eid = $datenbank->eintragErstellen($uid, $titel, $fileName, $kategorie, $beschreibung, $tags);

    //Kopiere Datei in upload-Ordner
    if ($eid > 0) {//check, ob eintrag in Datenbank angelegt wurde
        if (move_uploaded_file($fileTmpName, "../datenbank/upload/" . $eid . $fileEndung)) {
            header("Location: ../eintrag.php?eid=" . $eid);
            exit();
        } else {//move nicht erfolgt
            $datenbank->eintragLoeschen($uid, $eid);
            header("Location: ../eintrag_neu.php?err=enl5");
            exit();
        }
    } else {//Eintrag nicht erstellt
        header("Location: ../eintrag_neu.php?err=enl6");
        exit();
    }
} else {//POST Daten fehlen
    header("Location: ../eintrag_neu.php?err=enl0");
    exit();
}