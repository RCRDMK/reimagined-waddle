<?php
include "import/head.php";
if (isset($_SESSION["u_id"])) {
    header("Location: index.php?err=anm0");
} ?>

    <section id="anmelden-body">
        <h1>Anmelden</h1>
        <form id="anmelden-form" action="logik/anmeldung_logik.php" method="POST">

            <label for="anmelden-email-adresse">E-Mail (erforderlich): </label>
            <input type="email" id="anmelden-email-adresse" name="anmelden-email-adresse"
                   placeholder="max.muster@uni-oldenburg.de" value="<?php if (isset($_SESSION["email"])) {
                echo $_SESSION["email"];
            } ?>" required>

            <label for="anmelden-passwort">Passwort (erforderlich): </label>
            <input type="password" id="anmelden-passwort" name="anmelden-passwort"
                   placeholder="Passwort" required>

            <input id=anmelden-button-anmelden type="submit" value="Anmelden">
        </form>


        <form action="index.php">
            <input id="anmelden-button-abbrechen" type="submit" value="Abbrechen">
        </form>
    </section>
<?php include "import/foot.php" ?>