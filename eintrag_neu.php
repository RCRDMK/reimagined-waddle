<?php
include "import/head.php";
if (!isset($_SESSION["u_id"])) {
    header("Location: index.php?err=neu0");
}
?>
    <section id="neu-body">
        <h1> Neuen Eintrag erstellen</h1>
        <form id="neu-eintrag" action="logik/eintrag_erstellen_logik.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf" value="<?php echo $_SESSION["csrf"] ?>">
            <div id="neu-type-div">
                <label for="neu-kategorien">Dein Eintrag ist ein...</label>
                <select id="neu-kategorien" class="dropdown" required name="neu-kategorie">
                    <option value="" disabled selected>Eintrags-Kategorie</option>
                    <option value="bild">Bild</option>
                    <option value="video">Video</option>
                    <option value="dokument">Dokument</option>
                </select>
            </div>

            <label for="neu-titel">Titel (erforderlich): </label>
            <input type="text" id="neu-titel" name="neu-titel" maxlength="50" placeholder="Name des Eintrages"
                   required onkeyup="titelInTagAutomatisch()">

            <label for="neu-beschreibung">Beschreibungstext (erforderlich): </label>
            <textarea id="neu-beschreibung" name="neu-beschreibung" cols="5" rows="5" maxlength="1500"
                      placeholder="Beschreibe dein Werk ein wenig..." required></textarea>


            <label for="neu-tags">Tags (erforderlich): </label>
            <input type="text" id="neu-tags" name="neu-tags" maxlength="100"
                   placeholder="Gib Schlagwörter für dein Werk an. Für mehrere, trenne sie mit Semicolon" required>


            <label for="neu-hochladen">Dein Werk als Datei (erforderlich): </label>

            <input type="file" id="neu-hochladen" name="neu-hochladen" required>


            <input id="neu-submit" type="submit" value="Eintrag veröffentlichen">
        </form>

        <form action="profil.php">
            <input id="neu-abbrechen-submit" type="submit" value="Abbrechen">
        </form>

    </section>

<?php include "import/foot.php" ?>