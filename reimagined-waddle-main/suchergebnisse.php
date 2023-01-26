<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Suchergebnisse</title>
    <?php include "php_import_files/head.php" ?>
    </head>
    <body>
    <?php include "php_import_files/navbar-auswahl-logik.php" ?>
    <h2>Suchergebnisse für "Memes"</h2>
    <a class="suchergebnisse" href="eintrag.php">Haha! Was ist das? #Memes</a><img class="fleximage" src="images/HTML++.jpg" alt="HTML PHP Meme">
    <a class="suchergebnisse" href="eintrag.php">LOL Ich liebe Memes!</a><img class="fleximage" src="images/Tables.jpg" alt="Tables als Layout">
    <a class="suchergebnisse" href="eintrag.php">Was für ein wahres Meme</a><img class="fleximage" src="images/Tags.jpg" alt="Tags everywhere">
    <?php include "php_import_files/footer.php" ?>    
</body>
</html>