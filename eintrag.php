<?php
session_start();
require_once('php_import_files/sqlite_dao.php');
require_once ('php_import_files/kommentarbereich.php');
$datenbank = new sqlite_dao();

$s_uid = -1;
$angemeldet = false;
if (isset($_SESSION["u_id"])) {//Check, ob User angemeldet ist, wenn ja, speichere uid
    $s_uid = $_SESSION["u_id"];
    if ($s_uid >= 0) {
        $angemeldet = true;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Eintrag</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>

<?php
include "php_import_files/navbar-auswahl-logik.php";

if (isset($_GET["e_id"])) {//Check, ob ein Eintrag gewählt wurde
    $s_eid = $_GET["e_id"];
    $eintragDaten = $datenbank->getEintrag($s_eid); //Array mit den Daten, aus der Datenbank


    if (isset($eintragDaten["EID"])) { //Check, ob die Daten geladen wurden
        $e_eid = $eintragDaten["EID"];
        $e_titel = $eintragDaten["TITEL"];
        $e_originalerName = $eintragDaten["ORIGINALERNAME"];
        $e_typ = $eintragDaten["TYP"];
        $e_beschreibung = $eintragDaten["BESCHREIBUNG"];
        $e_tags = $eintragDaten["TAGS"];
        $e_datum = $eintragDaten["DATUM"];
        $e_uid = $eintragDaten["UID"];

        //Der Pfad zum Inhalt der Datei. Mittels substr() wird die Dateiendung ermittelt, da mit verschiedenen Dateitypen gearbeitet wird:
        $pfad = "./datenbank/upload/" . $e_eid . "." . substr($e_originalerName, strrpos($e_originalerName, '.') + 1);

        ?>
        <section>

            <div class="grid-eintrag">
                <!-- Schaltet die benötigten Buttons frei -->
                <?php if ($angemeldet) {//Check, ob User angemeldet
                if ($s_uid == $e_uid) { ?><!-- Check, ob Eintrag User gehört -->
                <form id="eintrag-bearbeiten-button" action="eintrag-editieren.php"
                      method="post" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" value="<?php echo $e_eid ?>" name="eintrag-bearbeiten-eid">
                        <input type="submit" value="Bearbeiten">
                    </div>
                </form>
                <form id="eintrag-loeschen-button"
                      action="./php_import_files/eintrag-loeschen-logik.php"
                      method="post">
                    <div>
                        <input type="hidden" value="<?php echo $e_eid ?>" name="eintrag-loeschen-eid">
                        <input type="submit" value="Löschen">
                    </div>
                </form>
                <?php
                }
                if ($datenbank->isLesezeichenGesetzt($s_uid, $s_eid)) {//Check, ob lesezeichen gesetzt ist und platziert den passenden Button
                ?><!-- Wenn gesetzt, dann verwende Lösch-Button -->
                <form id="eintrag-lesezeichen-entfernen-button"
                      action="php_import_files/eintrag-lesezeichen-entfernen-logik.php"
                      method="post">
                    <div>
                        <input type="hidden" value="<?php echo $e_eid ?>" name="lesezeichen-loeschen-eid">
                        <input type="submit" value="Lesezeichen löschen">
                    </div>
                </form>
                <?php
                } else { ?>
                    <form id="eintrag-lesezeichen-setzen-button"
                          action="php_import_files/eintrag-lesezeichen-setzen-logik.php"
                          method="post">
                        <div>
                            <input type="hidden" value="<?php echo $e_eid ?>" name="lesezeichen-setzen-eid">
                            <input type="submit" value="Lesezeichen setzen">
                        </div>
                    </form>
                    <?php
                }
                } ?>
                <h2><?php echo $e_titel ?></h2>
                <?php
                switch ($e_typ) {//check ob file mit Kategorie übereinstimmt
                    case "text":
                        //TODO: TEXT darstellen
                        break;
                    case "bild":
                        ?>
                        <img src="<?php echo $pfad ?>" alt="<?php echo $e_titel ?>">
                        <?php
                        break;
                    case"video":
                        ?>
                        <video>
                            <source src="<?php echo $pfad ?>" type="video/webm">
                            <source src="<?php echo $pfad ?>" type="video/mp4">
                            <source src="<?php echo $pfad ?>" type="video/ogg">
                            <!-- https://www.w3schools.com/html/html5_video.asp -->
                        </video>
                        <?php
                        break;
                    case"dokument":
                        ?>

                        <iframe src="<?php echo $pfad ?>#toolbar=0"
                                title="<?php echo $e_titel ?>"></iframe>
                        <?php
                        break;
                } ?>
                <span>
                    <a class="profil-link"
                       href="profil.php?id=<?php echo $e_uid ?>"> <?php echo $datenbank->getAccountName($e_uid) ?></a>
                </span>
                <span>
                    <?php echo $e_datum ?>
                </span>
                <div><?php echo $e_beschreibung ?></div>
                <div><?php echo $e_tags ?></div>
            </div>
        </section>
        <!--Kommentar-Sektion-->
        <section>
            <?php
            if ($angemeldet) {//neuer Kommentar
                ?>
                <div id="neuer-kommentar">
                    <form action="php_import_files/kommentar-verfassen-logik.php" method="post">
                        <label for="neuer-kommentar">Neuen Kommentar verfassen: </label><br>
                        <textarea name="eintrag-neuer-kommentar-text" cols="5" rows="5" maxlength="1500"  aria-labelledby="neuer-kommentar"
                                  placeholder="Hast du Gedanken über dieses Werk?" required></textarea>
                        <input type="hidden" value="<?php echo $e_eid?>" name="eintrag-neuer-kommentar-eid">
                        <input type="submit" value="Kommentar veröffentlichen">
                    </form>
                </div>
                <?php
            }
            ?>
            <select id="kommentare_sortieren" class="dropdown">
                <option>Neu</option>
                <option>Älteste</option>
            </select>
            <div id="kommentarbereich">
                <?php new kommentarbereich($e_eid)?>
            </div>
            <br>

        </section>

        <?php
    }
}
include "php_import_files/footer.php" ?>
</body>
</html>
