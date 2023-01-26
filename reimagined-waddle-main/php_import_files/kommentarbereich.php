<?php

class kommentarbereich
{
    /**
     * erstellt den Kommentarbereich.
     * Verwendet die e-id
     *
     * @param int $eid
     */
    public function __construct(int $eid)
    {
        $datenbank = new sqlite_dao();
        $kommentare = $datenbank->kommentareVonEintrag($eid);
        foreach ($kommentare as $key) {
            $k_kid = $key["KID"];
            $k_text = $key["KOMMENTARTEXT"];
            $k_datum = $key["DATUM"];
            $k_uid = $key["UID"];
            $k_username = $key["USERNAME"];
            ?>
            <div class="kommentar">

                <div id="kommentarersteller">
                    <a href="profil.php?id=<?php echo $k_uid ?>"> <?php echo $k_username ?></a>
                </div>
                <div id="kommentartext"><?php echo $k_text ?></div>
                <div id="kommentardatum"><?php echo $k_datum ?></div>
            </div>
            <?php
            if (isset($_SESSION["u_id"]) && $_SESSION["u_id"] == $k_uid) {
                //TODO: Button zum Bearbeiten
                ?>
                <form id="kommentar-löschen-button" action="php_import_files/kommentar-loeschen-logik.php"
                      method="post" enctype="multipart/form-data">
                <div>
                    <input type="hidden" value="<?php echo $eid ?>" name="kommentar-loeschen-eid">
                    <input type="hidden" value="<?php echo $k_kid ?>" name="kommentar-loeschen-kid">
                    <input type="submit" value="Löschen">
                </div>
                <?php
            }
        }
    }


}