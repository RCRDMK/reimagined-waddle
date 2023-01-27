<?php
include "import/head.php";
require_once("logik/sqlite_dao.php");
$datenbank = new sqlite_dao();
$suchString = "";
$profileArray = array();
$eintraegeArray = array();
if (isset($_POST["suche"])) {
    $suchString = htmlspecialchars($_POST["suche"]);
    $suchErgebnisseArray = $datenbank->eintraegeSuchen($suchString);
    $eintraegeArray = array_reverse($suchErgebnisseArray[0]);
    $profileArray = $suchErgebnisseArray[1];
}
?>
    <!-- BODY -->
    <section class="body">
        <h1>Suche nach "<?php echo $suchString ?>"</h1>
        <section>
            <h2>Profile:</h2>
            <div id="suche-uebersicht-profile-body">
                <?php foreach ($profileArray as $profil) { ?>
                    <div id="suche-uebersicht-profil">
                        <a href="profil.php?pid=<?php echo $profil["UID"] ?>"><?php echo $profil["NAME"] ?> </a>
                    </div>
                <?php } ?>
            </div>
        </section>
        <section>
            <h2>Einträge:</h2>
            <!-- Übericht Dropdowns -->
            <div id="suche-auswahl_einträge">
                <label hidden for="suche-dropdown-sortieren">sortieren</label>
                <select class="dropdown-sortieren" id="suche-dropdown-sortieren" onchange="uebersichtSortieren()">
                    <option value="neu">Neu</option>
                    <option value="alt">Alt</option>
                    <option value="beste">Beste</option>
                </select>
                <label hidden for="suche-dropdown-kategorien">kategorien</label>
                <select class="dropdown-kategorien" id="suche-dropdown-kategorien" onchange="uebersichtKategorie()">
                    <option value="alle">Alle</option>
                    <option value="bild">Bilder</option>
                    <option value="video">Videos</option>
                    <option value="dokument">Dokumente</option>
                </select>
            </div>
            <div id="suche-eintraege-uebersicht" class="ueberischt-eintraege-body">
                <?php
                foreach ($eintraegeArray as $eintrag) {
                    $titel = $eintrag["TITEL"];
                    $eid = $eintrag["EID"];
                    $originialName = $eintrag["ORIGINALERNAME"];
                    $typ = $eintrag["TYP"];
                    $lesezeichenAnzahl = $datenbank->getLeseichenAnzahl($eid);
                    $pfad = "./datenbank/upload/" . $eid . "." . substr($originialName, strrpos($originialName, '.') + 1);
                    ?>
                    <div class="ueberischt-eintraege-eintrag" data-typ="<?php echo $typ ?>"
                         data-eid="<?php echo $eid ?>"
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
    </section>
<?php include "import/foot.php" ?>