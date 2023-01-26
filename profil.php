<?php
session_start();
require_once "php_import_files/sqlite_dao.php";

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Profil</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>
<?php include "checks/anmeldungscheck.php" ?>

<?php include "php_import_files/uebersicht-profil.php"?>

<?php include "php_import_files/footer.php" ?>
</body>
</html>