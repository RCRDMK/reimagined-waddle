<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Einstellungen</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>
<div id="email-zeile">
    Email
</div>
<div id="passwort-zeile">
    <button id="passwort-aendern" type="submit">Passwort ändern</button><br>
    <label>Altes Passwort: <input type="password" placeholder="Altes Passwort" required></label>
    <button type="submit">Bestätigen</button><br>
    <label>Neues Passwort: <input type="password" placeholder="Neues Passwort" required></label>
    <label>Neues Passwort wiederholen: <input type="password" placeholder="Neues Passwort Wiederholen" required></label>
    <button type="submit">Bestätigen</button>
</div>
<div id="account-loeschen-zeile">
    <button id="account-loeschen" type="submit">Account löschen</button>
</div>

<?php include "php_import_files/footer.php" ?>
</body>
</html>
