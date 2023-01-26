<?php
session_start();
require_once("sqlite_dao.php");
$datenbank = new sqlite_dao();
if (isset($_POST["lesezeichen-setzen-eid"])) {
    if (isset($_SESSION["u_id"])) {
        $eid = $_POST["lesezeichen-setzen-eid"];
        $uid = $_SESSION["u_id"];
        if ($datenbank->lesezeichenSetzen($uid,$eid)) {
            header("Location:../eintrag.php?e_id=$eid");
        } else {
            header("Location:../eintrag.php?e_id=$eid&err=lz6");
        }
    } else {
        header("Location:../index.php?err=lz8");
    }
} else {
    header("Location:../index.php?err=lz7");
}