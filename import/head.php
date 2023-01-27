<?php
session_start();
$angemeldet = false;
if (isset($_SESSION["u_id"]) && $_SESSION["u_id"] >= 0) {
    $angemeldet = true;
}
$title = basename($_SERVER["SCRIPT_NAME"], ".php");
if (strtolower($title) == "index") {
    $title = "Harmonie für die Seele";
} else if (strtolower($title) == "eintrag_neu") {
    $title = "Eintrag erstellen";
} else if (strtolower($title) == "eintrag_bearbeiten") {
    $title = "Eintrag bearbeiten";
} else if (strtolower($title) == "profil_einstellungen") {
    $title = "Profil Einstellungen";
}

$title = ucwords($title);
?>
    <!DOCTYPE html>
    <html lang="de">
    <head>

        <title> ReiWa: <?php echo $title; ?></title>

        <meta charset="utf-8">
        <link rel="stylesheet" href="css/stylesheet.css">
        <link rel="stylesheet" href="css/navbar-stylesheet.css">
        <link rel="icon" href="ressourcen/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="javascript/script.js" type="text/javascript"></script>
        <script src="javascript/jquery-3.6.0.js"></script>

    </head>

<body>

<header class="header">
    <!-- Logo -->
    <a href="index.php" title="Startseite"><img id="home-logo" src="ressourcen/logo.png" alt="home" height="80"></a>
    <!-- Hamburger icon -->
    <input class="side-menu" type="checkbox" id="side-menu"/>

    <!-- Menu -->
    <nav class="nav">
        <ul class="menu">
            <li><a href="index.php">Startseite</a></li>
            <?php if ($angemeldet) { ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logik/anmeldung_logik.php?csrf=<?php echo $_SESSION["csrf"] ?>">Abmelden</a></li>
            <?php } else { ?>
                <li><a id="anmelden" href="anmelden.php">Anmelden</a></li>
                <li><a href="registrieren.php">Registrieren</a></li>
            <?php } ?>
            <li class="footerElementInHeader"><a href="impressum.php">Impressum</a></li>
            <li class="footerElementInHeader"><a href="eula.php">Nutzungsbedingungen</a></li>
            <li class="footerElementInHeader"><a href="datenschutz.php"> Datenschutz</a></li>
            <li>
                <form action="suche.php" method="POST">
                    <label for="suche" id="suchelabel" hidden>Suche</label>
                    <input type="text" name="suche" id="suche" title="suche"
                           placeholder="Suche..." onkeyup="suchVorschlaege()">
                    <button id="head-suche-submit" type="submit">Suche</button>
                </form>
            </li>
        </ul>
    </nav>
    <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
</header>

<div class="overlay"></div>
<?php include "import/informationenAnNutzer.php" ?>
<noscript>Für eine bessere Erfahrung auf der Seite, aktiviere bitte JavaScript!</noscript>
