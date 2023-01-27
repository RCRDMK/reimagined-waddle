<?php
include "import/head.php";
include_once "logik/sqlite_dao.php";
$db = new sqlite_dao();
$eintraege = array_reverse($db->getDatenIndexUebersicht());//Daten sollen von Neu zu Alt angezeigt werden
?>
    <section class="body">
        <h1>Willkommen auf ReiWa</h1>
        <!-- Dropdown Menüs -->
        <div id="index-auswahl-einträge">
            <label hidden for="index-dropdown-sortieren">sortieren</label>
            <select class="dropdown-sortieren" id="index-dropdown-sortieren" onchange="uebersichtSortieren()">
                <option value="neu">Neu</option>
                <option value="alt">Alt</option>
                <option value="beste">Beste</option>
            </select>
            <label hidden for="index-dropdown-kategorien">kategorien</label>
            <select class="dropdown-kategorien" id="index-dropdown-kategorien" onchange="uebersichtKategorie()">
                <option value="alle">Alle</option>
                <option value="bild">Bilder</option>
                <option value="video">Videos</option>
                <option value="dokument">Dokumente</option>
            </select>
        </div>
        <!-- Übersicht der Einträge-->
        <div id="index-eintraege-uebersicht" class="ueberischt-eintraege-body">
            <?php
            foreach ($eintraege as $eintrag) {
                $titel = $eintrag["TITEL"];
                $eid = $eintrag["EID"];
                $originialName = $eintrag["ORIGINALERNAME"];
                $typ = $eintrag["TYP"];
                $lesezeichenAnzahl = $db->getLeseichenAnzahl($eid);
                $pfad = "./datenbank/upload/" . $eid . "." . substr($originialName, strrpos($originialName, '.') + 1);
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
                               href="eintrag.php?eid=<?php echo $eid ?>"><img alt="<?php echo $titel ?>"
                                                                              class="uebersicht-video-thumbnail"
                                                                              src="ressourcen/thumbnail-default.png"><?php echo $titel ?>
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