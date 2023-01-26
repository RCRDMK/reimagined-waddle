<!-- checkt, ob der Nutzer in der Session angemeldet ist -->
<?php 
if(!isset($_SESSION["login"]) || isset($_SESSION["login"!==true])){
    exit("<h1>Du hast kein Zugriff auf diese Seite! Bitte melde dich <a href='anmelden.php' id='sessioncheck'>hier</a> an</h1>");
}
?>