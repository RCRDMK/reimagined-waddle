<?php

/**
 * URL-Getter:
 *  e_id
 *
 * submit-button::
 *  eintrag-editieren-titel
 *  eintrag-editieren-beschreibung
 *  eintrag-editieren-tags
 *  eintrag-editieren-eids
 *
 */

session_start();
require_once('php_import_files/sqlite_dao.php');
$datenbank = new sqlite_dao();
if (!empty($_SESSION["u_id"]) && $_SESSION["u_id"] < 0) {
    header("Location:index.php?err=ee8");
}
if (!isset($_POST["eintrag-bearbeiten-eid"])) {
    header("Location:index.php?err=ee7");
}


$eid = $_POST["eintrag-bearbeiten-eid"];
$uid = $_SESSION["u_id"];

if (!$datenbank->eintragEditierenErlaubnisCheck($uid, $eid)) {
    header("Location:index.php?err=ee6");
}
$eintragDaten = $datenbank->getEintrag($eid);
$titel = $eintragDaten["TITEL"];
$beschreibung = $eintragDaten["BESCHREIBUNG"];
$tags = $eintragDaten["TAGS"];
?>



<?php ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Eintrag bearbeiten</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>

<form action="php_import_files/eintrag-editieren-logik.php" method="post" enctype="multipart/form-data">>

    <div>
        <label for="titel">Titel: </label>
        <input type="text" id="titel" name="eintrag-editieren-titel" maxlength="50" value="<?php echo $titel ?>"
               required>
    </div>

    <div>
        <label for="beschreibung">Beschreibungstext: </label><br>
        <textarea id="beschreibung" name="eintrag-editieren-beschreibung" cols="5" rows="5" maxlength="1500"
                  required><?php echo $beschreibung ?></textarea>
    </div>

    <div>
        <label for="tags">Tags: </label>
        <input type="text" id="tags" name="eintrag-editieren-tags" maxlength="100" value="<?php echo $tags ?>"
               required>
    </div>

    <div>

        <input type=hidden name="eintrag-editieren-eid" value="<?php echo $eid?>">
        <input type="submit" value="Eintrag ändern">
    </div>
</form>
<form action="eintrag.php?e_id=<?php echo $eid?>" method="post" >
    <div>
        <input type="submit" value="Abbrechen">
    </div>
</form>
<?php include "php_import_files/footer.php" ?>
</body>
</html>