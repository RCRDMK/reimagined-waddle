<?php
include "import/head.php";

if (isset($_SESSION["u_id"])) {
    $uid = $_SESSION["u_id"];
} else {
    header("Location: index.php?err=pre0");
    exit();
}

//Hole Daten aus Datenbank
require_once("logik/sqlite_dao.php");
$datenbank = new sqlite_dao();
$profilDatenArray = $datenbank->getProfilEinstellungDaten($uid);

//Checke, ob Daten leer: Wenn leer, dann kein Account in Datenbank gefunden ->
if (empty($profilDatenArray)) {
    header("Location: index.php?err=pre1");
    exit();
}
?>

<!-- BODY -->
<section id="profil-einstellungen-body">
    <h1>Profileinstellungen</h1>

    <div id="profil-einstellungen-mail">Deine E-Mail: <?php echo $profilDatenArray["EMAIL"] ?></div>
    <div id="profil-einstellungen-name">Dein Name: <?php echo $profilDatenArray["NAME"] ?></div>


    <!-- Passwort ändern -->
    <form method="post" action="logik/account_logik.php" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
        <label for="einstellungen-passwort-aendern-passwort-alt">Altes Passwort (erforderlich): </label>
        <input type="password" name="einstellungen-passwort-aendern-passwort-alt"
               id="einstellungen-passwort-aendern-passwort-alt" required>
        <label for="einstellungen-passwort-aendern-passwort-neu">Neues Passwort (erforderlich): </label>
        <input type="password" name="einstellungen-passwort-aendern-passwort-neu"
               id="einstellungen-passwort-aendern-passwort-neu" minlength="9" required>
        <input id="einstellungen-passwort-aendern-submit" type="submit" value="Passwort ändern" name="passwort-aendern">
    </form>

    <!-- Account löschen -->
    <form id="einstellungen-loeschen-form" method="post" action="logik/account_logik.php" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
        <input type="submit" value="Account löschen" name="loeschen" id="einstellungen-loeschen-submit">
    </form>
</section>
<?php include "import/foot.php" ?>
