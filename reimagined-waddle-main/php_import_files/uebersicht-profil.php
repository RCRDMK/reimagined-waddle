<?php
$datenbank = new sqlite_dao();
require_once('sqlite_dao.php');
require_once('uebersicht_darstellung_logik.php');

$profilID = 0;
$getterExistiert = false;
$angemeldet = false;
$eigenesProfil = false;
$lesezeichenAnzeigen = false;

if (isset($_GET["id"])) {//Check, ob die Profil-ID über die URL übergeben wurde
    $getterExistiert = true;
}
if (isset($_SESSION["u_id"])) {//Check, ob angemeldet
    $angemeldet = true;
}
if (isset($_SESSION["lesezeichenAnzeigen"])) {//Check, ob angemeldet
    $lesezeichenAnzeigen = $_SESSION["lesezeichenAnzeigen"];

}

//Abfangen von Fehlern bei der Auswahl der Anzeige des Profils:
if (!$getterExistiert && !$angemeldet) { //sollten weder get noch session existieren, kann kein Profil gefunden werden
    header("Location: index.php?err=index9");
} elseif (!$getterExistiert && $angemeldet) {//wenn nur session existiert, wird die eigene id verwendet
    $profilID = $_SESSION["u_id"];
} else {//die getter id wird zum Finden des Profils verwendet
    $profilID = $_GET["id"];
}

$accountname = $datenbank->getAccountName($profilID);

//Unterscheidung zwischen Fremd- und Eigenprofil:
if ($angemeldet && $profilID == $_SESSION["u_id"]) {//eigenes Profil:
    ?>
    <h1>Willkommen auf deinem Profil <?php echo $accountname ?></h1>
    <div class="flex-profil">
        <form action="profil-einstellungen.php">
            <button type="submit">Einstellungen</button>
        </form>


        <?php
        if ($lesezeichenAnzeigen) {//Wählt aus, welche Wert übergeben werden, soll beim wechsel Lesezeichen-EigeneEinträge
            $buttonLesezeichen = "Profil";
        } else {
            $buttonLesezeichen = "Lesezeichen";
        }
        ?>
        <!-- Der Button für den Wechsel zwischen Lesezeichen und eigenen Einträgen-->
        <form action="php_import_files/profil_lesezeichen_logik.php" enctype="multipart/form-data" method="post">
            <input type="hidden" value="<?php echo $profilID ?>" name="profil-eid">
            <input type="hidden" value="<?php echo $buttonLesezeichen ?>" name="profil-lesezeichen">
            <button type="submit"><?php echo $buttonLesezeichen ?></button>
        </form>


        <form action="neuer-eintrag.php">
            <button type="submit">Neuen Eintrag</button>
        </form>
    </div>
    <?php
} else {//Fremdes Profil wird angezeigt
    ?>
    <h1>Willkommen auf dem Profil von <?php echo $accountname ?></h1>
    <?php
}

//Die Übersicht:
include "php_import_files/dropbox-uebersicht-filtern.php";

if ($lesezeichenAnzeigen && $angemeldet) {//Zeigt die Lesezeichen
    ?>
    <h2>Lesezeichen von dir:</h2>
    <?php
    $daten = $datenbank->getDatenLesezeichenUebersicht($profilID);
} else {
    ?>
    <h2>Einträge von <?php echo $accountname?>:</h2>
    <?php
    $daten = $datenbank->getDatenProfilUebersicht($profilID);
}
new uebersicht_darstellung_logik($daten);//Die Darstellung der einzelnen Inhalte
