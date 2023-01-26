<?php
//entscheidet ob die Navbar eines Lesers oder eines Mitglieds angezeigt werden soll.
if(isset($_SESSION["login"]) && $_SESSION["login"]){
    include "navbars/navbar-angemeldet.php";
}else{
    include "navbars/navbar-abgemeldet.php";
}
