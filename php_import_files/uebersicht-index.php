<?php
//Wertet die Daten, die vom DAO zurückgeben werden, aus.

require_once('sqlite_dao.php');
require_once('uebersicht_darstellung_logik.php');
$datenbank = new sqlite_dao();
$daten = $datenbank->getDatenIndexUebersicht();
new uebersicht_darstellung_logik($daten);