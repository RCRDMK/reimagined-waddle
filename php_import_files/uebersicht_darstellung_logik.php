<?php

class uebersicht_darstellung_logik
{
    /**
     * Index und Profil verwenden den gleichen Code, nur unterschiedliche Datensätze.
     * Daher wird die Darstellung hierhin ausgelagert.
     *
     * @param $datenAusDatenbank array
     */
    public function __construct(array $datenAusDatenbank)
    {
        foreach ($datenAusDatenbank as $key => $eintrag) {
            $titel = $eintrag["TITEL"];
            $eid = $eintrag["EID"];
            $originialName = $eintrag["ORIGINALERNAME"];
            $typ = $eintrag["TYP"];
            $pfad = "./datenbank/upload/" . $eid . "." . substr($originialName, strrpos($originialName, '.') + 1);
            ?>
            <?php
            switch ($typ) {//check ob file mit Kategorie übereinstimmt
                case "text":
                    //TODO: TEXT darstellen
                    break;
                case "bild":
                    ?>
                    <div class="flexitem"><a href="eintrag.php?e_id=<?php echo $eid ?>"><img class="fleximage"
                                                                                             src="<?php echo $pfad ?>"
                                                                                             alt="<?php echo $titel ?>"></a>
                    </div>
                    <?php
                    break;
                case"video":
                    //TODO: Preview Bild generieren
                    ?>
                    <div class="flexitem">
                        <a class="eintrag-link" href="eintrag.php?e_id=<?php echo $eid ?>">Zum Video</a>
                    </div>
                    <?php
                    break;
                case"dokument":
                    ?>
                    <div class="flexitem">
                        <div>
                            <iframe src="<?php echo $pfad ?>#toolbar=0"></iframe>
                        </div>
                        <div>
                            <a class="eintrag-link" href="eintrag.php?e_id=<?php echo $eid ?>">Zum Dokument</a>
                        </div>
                    </div>
                    <?php
                    break;
            }
        }
    }
}