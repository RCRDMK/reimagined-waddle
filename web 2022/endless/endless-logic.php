<?php
//Falls keine Beiträge mehr geladen werden können
if($_POST["page"]==6){
    echo "keine Seiten mehr zum laden";
}

//Aufruf um eine neue Seite zu laden und anzuzeigen
else{echo "<div class='neue-seite'>PAGE ".$_POST["page"]."</div>";}
?>