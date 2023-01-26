<?php
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();
if (isset($_POST["kommentar-loeschen-eid"])) {
    $eid = $_POST["kommentar-loeschen-eid"];
    if (isset($_POST["kommentar-loeschen-kid"])) {
        $kid = $_POST["kommentar-loeschen-kid"];
        if ($datenbank->kommentarLoeschen($kid)) {
            header("Location:../eintrag.php?e_id=$eid");
            exit();
        } else {
            header("Location:../eintrag.php?e_id=$eid&err=");//TODO: FehlerCode: Kommentar nich gelöscht
            exit();
        }
    } else {
        header("Location:../eintrag.php?e_id=$eid&err=");//TODO: FehlerCode: kid fehlt
        exit();
    }
} else {
    header("Location:../index.php?&err=");//TODO: FehlerCode: eid fehlt
    exit();
}
