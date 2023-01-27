<?php
include "import/head.php";

include_once "logik/sqlite_dao.php";
$datenbank = new sqlite_dao();

$angemeldet = false;
$eigenerEintrag = false;
$eintragArray = array();

//Check, ob angemeldet
if (isset($_SESSION["u_id"]) && $_SESSION["u_id"] >= 0) {
    $angemeldet = true;
}

//Hole Daten aus Datenbank; Check, ob "eigener Eintrag"; Check, ob Lesezeichen gesetzt
if (isset($_GET["eid"])) {
    $eintragArray = $datenbank->getEintrag($_GET["eid"]);

    //Check, ob Eintrag in Datenbank
    if (!empty($eintragArray)) {
        $e_eid = $eintragArray["EID"];
        $e_titel = $eintragArray["TITEL"];
        $e_originalername = $eintragArray["ORIGINALERNAME"];
        $e_typ = $eintragArray["TYP"];
        $e_beschreibung = $eintragArray["BESCHREIBUNG"];
        $e_tags = $eintragArray["TAGS"];
        $e_datum = $eintragArray["DATUM"];
        $e_uid = $eintragArray["UID"];

        $e_erstellerName = $datenbank->getAccountName($e_uid);//Name des Erstellers
        $e_lesezeichenAnzahl = $datenbank->getLeseichenAnzahl($e_eid);//Anzahl der Lesezeichen

        //Der Pfad zum Inhalt der Datei. Mittels substr() wird die Dateiendung ermittelt, da mit verschiedenen Dateitypen gearbeitet wird:
        $e_pfad = "./datenbank/upload/" . $e_eid . "." . substr($e_originalername, strrpos($e_originalername, '.') + 1);

        $kommentareArray = $datenbank->kommentareVonEintrag($e_eid);//Die einzelnen Kommentare

        //Elemente für angemeldete User:
        if ($angemeldet) {
            //Check, ob eigener Eintrag
            if ($_SESSION["u_id"] == $e_uid) {
                $eigenerEintrag = true;
            }

            //Check, ob Lesezeichen gesetzt und erstelle den Namen für den Lesezeichenbutton
            if ($datenbank->isLesezeichenGesetzt($_SESSION["u_id"], $e_eid)) {
                $lesezeichenButtonName = "Lesezeichen löschen";
            } else {
                $lesezeichenButtonName = "Lesezeichen setzen";
            }
        }
    } else {
        header("Location: index.php?err=eintrag0");//kein Eintrag
        exit();
    }
} else {
    header("Location: index.php?err=eintrag0");//kein Eintrag
    exit();
}
?>

    <!-- BODY -->
    <section id="eintrag-body">
        <h1><?php echo $e_titel ?></h1>
        <section id="eintrag-section">
            <h2 hidden>Eintrag</h2>
            <!-- Interaktion mit Eintrag Buttons -->
            <?php if ($angemeldet) { ?>
                <div id="eintrag-buttons">

                    <!-- Lesezeichen -->
                    <form class="eintrag-logik-button" action="logik/lesezeichen_logik.php" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
                        <input type="hidden" value="<?php echo $e_eid ?>" name="lesezeichen-eid">
                        <input type="submit" value="<?php echo $lesezeichenButtonName ?>">
                    </form>

                    <?php if ($eigenerEintrag) { ?>
                        <!-- Bearbeiten -->
                        <form class="eintrag-logik-button" action="eintrag_bearbeiten.php" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
                            <input type="hidden" value="<?php echo $e_eid ?>" name="eintrag-bearbeiten-eid">
                            <input type="submit" value="Eintrag bearbeiten">
                        </form>

                        <!-- Löschen -->
                        <form class="eintrag-logik-button" action="logik/eintrag_loeschen_logik.php" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
                            <input type="hidden" value="<?php echo $e_eid ?>" name="eintrag-loeschen-eid">
                            <input id="eintrag-loeschen-button" type="submit" value="Eintrag löschen">
                        </form>
                    <?php } ?>

                </div>
            <?php } ?>

            <!-- Inhalt -->
            <?php
            switch ($e_typ) {//check ob file mit Kategorie übereinstimmt
                case "bild":
                    ?>
                    <img class="eintrag-inhalt" id="eintrag-bild" src="<?php echo $e_pfad ?>"
                         alt="<?php echo $e_titel ?>">
                    <?php
                    break;
                case"video":
                    ?>
                    <video class="eintrag-inhalt" id="eintrag-video" controls>
                        <source src="<?php echo $e_pfad ?>" type="video/webm">
                        <source src="<?php echo $e_pfad ?>" type="video/mp4">
                        <source src="<?php echo $e_pfad ?>" type="video/ogg">
                        <!-- https://www.w3schools.com/html/html5_video.asp -->
                    </video>
                    <?php
                    break;
                case"dokument":
                    ?>

                    <iframe class="eintrag-inhalt" id="eintrag-dokument" src="<?php echo $e_pfad ?>#toolbar=1"
                            title="<?php echo $e_titel ?>"></iframe>
                    <?php
                    break;
            } ?>
            <!-- Eintrag Information -->
            <div id="eintrag-informationen">
                <span id="eintrag-profil-ersteller" title="Der Ersteller">
                    <a id="eintrag-profil-ersteller-link"
                       href="profil.php?pid=<?php echo $e_uid ?>"><?php echo $e_erstellerName ?></a>
                </span>
                <span id="eintrag-lesezeichen-anzahl" title="Anzahl von gesetzten Lesezeichen">
                    <?php echo $e_lesezeichenAnzahl ?>
                </span>
                <span id="eintrag-datum" title="Hochgeladen am">
                    <?php echo $e_datum ?>
                </span>
            </div>
            <!-- Beschreibung-->
            Beschreibung:
            <div id="eintrag-beschreibung">
                <?php echo $e_beschreibung ?>
            </div>
            <!-- Tags -->
            Tags:
            <div id="eintrag-tags">
                <?php echo $e_tags ?>
            </div>
        </section>

        <!-- Kommentarbereich -->
        <section id="kommentarbereich-section">
            <h2 hidden>Kommentarbereich</h2>
            <!-- Kommentar erstellen -->
            <?php if ($angemeldet) { ?>

                <label id="kommentar-erstellen-text-label" for="kommentar-erstellen-text">Dein Kommentar</label>
                <form action="logik/kommentar_erstellen_logik.php" enctype="multipart/form-data" method="post">

                    <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">

                    <textarea id="kommentar-erstellen-text" name="kommentar-erstellen-text" rows="5"
                              maxlength="1500" placeholder="Teile deine Meinung mit" required></textarea>

                    <label hidden for="kommentar-erstellen-eid">Eintrag Id</label>
                    <input hidden value="<?php echo $e_eid ?>" id="kommentar-erstellen-eid"
                           name="kommentar-erstellen-eid">

                    <input id="kommentar-erstellen-submit" type="submit" value="Kommentar veröffentlichen">
                </form>
            <?php } ?>

            <!-- Dropdown Sortieren -->
            <label hidden for="kommentare-sortieren">Kommentar Dropdown</label>
            <select id="kommentare-sortieren" class="dropdown" onchange="kommentareSortieren()">
                <option>Alte Kommentare</option>
                <option>Neue Kommentare</option>
            </select>

            <!-- Generierung der Anzeige für die Kommentare -->
            <div id="kommentarbereich" class="kommentarbereich">
                <?php
                foreach ($kommentareArray as $key) {
                    $k_kid = $key["KID"];
                    $k_text = $key["KOMMENTARTEXT"];
                    $k_datum = $key["DATUM"];
                    $k_uid = $key["UID"];
                    $k_username = $key["NAME"];
                    ?>
                    <div class="kommentar">
                        <div class="kommentar-inhalt">
                            <div class="kommentar-ersteller-name">
                                <a class="kommentar-ersteller-name-link"
                                   href="profil.php?pid=<?php echo $k_uid ?>"> <?php echo $k_username ?></a>
                            </div>
                            <div class="kommentar-text"><?php echo $k_text ?></div>
                            <div class="kommentar-datum"><?php echo $k_datum ?></div>
                        </div>

                        <?php if (isset($_SESSION["u_id"]) && $_SESSION["u_id"] == $k_uid) { ?>
                                <form action="logik/kommentar_loeschen_logik.php"
                                      method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
                                    <input type="hidden" value="<?php echo $e_eid ?>" name="kommentar-loeschen-eid">
                                    <input type="hidden" value="<?php echo $k_kid ?>" name="kommentar-loeschen-kid">
                                    <input class="kommentar-loeschen-button" type="submit" value="Löschen">
                                </form>
                        <?php } ?>
                    </div>
                    <?php
                } ?>
            </div>
        </section>
    </section>
<?php include "import/foot.php" ?>