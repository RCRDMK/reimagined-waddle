<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Anmelden</title>
    <?php include "php_import_files/head.php" ?>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>
<section>
    <h2>Anmelden</h2>
    <?php include "checks/fehlercheck.php" ?>
    <?php include "checks/anmeldungscheck.php" ?>
    <form action="php_import_files/anmelden-logik.php" method="POST">
        <div>
            <label for="anmelden-email-adresse">E-Mail: </label>
            <div>
                <input type="email" id="anmelden-email-adresse" name="anmelden-email-adresse" maxlength="200"
                       placeholder="max.muster@uni-oldenburg.de" value="<?php if (isset($_SESSION["email"])){echo $_SESSION["email"];} ?>" required>
                <div>Erforderlich</div>
            </div>
        </div>

        <div>
            <label for="anmelden-passwort">Passwort: </label>
            <div>
                <input type="password" id="anmelden-passwort" name="anmelden-passwort" maxlength="100" placeholder="passwort" required>
                <div>Erforderlich</div>
            </div>
        </div>

        <div>
            <button type="submit">Anmelden</button>
        </div>
    </form>
    <form action="index.php">
        <button type="submit">Abbrechen</button>
    </form>
</section>

<div>
<form action="registrieren.php">
    <button type="submit">Hier kannst du dich registrieren, wenn du noch kein Konto hast</button>
</form>
</div>

<?php include "php_import_files/footer.php" ?>
</body>
</html>