<?php
require_once("datenbank_dao.php");

class dummy_dao implements datenbank_dao
{
    private $nutzerArray;
    private $eintraegeArray;
    private $kommentarArray;
    private $lesezeichenArray;

    public function __construct()
    {
        $nutzer1 = array("UID" => 1, "EMAIL" => "magnat@mail.de", "NAME" => "Der Schienen Magnat", "PASSWORT" => "123");
        $nutzer2 = array("UID" => 2, "EMAIL" => "muster@mail.de", "NAME" => "Max Muster", "PASSWORT" => "123");
        $this->nutzerArray = array($nutzer1, $nutzer2);

        $eintrag1 = array("EID" => 1, "TITEL" => "Actor", "ORIGINALERNAME" => "actor.png", "TYP" => "bild", "BESCHREIBUNG" => "Der Actor der Mini-Programmierwelt Schienenmagnat.", "TAGS" => "Bild; Schienenmagnat; Actor; Javapraktikum", "DATUM" => "24.07.2022", "UID" => 1);
        $eintrag2 = array("EID" => 2, "TITEL" => "Start-Bahnhof", "ORIGINALERNAME" => "departureStation.png", "TYP" => "bild", "BESCHREIBUNG" => "Der Startbahnhof", "TAGS" => "Bild; Schienenmagnat; Bahnhof; Javapraktikum", "DATUM" => "24.07.2022", "UID" => 1);
        $eintrag3 = array("EID" => 3, "TITEL" => "Hindernis", "ORIGINALERNAME" => "obstacle.png", "TYP" => "bild", "BESCHREIBUNG" => "Ein Hindernis. Es wird durch einen Berg dargestellt", "TAGS" => "Bild; Schienenmagnat; Berg; Obstacle; Javapraktikum", "DATUM" => "24.07.2022", "UID" => 1);
        $eintrag4 = array("EID" => 4, "TITEL" => "Schiene", "ORIGINALERNAME" => "railStraight.png", "TYP" => "bild", "BESCHREIBUNG" => "Eine Schiene die vom Actor platziert wird.", "TAGS" => "Bild; Schienenmagnat; Rail; Javapraktikum", "DATUM" => "24.07.2022", "UID" => 1);
        $eintrag5 = array("EID" => 5, "TITEL" => "Visionsdokument", "ORIGINALERNAME" => "visionsdokument-Original.pdf", "TYP" => "dokument", "BESCHREIBUNG" => "Das originale Visionsdokument", "TAGS" => "Webprogrammierung;", "DATUM" => "24.07.2022", "UID" => 2);
        $eintrag6 = array("EID" => 6, "TITEL" => "Tutorial Registrieren", "ORIGINALERNAME" => "registrieren.mp4", "TYP" => "video", "BESCHREIBUNG" => "So registriert man sich", "TAGS" => "Video;Tutorial;registrieren", "DATUM" => "24.07.2022", "UID" => 2);
        $this->eintraegeArray = array($eintrag1, $eintrag2, $eintrag3, $eintrag4, $eintrag5, $eintrag6);

        $kommentar1 = array("KID" => 1, "KOMMENTARTEXT" => "Ich habe dafür länger gebraucht, als mir lieb ist!", "DATUM" => "24.07.2022 18:25", "UID" => 1, "EID" => 1);
        $kommentar2 = array("KID" => 2, "KOMMENTARTEXT" => "Ein so originelles Werk habe ich noch nie gesehen :)", "DATUM" => "24.07.2022 18:25", "UID" => 1, "EID" => 6);
        $kommentar3 = array("KID" => 3, "KOMMENTARTEXT" => "Ein Meisterwerk der Kunstgeschichte", "DATUM" => "24.07.2022 18:25", "UID" => 2, "EID" => 1);
        $kommentar4 = array("KID" => 4, "KOMMENTARTEXT" => "Der Ersteller hatte hatte wohl Beispielgraphen für Globalemaxima im Kopf, als er das gemalt hat", "DATUM" => "24.07.2022 18:25", "UID" => 2, "EID" => 3);
        $kommentar5 = array("KID" => 5, "KOMMENTARTEXT" => "Der Maler dieses 'Paint'ings wollte sich wahrscheinlich nicht mit Lizenzen auseinander setzen", "DATUM" => "24.07.2022 18:25", "UID" => 2, "EID" => 2);
        $this->kommentarArray = array($kommentar1, $kommentar2, $kommentar3, $kommentar4, $kommentar5);

        $lesezeichen1 = array("UID" => 1, "EID" => 1);
        $lesezeichen2 = array("UID" => 1, "EID" => 6);
        $lesezeichen3 = array("UID" => 2, "EID" => 4);
        $this->lesezeichenArray = array($lesezeichen1, $lesezeichen2, $lesezeichen3);
    }


    /**
     * @inheritDoc
     */
    public function login($email, $passwort): array
    {
        foreach ($this->nutzerArray as $key) {
            if ($key["EMAIL"] === $email && $key["PASSWORT"] === $passwort) {
                return array(true, $key["UID"]);
            }
        }
        return array(false, -1);
    }

    /**
     * @inheritDoc
     */
    public function registrierungMail(string $email): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function registrierungAbschluss($registrierenID, string $email, string $name, string $passwort): int
    {
        return -3;
    }

    /**
     * @inheritDoc
     */
    public function getAccountName($uid): string
    {
        foreach ($this->nutzerArray as $key) {
            if ($key["UID"] == $uid) {
                return $key["NAME"];
            }
        }
        return "";
    }

    /**
     * @inheritDoc
     */
    public function getEintrag($e_id): array
    {
        foreach ($this->eintraegeArray as $key) {
            if ($key["EID"] == $e_id) {
                return array("EID" => $key["EID"], "TITEL" => $key["TITEL"], "ORIGINALERNAME" => $key["ORIGINALERNAME"], "TYP" => $key["TYP"], "BESCHREIBUNG" => $key["BESCHREIBUNG"], "TAGS" => $key["TAGS"], "DATUM" => $key["DATUM"], "UID" => $key["UID"]);
            }
        }
        return array();
    }

    /**
     * @inheritDoc
     */
    public function getDatenIndexUebersicht(): array
    {
        $returnArray = array();
        foreach ($this->eintraegeArray as $key) {
            array_push($returnArray, array("EID" => $key["EID"], "ORIGINALERNAME" => $key["ORIGINALERNAME"], "TYP" => $key["TYP"], "TITEL" => $key["TITEL"]));
        }
        return $returnArray;
    }

    /**
     * @inheritDoc
     */
    public function getDatenProfilUebersicht(int $uid): array
    {
        $returnArray = array();
        foreach ($this->eintraegeArray as $key) {
            if ($uid === $key["UID"]) {
                array_push($returnArray, array("EID" => $key["EID"], "ORIGINALERNAME" => $key["ORIGINALERNAME"], "TYP" => $key["TYP"], "TITEL" => $key["TITEL"]));
            }
        }
        return $returnArray;
    }

    /**
     * @inheritDoc
     */
    public function eintragErstellen(int $uid, string $titel, string $originalerName, string $typ, string $beschreibung, string $tags): int
    {
        return -1;
    }

    /**
     * @inheritDoc
     */
    public function eintraegeSuchen(string $suchString): array
    {
        $returnArray = array(array(), array());
        foreach ($this->eintraegeArray as $key) {
            if (str_contains($key["TITEL"], $suchString) || str_contains($key["BESCHREIBUNG"], $suchString) || str_contains($key["TAGS"], $suchString)) {
                array_push($returnArray[0], array("EID" => $key["EID"], "ORIGINALERNAME" => $key["ORIGINALERNAME"], "TYP" => $key["TYP"], "TITEL" => $key["TITEL"]));
            }
        }

        foreach ($this->nutzerArray as $key) {
            if (str_contains($key["NAME"], $suchString)) {
                array_push($returnArray[1], array("UID" => $key["UID"], "NAME" => $key["NAME"]));
            }
        }
        return $returnArray;

    }

    /**
     * @inheritDoc
     */
    public function eintragEditierenErlaubnisCheck(int $uid, int $eid): bool
    {
        foreach ($this->eintraegeArray as $key) {
            if ($key["EID"] === $eid && $key["UID"] === $uid) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function eintragEditieren(int $uid, int $eid, string $titel, string $beschreibung, string $tags): int
    {
        return -1;
    }

    /**
     * @inheritDoc
     */
    public function lesezeichenSetzen(int $uid, int $eid): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function lesezeichenEntfernen(int $uid, int $eid): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isLesezeichenGesetzt(int $uid, int $eid): bool
    {
        foreach ($this->lesezeichenArray as $key) {
            if ($key["UID"] === $uid && $key["EID"] === $eid) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getDatenLesezeichenUebersicht(int $uid): array
    {

        $returnArray = array();
        $lesezeichen = array();
        foreach ($this->lesezeichenArray as $key) {
            if ($key["UID"] === $uid) {
                array_push($lesezeichen, $key["EID"]);
            }
        }

        foreach ($this->eintraegeArray as $key) {

            if (in_array($key["EID"], $lesezeichen)) {
                array_push($returnArray, array("EID" => $key["EID"], "ORIGINALERNAME" => $key["ORIGINALERNAME"], "TYP" => $key["TYP"], "TITEL" => $key["TITEL"]));
            }
        }

        return $returnArray;
    }

    /**
     * @inheritDoc
     */
    public function kommentarErstellen(int $uid, int $eid, string $text): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function kommentareVonEintrag(int $eid): array
    {
        $returnArray = array();
        foreach ($this->kommentarArray as $key) {
            if ($eid === $key["EID"]) {
                $name = "";
                foreach ($this->nutzerArray as $nutzerKey) {
                    if ($nutzerKey["UID"] === $key["UID"]) {
                        $name = $nutzerKey["NAME"];
                        break;
                    }
                }
                array_push($returnArray, array("KID" => $key["KID"], "KOMMENTARTEXT" => $key["KOMMENTARTEXT"], "DATUM" => $key["DATUM"], "UID" => $key["UID"], "NAME" => $name));
            }
        }
        return $returnArray;
    }

    /**
     * @inheritDoc
     */
    public function kommentarLoeschen(int $kid, int $uid): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isBenutzerName(string $name): bool
    {
        foreach ($this->nutzerArray as $key) {
            if ($key["NAME"] === $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getAlleName(): array
    {
        $array = array();
        foreach ($this->nutzerArray as $key) {
            array_push($array, array("NAME" => $key["NAME"]));
        }
        return $array;
    }

    /**
     * @inheritDoc
     */
    public function eintragLoeschen(int $uid, int $eid): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function accountLoeschen(int $uid): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getLeseichenAnzahl(int $eid): int
    {
        $i = 0;

        foreach ($this->lesezeichenArray as $key) {
            if ($key["EID"] == $eid) {
                $i++;
            }
        }
        return $i;
    }

    /**
     * @inheritDoc
     */
    public function passwortAendern(int $uid, string $passwortAlt, string $passwortNeu): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getProfilEinstellungDaten(int $uid): array
    {

        foreach ($this->nutzerArray as $key) {
            if ($key["UID"] === $uid) {
                return array("EMAIL" => $key["EMAIL"], "NAME" => $key["NAME"]);
            }
        }
        return array();
    }
}