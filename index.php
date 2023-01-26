<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>ReiWa: Harmonie für die Seele</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>
<section>
    <h2>Momentan beliebt</h2>
    <?php include "php_import_files/dropbox-uebersicht-filtern.php" ?>
    <br>

    <div class="flexbox" id="flexbox">
        <?php include "php_import_files/uebersicht-index.php" ?>
    </div>
</section>


<br>
<?php include "php_import_files/footer.php" ?>
</body>
</html>