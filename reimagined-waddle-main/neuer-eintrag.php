<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Neuen Eintrag erstellen</title>
    <?php include "php_import_files/head.php" ?>

    <script>
        function titelInTagAutomatisch() {
            var titel = document.getElementById("titel").value;
            var alterText = document.getElementById("tags").value;
            alterText = alterText.substring(alterText.indexOf(";") + 1);
            document.getElementById("tags").value = titel + ";" +alterText;
        }
    </script>


</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php"; 
include "checks/sessioncheck.php";
include "checks/fehlercheck.php"?>

<h2>Neuer Eintrag</h2>
<!-- Auswahl des Typs des Inhalt und des dazugehörigen Inhalts-->
<form action="./php_import_files/neuer-eintrag-logik.php" method="post" enctype="multipart/form-data">
    <div>
        <label for="kategorien">Dein Eintrag ist ein...</label>
        <select id="kategorien" class="dropdown" required name="neuer-eintrag-kategorie">
            <option value="text">Text</option>
            <option value="bild">Bilder</option>
            <option value="video">Videos</option>
            <option value="dokument">Dokumente</option>
        </select>
    </div>

    <div>
        <label for="titel">Titel: </label>
        <input type="text" id="titel" name="neuer-eintrag-titel" maxlength="50" placeholder="Name des Eintrages"
               required onkeyup="titelInTagAutomatisch()">
    </div>

    <div>
        <label for="beschreibung">Beschreibungstext: </label><br>
        <textarea id="beschreibung" name="neuer-eintrag-beschreibung" cols="5" rows="5" maxlength="1500"
                  placeholder="Beschreibe dein Werk ein wenig..." required></textarea>
    </div>

    <div>
        <label for="tags">Tags: </label>
        <input type="text" id="tags" name="neuer-eintrag-tags" maxlength="100"
               placeholder="Gib Schlagwörter für dein Werk an. Für mehrere, trenne sie mit Semicolon" required>
    </div>

    <div>
        <label for="eintrag-hochladen">Dein Werk als Datei: </label>
        <input type="file" id="eintrag-hochladen" name="neuer-eintrag-hochladen" required>
        <input type="submit" value="Eintrag veröffentlichen">
    </div>
</form>
<a class="abbrechen" href="index.php"><button>Abbrechen</button></a>
<br>


<?php include "php_import_files/footer.php" ?>
</body>
</html>