<?php
require_once('datenbank_dao.php');

//TODO: SQL exceptions abfangen, z.B. Table fehlt, z.B. User wurde gelöscht
//TODO: transaction anpassen
//TODO: existsUID, existsEID, existsKID
//TODO: UID fehlt -> lösche alle Einträge,Kommentare, Lesezeichen
//TODO: EID fehlt -> lösche Kommentare, Lesezeichen


class sqlite_dao implements datenbank_dao
{
    private $defaultDatabasePath;
    private $databasefilename = 'database.sqlite';
    private $datenbank;

    public function __construct()
    {
        $this->defaultDatabasePath = $_SERVER["DOCUMENT_ROOT"] . "/reimagined-waddle/datenbank/";
        $this->connectToDB();
    }

    function connectToDB()
    {
        //Muss hier auch eine Transaktion hin?
        if (!file_exists($this->defaultDatabasePath)) {
            mkdir($this->defaultDatabasePath, 0777);
            mkdir($this->defaultDatabasePath . '/upload', 0777);
            $this->datenbank = new PDO('sqlite:' . $this->defaultDatabasePath . '/' . $this->databasefilename);

            //Account: u_id, e_mail, name, passwort
            $this->datenbank->query('CREATE TABLE ACCOUNT(UID integer  PRIMARY KEY AUTOINCREMENT ,EMAIL TEXT NOT NULL UNIQUE ,NAME TEXT NOT NULL UNIQUE, PASSWORT TEXT NOT NULL)');

            //Eintrag: e_id, titel, inhalt, typ, beschreibung, tags, datum, u_id
            $this->datenbank->query('CREATE TABLE EINTRAG(EID integer  PRIMARY KEY AUTOINCREMENT, TITEL TEXT NOT NULL , ORIGINALERNAME TEXT NOT NULL, TYP TEXT NOT NULL, BESCHREIBUNG TEXT NOT NULL, TAGS TEXT NOT NULL, DATUM DATE NOT NULL, UID integer ,FOREIGN KEY(UID) REFERENCES ACCOUNT(UID))');

            //Kommentar: k_id, kommentartext, datum, u_id, e_id
            $this->datenbank->query('CREATE TABLE KOMMENTAR(KID integer  PRIMARY KEY AUTOINCREMENT, KOMMENTARTEXT TEXT, DATUM timestamp , UID integer, EID integer,FOREIGN KEY(UID) REFERENCES ACCOUNT(UID), FOREIGN KEY(EID) REFERENCES EINTRAG(EID))');

            //Lesezeichen: u_id, e_id
            $this->datenbank->query('CREATE TABLE LESEZEICHEN(UID integer, EID integer,FOREIGN KEY(UID) REFERENCES ACCOUNT(UID), FOREIGN KEY(EID) REFERENCES EINTRAG(EID))');

            $this->datenbankBeispieleErstellen();
        } else {
            $this->datenbank = new PDO('sqlite:' . $this->defaultDatabasePath . '/' . $this->databasefilename);
        }
    }

    /**
     * füllt die Datenbank mit Beispielen
     * @return void
     */
    private function datenbankBeispieleErstellen()
    {
        //Pfade
        $dateiOriginalOrdner = $_SERVER["DOCUMENT_ROOT"] . "/reimagined-waddle/datenbankBspInhalte/";
        $dateiNeuerOrdner = $_SERVER["DOCUMENT_ROOT"] . "/reimagined-waddle/datenbank/upload/";

        //User
        $this->registrieren("magnat@mail.de", "Der SchienenMagnat", "123");
        $this->registrieren("muster@mail.de", "Max Muster", "123");

        //Einträge "Magnat"
        $eidActor = $this->eintragErstellen(1, "Actor", "actor.png", "bild", "Der Actor der Mini-Programmierwelt Schienenmagnat.", "Bild; Schienenmagnat; Actor; Javapraktikum");
        copy($dateiOriginalOrdner . "actor.png", $dateiNeuerOrdner . $eidActor . ".png");

        $eidDepStat = $this->eintragErstellen(1, "Start-Bahnhof", "departureStation.png", "bild", "Der Startbahnhof", "Bild; Schienenmagnat; Bahnhof; Javapraktikum");
        copy($dateiOriginalOrdner . "departureStation.png", $dateiNeuerOrdner . $eidDepStat . ".png");

        $eidObst = $this->eintragErstellen(1, "Hindernis", "obstacle.png", "bild", "Ein Hindernis. Es wird durch einen Berg dargestellt", "Bild; Schienenmagnat; Berg; Obstacle; Javapraktikum");
        copy($dateiOriginalOrdner . "obstacle.png", $dateiNeuerOrdner . $eidObst . ".png");

        $eidRailSt = $this->eintragErstellen(1, "Schiene", "railStraight.png", "bild", "Eine Schiene die vom Actor platziert wird.", "Bild; Schienenmagnat; Rail; Javapraktikum");
        copy($dateiOriginalOrdner . "railStraight.png", $dateiNeuerOrdner . $eidRailSt . ".png");


        //Einträge "Max Muster"
        $eidVisio = $this->eintragErstellen(2, "Visionsdokument", "visionsdokument-Original.pdf", "dokument", "Das originale Visionsdokument", "Webprogrammierung;");
        copy($dateiOriginalOrdner . "visionsdokument-Original.pdf", $dateiNeuerOrdner . $eidVisio . ".pdf");
        $eidVisio = $this->eintragErstellen(2, "Magie", "ricardo-der-magier.mp4", "video", "Der neue Harry Potter", "Video;Nicht Lustig");
        copy($dateiOriginalOrdner . "ricardo-der-magier.mp4", $dateiNeuerOrdner . $eidVisio . ".mp4");

        //Lesezeichen "Magnat"
        $this->lesezeichenSetzen(1, $eidActor);
        $this->lesezeichenSetzen(1, $eidVisio);

        //Lesezeichen "Max Muster"
        $this->lesezeichenSetzen(2, $eidRailSt);

        //Kommentare "Magnat"
        $this->kommentarErstellen(1, $eidActor, "Ich habe dafür länger gebraucht, als mir lieb ist!");
        $this->kommentarErstellen(1, $eidVisio, "Ein so originelles Werk habe ich noch nie gesehen :)");
        //Kommentare "Max Muster"
        $this->kommentarErstellen(2, $eidActor, "Ein Meisterwerk der Kunstgeschichte");
        $this->kommentarErstellen(2, $eidObst, "Der Ersteller hatte hatte wohl Beispielgraphen für Globalemaxima im Kopf, als er das gemalt hat");
        $this->kommentarErstellen(2, $eidDepStat, "Der Maler dieses 'Paint'ings wollte sich wahrscheinlich nicht mit Lizenzen auseinander setzen");


    }

    public function registrieren($email, $name, $passwort): array
    {//TODO: Email/User check entfernen und transaktion auf das ganze ausweiten
        $fehlercode = 3;// generischer Fehlercode

        //check ob Email existiert
        $stmt_emailExistsCheck = $this->datenbank->prepare('SELECT EMAIL FROM ACCOUNT WHERE EMAIL = :mail');
        $stmt_emailExistsCheck->bindParam(':mail', $email);
        $stmt_emailExistsCheck->execute();
        $emailExistsArray = $stmt_emailExistsCheck->fetchAll(PDO::FETCH_ASSOC);
        if (empty($emailExistsArray)) {
            //check ob Username existiert:
            $stmt_userExistsCheck = $this->datenbank->prepare('SELECT EMAIL FROM ACCOUNT WHERE UID  = :uid');
            $stmt_userExistsCheck->bindParam(':uid', $name);
            $stmt_userExistsCheck->execute();
            $userExistsArray = $stmt_userExistsCheck->fetchAll(PDO::FETCH_ASSOC);
            if (empty($userExistsArray)) {
                //lege den User in Tabelle an:
                $hashedPasswort = password_hash($passwort, PASSWORD_DEFAULT);
                try {
                    $this->datenbank->beginTransaction();
                    $sql = 'INSERT INTO ACCOUNT(EMAIL, NAME, PASSWORT)' . 'VALUES(:mail,:name,:hashedPasswort)';
                    $stmt = $this->datenbank->prepare($sql);
                    $stmt->bindParam(':mail', $email);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':hashedPasswort', $hashedPasswort);
                    $executeErfolgreich = $stmt->execute(); //gibt zurück, ob es erfolgreich war
                    $this->datenbank->commit();
                } catch (Exception $e) {
                    //TODO: Bessere Fehlermeldung
                    $this->datenbank->rollback();
                    return array($fehlercode, -1);
                }
                if ($executeErfolgreich) {
                    $stmt_getUID = $this->datenbank->prepare('SELECT UID FROM ACCOUNT WHERE EMAIL = :mail');
                    $stmt_getUID->bindParam(':mail', $email);
                    $stmt_getUID->execute();
                    $uidArray = $stmt_getUID->fetchAll(PDO::FETCH_ASSOC);
                    $fehlercode = 0;
                    return array($fehlercode, $uidArray[0]["UID"]);
                }
            } else {
                $fehlercode = 2;
            }
        } else {
            $fehlercode = 1;
        }
        return array($fehlercode, -1);
    }

    public function login($email, $passwort): array
    {//TODO:SQLFEHLER, überprüfen ob alle abgefangen wird
        $stmt_getAccount = $this->datenbank->prepare('SELECT UID, PASSWORT FROM ACCOUNT WHERE EMAIL = :mail');
        $stmt_getAccount->bindParam(':mail', $email);
        $stmt_getAccount->execute();
        $accountArray = $stmt_getAccount->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($accountArray)) {//check, ob E-Mail gefunden wurde
            $hashedPassword = $accountArray[0]['PASSWORT'];
            $passwortRichtig = password_verify($passwort, $hashedPassword);
            if ($passwortRichtig) {//check, ob das Passwort richtig ist
                return array(true, $accountArray[0]["UID"]);
            }
        }
        return array(false, -1);
    }


    public function getAccountName($uid): string
    {
        return $this->getAccountNameLogik($uid);
    }

    private function getAccountNameLogik($uid): string
    {//TODO: SQLFEHLER abfangen
        $stmt = $this->datenbank->prepare('SELECT NAME FROM ACCOUNT WHERE UID == :u_id');
        $stmt->bindParam('u_id', $uid);
        $stmt->execute();
        return ($stmt->fetchAll(PDO::FETCH_ASSOC))[0]["NAME"];
    }

    public function getEintrag($e_id): array
    {//TODO: SQLFEHLER überprüfen ob alles abgefangen
        $stmt = $this->datenbank->prepare('SELECT * FROM EINTRAG WHERE EID == :eid');
        $stmt->bindParam(':eid', $e_id);
        $stmt->execute();
        $eintrag = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($eintrag)) {
            return $eintrag[0];
        }
        return array();
    }

    public function getDatenIndexUebersicht(): array
    {//TODO: SQLFEHLER überprüfen ob notwendig -> wahrscheinlich nicht, da leeres Array zurükgeben werden darf
        $stmt = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDatenProfilUebersicht($uid): array
    {//TODO: SQLFEHLER überprüfen ob notwendig -> wahrscheinlich nicht, da leeres Array zurükgeben werden darf

        $stmt = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG WHERE UID == :u_id');
        $stmt->bindParam('u_id', $uid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function eintragErstellen($uid, $titel, $originalerName, $typ, $beschreibung, $tags): int
    {//TODO: SQLFEHLER abfangen; transaktion lastInsert reinziehen
        $executeErfolgreich = false;
        try {
            $this->datenbank->beginTransaction();
            $datum = date("d.m.Y", time());
            $sql = 'INSERT INTO EINTRAG(TITEL, ORIGINALERNAME, TYP, BESCHREIBUNG, TAGS, DATUM, UID)' . 'VALUES(:titel,:inhalt, :typ,:beschreibung, :tags, :datum, :uid);';
            //last_row_id() funktioniert nicht
            $stmt = $this->datenbank->prepare($sql);
            $stmt->bindParam(':titel', $titel);
            $stmt->bindParam(':inhalt', $originalerName);
            $stmt->bindParam(':typ', $typ);
            $stmt->bindParam(':beschreibung', $beschreibung);
            $stmt->bindParam(':tags', $tags);
            $stmt->bindParam(':datum', $datum);
            $stmt->bindParam(':uid', $uid);
            $executeErfolgreich = $stmt->execute();
            $this->datenbank->commit();
        } catch (Exception $e) {
            //TODO: Bessere Fehlermeldung
            $this->datenbank->rollback();
        }
        if ($executeErfolgreich) {
            return $this->datenbank->lastInsertId(); //TODO: ist das sicher?
        }
        return -1;
    }

    public function eintraegeSuchen(string $suchString): array
    {

        $eintraege = $this->sucheEintrag($suchString);
        $profile = $this->sucheProfil($suchString);
        return array($eintraege, $profile);
    }

    private function sucheEintrag(string $suchString): array
    {
        $suche = "%" . $suchString . "%";
        $stmt = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG WHERE TITEL LIKE :suchString OR BESCHREIBUNG LIKE :suchString OR TAGS LIKE :suchString');
        $stmt->bindParam(':suchString', $suche);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function sucheProfil(string $suchString): array
    {
        $suche = "%" . $suchString . "%";
        $stmt = $this->datenbank->prepare('SELECT UID, NAME FROM ACCOUNT WHERE NAME LIKE :suchString');
        $stmt->bindParam(':suchString', $suche);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eintragEditierenErlaubnisCheck(int $uid, int $eid): bool
    {
        return $this->eintragEditierenErlaubnisCheckLogik($uid, $eid);
    }

    private function eintragEditierenErlaubnisCheckLogik(int $uid, int $eid): bool
    {
        $stmt = $this->datenbank->prepare('SELECT UID FROM EINTRAG WHERE EID == :eid');
        $stmt->bindParam(':eid', $eid);
        $stmt->execute();
        $uidDatenbank = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($uidDatenbank)) {
            if ($uidDatenbank[0]["UID"] == $uid) {
                return true;
            }
        }
        return false;
    }

    public function eintragEditieren(int $uid, int $eid, string $titel, string $beschreibung, string $tags): int
    {

        $executeFehler = -1;
        if (!$this->eintragEditierenErlaubnisCheckLogik($uid, $eid)) {
            return $executeFehler;
        }
        try {
            $this->datenbank->beginTransaction();
            $stmt = $this->datenbank->prepare('UPDATE EINTRAG SET TITEL = :titel, BESCHREIBUNG = :beschreibung, TAGS = :tags WHERE EID = :eid; ');
            $stmt->bindParam(':titel', $titel);
            $stmt->bindParam(':beschreibung', $beschreibung);
            $stmt->bindParam(':tags', $tags);
            $stmt->bindParam(':eid', $eid);
            $executeErfolgreich = $stmt->execute();
            if ($executeErfolgreich) {
                return $eid;
            } else {
                $executeFehler = -2;
            }
        } catch (Exception $e) {
            //TODO: Bessere Fehlermeldung
            $this->datenbank->rollback();
            $executeFehler = -2;
        }
        return $executeFehler;


    }

    public function lesezeichenSetzen(int $uid, int $eid): bool
    {
        if (!$this->isLesezeichenGesetztLogik($uid, $eid)) {//Wenn nicht gesetzt, dann darf es gesetzt werden
            try {
                $this->datenbank->beginTransaction();
                $stmt = $this->datenbank->prepare('INSERT INTO LESEZEICHEN (UID,EID) 
                                                    VALUES ((SELECT ACCOUNT.UID FROM ACCOUNT WHERE ACCOUNT.UID = :uid),
                                                            (SELECT EINTRAG.EID FROM EINTRAG WHERE EINTRAG.EID = :eid))');
                $stmt->bindParam(':eid', $eid);
                $stmt->bindParam(':uid', $uid);
                $executeErfolgreich = $stmt->execute();
                $this->datenbank->commit();
                if ($executeErfolgreich) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                //TODO: Bessere Fehlermeldung
                $this->datenbank->rollback();
                return false;
            }
        }
        return false;
    }

    public function lesezeichenEntfernen(int $uid, int $eid): bool
    {
        if ($this->isLesezeichenGesetztLogik($uid, $eid)) {//Wenn gesetzt, dann kann es entfernt werden
            try {
                $this->datenbank->beginTransaction();
                $stmt = $this->datenbank->prepare('DELETE FROM LESEZEICHEN WHERE UID = :uid AND EID =:eid');
                $stmt->bindParam(':uid', $uid);
                $stmt->bindParam(':eid', $eid);
                $executeErfolgreich = $stmt->execute();
                $this->datenbank->commit();
                if ($executeErfolgreich) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                //TODO: Bessere Fehlermeldung
                $this->datenbank->rollback();
                return false;
            }
        }
        return false;
    }


    public function isLesezeichenGesetzt(int $uid, int $eid): bool
    {
        return $this->isLesezeichenGesetztLogik($uid, $eid);
    }

    private function isLesezeichenGesetztLogik(int $uid, int $eid): bool
    {
        $stmt = $this->datenbank->prepare('SELECT UID, EID FROM LESEZEICHEN WHERE UID = :uid AND EID = :eid');
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':eid', $eid);
        $stmt->execute();
        $ergebnis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($ergebnis[0])) {
            return false;
        } else {
            return true;
        }
    }

    public function getDatenLesezeichenUebersicht(int $uid): array
    { //TODO: SQLFEHLER - muss hier wahrscheinlich nicht gemacht werden, wenn keine Lesezeichen, dann keine foreach Iteration
        $ergebnis = array();
        $eintraege = $this->getLesezeichenNutzer($uid);
        foreach ($eintraege as $key => $eintrag) {
            $eid = $eintrag["EID"];
            $stmt = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG WHERE EID == :e_id');
            $stmt->bindParam('e_id', $eid);
            $stmt->execute();

            array_push($ergebnis, $stmt->fetchAll(PDO::FETCH_ASSOC)[0]);//durch foreach notwendig
        }
        return $ergebnis;
    }

    /**
     * gibt die Lesezeichen eines Nutzers aus
     *
     * return array(array(EID))
     * @param int $uid
     * @return array
     */
    private function getLesezeichenNutzer(int $uid): array
    {
        $stmt = $this->datenbank->prepare('SELECT EID FROM LESEZEICHEN WHERE UID = :uid');
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $ergebnis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ergebnis;
    }

    public function kommentarErstellen(int $uid, int $eid, string $text): bool
    {
        try {
            $datum = date("d.m.Y H:i", time());
            $this->datenbank->beginTransaction();
            $stmt = $this->datenbank->prepare('INSERT INTO KOMMENTAR (KOMMENTARTEXT, DATUM, UID, EID)
                                                VALUES (:text,:datum,(SELECT ACCOUNT.UID FROM ACCOUNT WHERE ACCOUNT.UID = :uid),
                                                                     (SELECT EINTRAG.EID FROM EINTRAG WHERE EINTRAG.EID = :eid))');

            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':datum', $datum);
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':eid', $eid);
            $stmt->execute();
            $this->datenbank->commit();

        } catch (Exception $e) {
            $this->datenbank->rollback();
            return false;
        }
        return false;
    }

    public function kommentareVonEintrag(int $eid): array
    {
        try {
            $this->datenbank->beginTransaction();

            $stmt = $this->datenbank->prepare('SELECT * FROM KOMMENTAR WHERE EID = :eid');
            $stmt->bindParam(':eid', $eid);
            $stmt->execute();

            $this->datenbank->commit();
            $daten = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Füge den Namen hinzu:
            $size = count($daten);
            for ($i = 0; $i < $size; $i++) {
                $name = $this->getAccountNameLogik($daten [$i]["UID"]);
                $daten[$i]["USERNAME"] = $name;
            }
            return $daten;
        } catch (Exception $e) {
            $this->datenbank->rollback();
        }
        return array();
    }

    public function kommentarLoeschen(int $kid): bool
    {
        $erfolg = false;
        try {
            $this->datenbank->beginTransaction();
            $stmt = $this->datenbank->prepare('DELETE FROM KOMMENTAR WHERE KID = :kid');
            $stmt->bindParam(':kid', $kid);
            $erfolg = $stmt->execute();
            $this->datenbank->commit();
        } catch (Exception$e) {
            $this->datenbank->rollback();
        }

        return $erfolg;
    }

    public function isBenutzerName(string $name): bool
    {
        return false;
    }

    public function isEMail(string $mail): bool
    {
        return false;
    }

    public function getAlleName(): array
    {
        $stmt = $this->datenbank->prepare('SELECT NAME FROM ACCOUNT');
        $stmt->execute();
        $ergebnis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array();
    }

}