<section>
                <div class="grid-eintrag">
                <h2>Titel des Eintrages</h2>
            
                <img src="images/Protag-kun.png" alt="Der Held der Katz-tastrophe!">
            
                <div>
            <span>Benutzername: </span>
            <span>Web22</span>
                </div>
            
                <div>
            <span>Uploaddatum: </span>
            <span>29.04.2022</span>
                </div>
            
                <div>Das ist eine tolle Beschreibung</div>
            </div>
        </section>
            
            
            <section>
                <select id="kommentare_sortieren" class="dropdown">
                <option>Neu</option>
                <option>Älteste</option>
                    </select>
                <div id="kommentarbereich">
                    <?php include "php_import_files/kommentar.php" ?>
                </div>
                <br>
<div class="neuer-kommentar">
        <form action="eintrag.php" method="post">
            <label for="neuer-kommentar" class="neuer-kommentar">Neuen Kommentar verfassen: </label><br>
            <textarea class="neuer-kommentar" name="neuer-kommentar" cols="5" rows="5" maxlength="1500"
                      placeholder="Hast du Gedanken über dieses Werk?" required></textarea>
                      <input class="neuer-kommentar" type="submit" value="Kommentar veröffentlichen">
        </form>
    </div>
            </section>