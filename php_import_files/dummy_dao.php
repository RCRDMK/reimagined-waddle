<?php
require_once('datenbank_dao.php');

class dummy_dao //implements datenbank_dao TODO: implememts wieder einfügen
{

    public function eintraege()
    {
        $data1 = array(
            "e_id" => 0,
            "inhalt" => "images/HTML++.jpg",
            "titel" => "html++",
            "beschreibung" => "Man sieht ein Meme",
            "tags" => "lustig",
            "u_id" => 1
        );
        $data2 = array(
            "e_id" => 1,
            "inhalt" => "images/IMG_4062.JPG",
            "titel" => "Hengstforde",
            "beschreibung" => "Hier sieht man Gebäude in Hengstforde",
            "tags" => "haus",
            "u_id" => 0
        );
        $data3 = array(
            "e_id" => 2,
            "inhalt" => "images/Protag-kun.png",
            "titel" => "Protag Kun",
            "beschreibung" => "Der Protagonist",
            "tags" => "mensch",
            "u_id" => 0
        );
        $data4 = array(
            "e_id" => 3,
            "inhalt" => "images/Tables.jpg",
            "titel" => "Tables",
            "beschreibung" => "Lustiges Meme",
            "tags" => "lustig",
            "u_id" => 1
        );


        return array($data1, $data2, $data3, $data4);
    }

    public function user()
    {
        $data1 = array(
            "u_id" => 0,
            "name" => "Ernie Bertram",
            "email" => "ernie@bert.de",
            "passwort" => "123");
        $data2 = array(
            "id" => 1,
            "name" => "Jimmy Space",
            "email" => "jimmy@space.de",
            "passwort" => "gold");
        return array($data1, $data2);
    }

    public function getDatenIndexUebersicht(): array
    {
        //hier soll nur der Titel, die ID und der Inhalt zurückgegeben werden
        return $this->eintraege();
    }

    public function login($email, $passwort): array
    {
        $users = $this->user();

        foreach ($users as $user) {
            if (strcmp($user["email"], $email) == 0 && strcmp($user["passwort"], $passwort) == 0) {
                return array(true, $user["u_id"]);
            }
        }
        return array(false);
    }

    public function getEintrag($e_id): array
    {
        $eintraege = $this->eintraege();
        foreach ($eintraege as $eintrag){
            if($e_id == $eintrag["e_id"]){
                return array(
                    "e_id" => $eintrag["e_id"],
                    "inhalt" => $eintrag["inhalt"],
                    "titel" => $eintrag["titel"],
                    "beschreibung" => $eintrag["beschreibung"],
                    "tags" => $eintrag["tags"],
                    "u_id" => $eintrag["u_id"]
                );
            }
        }
            return array();
    }

}