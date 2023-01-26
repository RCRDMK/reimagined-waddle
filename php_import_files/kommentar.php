<?php 

if(isset($_POST["neuer-kommentar"])):

    ?>
    <div class="kommentar">

    <div id="kommentarersteller"><a href="profil.php">Username</a></div>
    <div id="kommentartext"><?php echo htmlentities($_POST["neuer-kommentar"]);?></div>
    <div id="kommentardatum">h:m, y:m:d</div>
    </div>
    <form action="eintrag.php" method="post">
        
        <input name="kommentar-löschen" type="submit" value="Kommentar löschen">
    </form>
<?php endif;

if(isset($_POST["kommentar-löschen"])){
    unset($_POST["neuer-kommentar"]);
}
?> 





