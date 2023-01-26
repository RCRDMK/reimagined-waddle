<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>Registrieren</title>
    <?php include "php_import_files/head.php" ?>
  <script src="javascript/validieren.js" type="text/javascript"> </script>
</head>
<body>
<?php include "php_import_files/navbar-auswahl-logik.php" ?>
<section>
    <h2>Registrieren</h2>
    <?php include "checks/fehlercheck.php" ?>
    <form action="php_import_files/registrieren-logik.php" method="POST">
        <div>
            <label for="registrieren-email-adresse">EMail: </label>
            <div>
                <input type="email" id="registrieren-email-adresse" name="registrieren-email-adresse" maxlength="200"
                       placeholder="max.muster@uni-oldenburg.de" value="<?php if (isset($_SESSION["email"])){echo $_SESSION["email"];} ?>" required>
                <div>Erforderlich</div>
            </div>
        </div>
        <div>
            <label for="registrieren-name">Benutzername: <label id="benutzername-vergeben"></label></label>
            <div>
                <input type="text" id="registrieren-name" name="registrieren-name" maxlength="200"
                       placeholder="Max Mustermann" required>
                <div>Erforderlich</div>
            </div>
        </div>
        <div>
            <label for="registrieren-passwort">Passwort: <label id="passwort-ungleich"></label></label>
            <div>
                <input type="password" id="registrieren-passwort" name="registrieren-passwort" minlength="8" maxlength="100"
                       placeholder="Passwort" required>
                <div>Erforderlich (Neun Zeichen lang)</div>
            </div>
        </div>

        <div>
            <label for="registrieren-passwort-wiederholen">Passwort: </label>
            <div>
                <input type="password" id="registrieren-passwort-wiederholen" name="registrieren-passwort-wiederholen" minlength="8"
                       maxlength="100" placeholder="Passwort wiederholen" required>
                <div>Erforderlich (Neun Zeichen lang)</div>
            </div>
        </div>
        <button type="submit">Registrieren</button>
    </form>
    <div>
        <form action="index.php">
            <button type="submit">Abbrechen</button>
        </form>
    </div>

</section>
<?php include "php_import_files/footer.php" ?>
</body>
</html>