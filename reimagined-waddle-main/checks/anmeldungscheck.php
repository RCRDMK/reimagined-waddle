<?php

if (isset($_GET["login"])){
    $login = $_GET["login"];
    if ($login){
    echo "<h1>Du bist erfolgreich angemeldet worden. Herzlich willkommen!</h1>";
    unset($_SESSION["email"]);
}
}

?>