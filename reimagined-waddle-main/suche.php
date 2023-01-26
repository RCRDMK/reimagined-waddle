<?php

session_start();
require_once('php_import_files/sqlite_dao.php');
require_once('php_import_files/uebersicht_darstellung_logik.php');
require_once('php_import_files/uebersicht_profile_darstellung_logik.php');
$datenbank = new sqlite_dao();
if (isset($_POST["suche"])) {
    $suche = htmlspecialchars($_POST["suche"]);
    $suchErgebnisse = $datenbank->eintraegeSuchen($suche);

    $eintraege = $suchErgebnisse[0];
    $profile = $suchErgebnisse[1];
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Suche</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>
<p><?php new uebersicht_profile_darstellung_logik($profile) ?> </p>
<p><?php new uebersicht_darstellung_logik($eintraege); ?></p>
<?php include "php_import_files/footer.php" ?>
</body>
</html>
