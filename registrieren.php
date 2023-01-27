<?php
include "import/head.php";
if (isset($_SESSION["u_id"])) {
    header("Location: index.php?err=reg0");
} ?>
    <section id="registrieren-body">
        <?php if (isset($_GET["reg"])) {
            if ($_GET["reg"] === "mail") { ?>
                <h1>Es wurde eine E-Mail an die angegebene Adresse verschickt mit weiteren Infos. (Zu finden unter
                    Ordner mail)</h1>
            <?php } else { ?>
                <h1>Registrieren - Schritt 2</h1>
                <form action="logik/registrierung_logik.php" method="post" enctype="multipart/form-data"
                      id="registrieren-schrittZwei-form">

                    <label for="registrieren-schrittZwei-mail">E-Mail (Erforderlich): </label>
                    <input type="email" id="registrieren-schrittZwei-mail" placeholder="max.muster@uni-oldenburg.de"
                           name="registrieren-schrittZwei-mail">

                    <label for="registrieren-name">Benutzername (Erforderlich): </label>
                    <input type="text" id="registrieren-name" name="registrieren-name" maxlength="200"
                           placeholder="Max Mustermann" required onkeyup="isNameFrei()">
                    <label hidden id="benutzername-vergeben">Benutername vergeben</label>

                    <label for="registrieren-passwort">Passwort (Erforderlich, min. 9 Zeichen): </label>
                    <input type="password" id="registrieren-passwort" name="registrieren-passwort" minlength="8"
                           maxlength="100"
                           placeholder="Passwort" required
                           onkeyup="passwoerterRegistierenIdentischVergleich()">

                    <label for="registrieren-passwort-wiederholen">Passwort wiederholen (Erforderlich): </label>

                    <input type="password" id="registrieren-passwort-wiederholen"
                           name="registrieren-passwort-wiederholen" minlength="8"
                           maxlength="100" placeholder="Passwort wiederholen" required
                           onkeyup="passwoerterRegistierenIdentischVergleich()">

                    <label hidden id="passwort-nicht-identisch">Passwörter stimmen nicht überein</label>


                    <div id="registrieren-2-datenschutz-div">
                        <label for="neu-datenschutz">Ich habe die <a id="registrieren-datenschutz-link"
                                                                     href="datenschutz.php">Datenschutzbedingungen</a>
                            gelesen und stimme diesen zu
                            (erforderlich)</label>
                        <input id="neu-datenschutz" type="checkbox" required>
                    </div>

                    <div id="registrieren-2-eula-div">
                        <label for="neu-bedingungen">Ich habe die <a id="registrieren-eula-link" href="eula.php">Nutzungsbedingungen</a>
                            gelesen und stimme
                            diesen zu
                            (erforderlich)</label>
                        <input id="neu-bedingungen" type="checkbox" required>
                    </div>

                    <input type="hidden" value="<?php echo $_GET["reg"] ?>" id="registrieren-regID"
                           name="registrieren-regID">
                    <input id="registrieren-2-button-submit" type="submit" value="Registrieren">
                </form>
            <?php }
        } else { ?><!-- E-Mail validieren -->

            <h1>Registrieren - Schritt 1</h1>
            <form action="logik/registrierung_logik.php" method="POST" id="registrieren-form">
                <label for="registrieren-email-adresse-check">E-Mail (Erforderlich): </label>
                <input type="email" id="registrieren-email-adresse-check"
                       name="registrieren-email-adresse-check"
                       maxlength="200"
                       placeholder="max.muster@uni-oldenburg.de" value="<?php if (isset($_SESSION["email"])) {
                    echo $_SESSION["email"];
                } ?>" required>
                <input id="registrieren-1-button-submit" type="submit" value="Registrieren">
            </form>
            <form action="index.php">
                <input id="registrieren-1-button-abbrechen" type="submit" value="Abbrechen">
            </form>


        <?php } ?>
    </section>
<?php include "import/foot.php" ?>