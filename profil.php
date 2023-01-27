<?php
include "import/head.php";

include_once "logik/sqlite_dao.php";
$datenbank = new sqlite_dao();

$eintraegeArray = array();

$angemeldet = false;

//Check, ob angemeldet
if (!empty($_SESSION["u_id"])) {
    $angemeldet = true;
}

//Anzeige Auswahl - eigenes oder fremdes Profil
if (isset($_GET["pid"])) {//Wenn pid vorhanden, dann check, ob eigenes Profil oder nicht
    $pid = $_GET["pid"];
    $pName = $datenbank->getAccountName($pid);
    if ($angemeldet && $pid == $_SESSION["u_id"]) {
        $eigenesProfiL = true;
    } else {
        $eigenesProfiL = false;
    }
} else {
    if ($angemeldet) {//wenn keine pid, dann check, ob angemeldet oder nicht
        $eigenesProfiL = true;
        $pid = $_SESSION["u_id"];
        $pName = $datenbank->getAccountName($pid);
    } else {
        header("Location: index.php?err=profil0");
        exit();
    }
}

if ($pName === "") {//wenn kein Name aus der Datenbank geladen wurde, dann Fehler, da Profil nicht vorhanden
    header("Location: index.php?err=profil1");
    exit();
}

//Check, ob Lesezeichen angezeigt werden sollen
if ($angemeldet) {
    if (isset($_POST["lesezeichenAnzeigen"])) {
        $_SESSION["lesezeichenAnzeigen"] = $_POST["lesezeichenAnzeigen"];
        $lesezeichenAnzeigen = $_POST["lesezeichenAnzeigen"];
    } else $lesezeichenAnzeigen = $_SESSION["lesezeichenAnzeigen"] ?? false;
}

//Hole Daten aus Datenbank
if ($angemeldet && $lesezeichenAnzeigen && $eigenesProfiL) {
    $eintraegeArray = array_reverse($datenbank->getDatenLesezeichenUebersicht($pid));//Daten sollen von Neu zu Alt angezeigt werden, in Datenbank von Alt nach Neu, daher reverse
} else {
    $eintraegeArray = array_reverse($datenbank->getDatenProfilUebersicht($pid));//Daten sollen von Neu zu Alt angezeigt werden
}
?>

    <section class="body">
        <!-- Eigenes Profil -->
        <?php if ($eigenesProfiL) { ?>
            <h1>Willkommen auf deinem Profil "<?php echo $pName ?>"</h1>
            <!-- Profil-Funktionsbuttons -->
            <div id="profil-buttons">

                <form class="profil-button" action="eintrag_neu.php">
                    <input type="submit" value="Neuer Eintrag">
                </form>

                <form class="profil-button" action="profil_einstellungen.php">
                    <input type="submit" value="Einstellungen">
                </form>

                <!-- Lesezeichen/Profil Button auswahl-->
                <?php if ($lesezeichenAnzeigen) { ?>
                    <form class="profil-button" action="profil.php?pid=<?php echo $pid ?>" enctype="multipart/form-data" method="post">
                        <div id="<?php echo $lesezeichenAnzeigen ?>"></div>
                        <input type="hidden" name="lesezeichenAnzeigen" value=0>
                        <input type="submit" value="Eigene Einträge">
                    </form>
                <?php } else { ?>
                    <form class="profil-button" action="profil.php?pid=<?php echo $pid ?>" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="lesezeichenAnzeigen" value=1>
                        <input type="submit" value="Lesezeichen">
                    </form>

                <?php } ?>
            </div>

            <!-- Anzeige, ob Eintrag oder Lesezeichen -->
            <div id="profil-eintrag-lesezeichen-ueberschrift">
                <?php if ($lesezeichenAnzeigen) { ?>
                    <h2>Lesezeichen:</h2>
                <?php } else { ?>
                    <h2>Eigene Einträge:</h2>
                <?php } ?>
            </div>

        <?php } else { ?>
            <!-- Fremdes Profil-->
            <h1>Willkommen auf dem Profil von "<?php echo $pName ?>"</h1>
        <?php } ?>

        <!-- Übericht Dropdowns -->
        <div id="profil-auswahl_einträge">
            <label hidden for="profil-dropdown-sortieren">sortieren</label>
            <select class="dropdown-sortieren" id="profil-dropdown-sortieren" onchange="uebersichtSortieren()">
                <option value="neu">Neu</option>
                <option value="alt">Alt</option>
                <option value="beste">Beste</option>
            </select>
            <label hidden for="profil-dropdown-kategorien">kategorien</label>
            <select class="dropdown-kategorien" id="profil-dropdown-kategorien" onchange="uebersichtKategorie()">
                <option value="alle">Alle</option>
                <option value="bild">Bilder</option>
                <option value="video">Videos</option>
                <option value="dokument">Dokumente</option>
            </select>
        </div>

        <!-- Übersicht-->
        <div id="profil-eintraege-uebersicht" class="ueberischt-eintraege-body">
            <?php
            foreach ($eintraegeArray as $eintrag) {
                $titel = $eintrag["TITEL"];
                $eid = $eintrag["EID"];
                $originalerName = $eintrag["ORIGINALERNAME"];
                $typ = $eintrag["TYP"];
                $lesezeichenAnzahl = $datenbank->getLeseichenAnzahl($eid);
                $pfad = "./datenbank/upload/" . $eid . "." . substr($originalerName, strrpos($originalerName, '.') + 1);
                ?>
                <div class="ueberischt-eintraege-eintrag" data-typ="<?php echo $typ ?>" data-eid="<?php echo $eid ?>"
                     data-lea="<?php echo $lesezeichenAnzahl ?>">
                    <?php
                    switch ($typ) {//check ob file mit Kategorie übereinstimmt
                        case "bild":
                            ?>
                            <a href="eintrag.php?eid=<?php echo $eid ?>"><img
                                        class="uebersicht-bild"
                                        src="<?php echo $pfad ?>"
                                        alt="<?php echo $titel ?>"></a>
                            <?php
                            break;
                        case"video":
                            ?>
                            <a class="uebersicht-video-link"
                               href="eintrag.php?eid=<?php echo $eid ?>"><img alt="<?php echo $titel ?>" class="uebersicht-video-thumbnail" src="ressourcen/thumbnail-default.png"><?php echo $titel ?>
                                (Video)</a>
                            <?php
                            break;
                        case"dokument":
                            ?>
                            <div>
                                <iframe class="uebersicht-dokument" src="<?php echo $pfad ?>#toolbar=0"></iframe>
                            </div>
                            <div>
                                <a class="uebersicht-dokument-link"
                                   href="eintrag.php?eid=<?php echo $eid ?>"><?php echo $titel ?> (Dokument)</a>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
<?php include "import/foot.php" ?>