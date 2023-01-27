<?php
include_once("sqlite_dao.php");
$datenbank = new sqlite_dao();

if (isset($_POST["isNameCall"])) {
    $erfolg = $datenbank->isBenutzerName($_POST["isNameCall"]);
    if ($erfolg) {
        echo 1;
    } else {
        echo 0;
    }

} else if (isset($_POST["suchText"])) {
    $ergebnis = array(array(), array());
    $suche = $datenbank->eintraegeSuchen($_POST["suchText"]);
    $i = 0;
    foreach ($suche["0"] as $key) {
        $ergebnis["0"][$i] = $key["TITEL"];
        $i++;
    }
    $i = 0;
    foreach ($suche["1"] as $key) {
        $ergebnis["1"][$i] = $key["NAME"];
        $i++;
    }

    echo json_encode($ergebnis);

} else {
    echo "error";
}
