<?php
include "import/head.php";
include_once("logik/sqlite_dao.php");
$datenbank = new sqlite_dao();

//Check, ob angemeldet
if (!isset($_SESSION["u_id"])) {
    header("Location:index.php?err=bea0");//nicht angemeldet
    exit();
} else {
    $uid = $_SESSION["u_id"];
}

//Check, ob EID übergeben
if (!isset($_POST["eintrag-bearbeiten-eid"])) {
    header("Location:index.php?err=bea1");//kein Eintrag
    exit();
} else {
    $eid = $_POST["eintrag-bearbeiten-eid"];
}

//Hole Eintrag-Daten aus Datenbank
$eintragArray = $datenbank->getEintrag($eid);

//Check, ob Erfolg
if (empty($eintragArray)) {
    header("Location:index.php?err=bea1");//kein Eintrag
    exit();
} else {
    $titel = $eintragArray["TITEL"];
    $beschreibung = $eintragArray["BESCHREIBUNG"];
    $tags = $eintragArray["TAGS"];
}

//Check, ob editieren erlaubt
if (!$datenbank->eintragEditierenErlaubnisCheck($uid, $eid)) {
    header("Location:index.php?err=bea2");//darf nicht bearbeiten
    exit();
}


?>

<!-- BODY -->
<section id="bearbeiten-body">
    <h1>Bearbeite Eintrag "<?php echo $titel ?>" </h1>

    <form action="logik/eintrag_bearbeiten_logik.php" enctype="multipart/form-data" method="post" id="bearbeiten-form">
        <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
        <label for="bearbeiten-titel">Titel (erforderlich): </label>
        <input type="text" id="bearbeiten-titel" name="bearbeiten-titel" maxlength="50" value="<?php echo $titel ?>"
               required>

        <label for="bearbeiten-beschreibung">Beschreibungstext (erforderlich): </label>
        <textarea id="bearbeiten-beschreibung" name="bearbeiten-beschreibung" cols="5" rows="5" maxlength="1500"
                  required><?php echo $beschreibung ?></textarea>

        <label for="bearbeiten-tags">Tags (erforderlich): </label>
        <input type="text" id="bearbeiten-tags" name="bearbeiten-tags" maxlength="100" value="<?php echo $tags ?>"
               required>

        <input type=hidden name="eintrag-editieren-eid" value="<?php echo $eid ?>">
        <input id="bearbeiten-submit" type="submit" value="Eintrag ändern">

    </form>

    <form action="eintrag.php?eid=<?php echo $eid ?>" method="post">
        <input id="bearbeiten-abbrechen-submit" type="submit" value="Abbrechen">
    </form>
</section>

<?php include "import/foot.php" ?>
