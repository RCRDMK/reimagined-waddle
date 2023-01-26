<?php
session_start();
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
<div id="oeffentliches-profil">
    <h1>Willkommen bei Dummy Name</h1>
    <?php include "php_import_files/dropbox-uebersicht-filtern.php" ?>
    <!-- Die folgenden Einträge werden später gelöscht und durch eine php Datei ersetzt, die die Datenbank ausliest -->
   <?php include "php_import_files/uebersicht-profil.php"?>
    <br>
</div>

<div id="privates-profil">
    <h1>Willkomen auf deinem Profil Dummy Name</h1>
    <div class="flex-profil">
        <form action="profil-einstellungen.php">
            <button type="submit">Einstellungen</button>
        </form>
        <select id="eintraege-profil" class="dropdown">
            <option>Eigene Einträge</option>
            <option>Lesezeichen</option>
        </select>
        <form action="neuer-eintrag.php">
            <button type="submit">Neuen Eintrag</button>
        </form>
    </div>
    <?php include "php_import_files/dropbox-uebersicht-filtern.php" ?>
    <h3>Eigene Einträge</h3>
    <div id="flex-eigene-eintraege">
        
            <div class="grid-item">
                <a href="eintrag.php"><img class="fleximage" src="images/HTML++.jpg"
                                                                              alt="HTML PHP Meme"></a>
                
                <button type="submit">Löschen</button>
            </div>
        
            <div class="grid-item">
                <a href="eintrag.php"><img class="fleximage" src="images/IMG_4062.JPG"
                                                                              alt="Hengstforde"></a>
                
                <button type="submit">Löschen</button>
            </div>
        </div>
        <br>
    </div>
    <h3>Gespeicherte Einträge</h3>
    <div id="gespeicherte-eintraege">
        <?php include "php_import_files/dropbox-uebersicht-filtern.php" ?>
        <div class="flex-eigene-eintraege">
                <iframe style="width: 250px ; height: 250px;" src="https://www.youtube.com/embed/GGcrZp-Olh4"
                        title="Speed drawing Ariana Hernandez"></iframe>

                <a href="eintrag.php"><img class="fleximage" src="images/Tags.jpg"
                                                                              alt="Tags everywhere"></a>
                
                <br>
        </div>
    </div>
    <?php include "php_import_files/footer.php" ?>
</body>
</html>