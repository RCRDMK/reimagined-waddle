<?php
require_once('datenbank_dao.php');

class sqlite_dao implements datenbank_dao
{
    private $defaultDatabasePath;
    private $databasefilename = 'database.sqlite';
    private $datenbank;


    public function __construct()
    {
        try {
            if (file_exists("./datenbank/")) {
                $this->defaultDatabasePath = "./datenbank/";
            } else {
                $this->defaultDatabasePath = "../datenbank/";
            }
            $this->connectToDB();
        } catch (Error) {
            echo "Datenbank konnte nicht verbunden werden";
        }
    }

    /**
     * stellt die Verbindung zur Datenbank her.
     *
     * Erstellt die Datenbank neu und löscht den Inhalt des upload Ordners, wenn die Datenbank fehlt.
     *
     * @return void
     */

    function connectToDB(): void
    {
        if (!file_exists($this->defaultDatabasePath . "/database.sqlite")) {
            //Alte Inhalte von Upload Ordner löschen
            $files = glob("$this->defaultDatabasePath" . "/upload/*"); //alle Dateien
            foreach ($files as $file) {//alle Dateien löschen
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $this->createTabelle();
        } else {
            $this->datenbank = new PDO('sqlite:' . $this->defaultDatabasePath . '/' . $this->databasefilename);
        }
    }


    /**
     * Erstellt die Datenbank und befüllt sie mit Beispielen
     *
     * @return void
     */
    private function createTabelle()
    {
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
    }

    /**
     * füllt die Datenbank mit Beispielen
     * @return void
     */
    private function datenbankBeispieleErstellen(): void
    {
        //Pfade
        $dateiOriginalOrdner = "./datenbankBspInhalte/";//$_SERVER["DOCUMENT_ROOT"] . $this->projektOrdner . "datenbankBspInhalte/";
        $dateiNeuerOrdner = "./datenbank/upload/";//$_SERVER["DOCUMENT_ROOT"] . $this->projektOrdner . "datenbank/upload/";

        //User
        $pw = password_hash("123", PASSWORD_DEFAULT);


        $mail = "magnat@mail.de";
        $name = "Der Schienen Magnat";
        $stmt = $this->datenbank->prepare('INSERT INTO ACCOUNT (EMAIL, NAME, PASSWORT)  VALUES (:mail, :name, :pw)');
        $stmt->bindParam(":mail", $mail);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":pw", $pw);
        $stmt->execute();

        $mail = "muster@mail.de";
        $name = "Max Muster";
        $stmt = $this->datenbank->prepare('INSERT INTO ACCOUNT (EMAIL, NAME, PASSWORT)  VALUES (:mail, :name, :pw)');
        $stmt->bindParam(":mail", $mail);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":pw", $pw);
        $stmt->execute();

        $mail = "sammler@mail.de";
        $name = "Sammler";
        $stmt = $this->datenbank->prepare('INSERT INTO ACCOUNT (EMAIL, NAME, PASSWORT)  VALUES (:mail, :name, :pw)');
        $stmt->bindParam(":mail", $mail);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":pw", $pw);
        $stmt->execute();

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
        $eidReg = $this->eintragErstellen(2, "Tutorial Registrieren", "registrieren.mp4", "video", "So registriert man sich", "Video;Tutorial;registrieren");
        copy($dateiOriginalOrdner . "registrieren.mp4", $dateiNeuerOrdner . $eidReg . ".mp4");


        //Einträge "Sammler"
        $eidMini = $this->eintragErstellen(3, "Miniaturen", "sammler.jpeg", "bild", "Figuren aus der Sammlung", "Miniaturen; Hobby");
        copy($dateiOriginalOrdner . "sammler.jpeg", $dateiNeuerOrdner . $eidMini . ".jpeg");

        $eidGel1 = $this->eintragErstellen(3, "Gelände-Stück", "sammler2.jpeg", "bild", "Ein Geländestück für Miniaturen", "Miniaturen; Hobby");
        copy($dateiOriginalOrdner . "sammler2.jpeg", $dateiNeuerOrdner . $eidGel1 . ".jpeg");

        $eidGel2 = $this->eintragErstellen(3, "Noch mehr Gelände", "sammler3.jpeg", "bild", "Ein weiters Geländestück. Es ist auch rot.", "Miniaturen; Hobby; rot");
        copy($dateiOriginalOrdner . "sammler3.jpeg", $dateiNeuerOrdner . $eidGel2 . ".jpeg");


        //Lesezeichen "Magnat"
        $this->lesezeichenSetzen(1, $eidActor);
        $this->lesezeichenSetzen(1, $eidVisio);

        //Lesezeichen "Max Muster"
        $this->lesezeichenSetzen(2, $eidRailSt);

        //Lesezeichen "Sammler"
        $this->lesezeichenSetzen(3, $eidObst);
        $this->lesezeichenSetzen(3, $eidDepStat);


        //Kommentare "Sammler"

        //Kommentare "Magnat"
        $this->kommentarErstellen(1, $eidActor, "Ich habe dafür länger gebraucht, als mir lieb ist!");
        $this->kommentarErstellen(1, $eidVisio, "Ein so originelles Werk habe ich noch nie gesehen :)");
        //Kommentare "Max Muster"
        $this->kommentarErstellen(2, $eidActor, "Ein Meisterwerk der Kunstgeschichte");
        $this->kommentarErstellen(2, $eidObst, "Der Ersteller hatte hatte wohl Beispielgraphen für Globalemaxima im Kopf, als er das gemalt hat");
        $this->kommentarErstellen(2, $eidDepStat, "Der Maler dieses 'Paint'ings wollte sich wahrscheinlich nicht mit Lizenzen auseinander setzen");


    }


    public function registrierungMail(string $email): bool
    {
        $success = false;
        try {
            try {
                $this->datenbank->beginTransaction();
                $stmt_isMail = $this->datenbank->prepare('SELECT NAME FROM ACCOUNT WHERE EMAIL = :mail');
                $stmt_isMail->bindParam(':mail', $email);
                $stmt_isMail->execute();
                $name = $stmt_isMail->fetchAll(PDO::FETCH_ASSOC);
                $tmpName = "TMP_ACCOUNT" . $email;
                if (empty($name)) {//Erstelle den Temporären Account
                    $registrierenID = random_int(1000000000000000000, PHP_INT_MAX);
                    $passwort = password_hash($registrierenID, PASSWORD_DEFAULT);
                    $name = $tmpName;
                    $stmt_Create = $this->datenbank->prepare('INSERT INTO ACCOUNT(EMAIL, NAME, PASSWORT) VALUES (:mail, :name, :password)');
                    $stmt_Create->bindParam(':mail', $email);
                    $stmt_Create->bindParam(':name', $name);
                    $stmt_Create->bindParam(':password', $passwort);
                    if ($stmt_Create->execute()) {
                        $success = $this->sendeRegistrierungsMail($registrierenID, $email);
                    }
                } else if ($name[0]["NAME"] === $tmpName) {//Update den Temporären Account, wenn noch eine Anfrage kommt
                    $registrierenID = random_int(1000000000000000000, PHP_INT_MAX);
                    $passwort = password_hash($registrierenID, PASSWORD_DEFAULT);

                    $stmt_Update = $this->datenbank->prepare('UPDATE ACCOUNT SET PASSWORT = :passwort WHERE EMAIL = :mail');
                    $stmt_Update->bindParam(':passwort', $passwort);
                    $stmt_Update->bindParam(':mail', $email);
                    if ($stmt_Update->execute()) {
                        $success = $this->sendeRegistrierungsMail($registrierenID, $email);
                    }
                } else {//Informiere den User über einen Registrierungsversuch
                    $success = $this->sendeRegistrierungsVersuchInformation($email);
                }
                $this->datenbank->commit();

                return $success;
            } catch (Exception $e) {
                $this->datenbank->rollBack();
                return $success;
            }
        } catch (Error $e) {
            return $success;
        }
    }


    private function sendeRegistrierungsMail($uniqueID, $email): bool
    {
        $name = substr($email, 0, strpos($email, "@"));
        //$pfad = "../registrieren.php?reg=". $uniqueID;//
        // $pfad = "localhost" . dirname($_SERVER["PHP_SELF"], 2) . "/registrieren.php?reg=" . $uniqueID;
        //$pfad = "localhost:" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["PHP_SELF"], 2) . "/registrieren.php?reg=" . $uniqueID;

        $pfad = $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"], 2) . "/registrieren.php?reg=" . $uniqueID;

        $mail = fopen("../mail/registrieren_" . $name . ".txt", "w");
        if ($mail == false) {
            return false;
        }
        $txt = "Registriere dich unter: \n" . $pfad . "\nVerwende die E-Mail-Adresse \"" . $email . "\"";
        fwrite($mail, $txt);
        return fclose($mail);
    }

    private function sendeRegistrierungsVersuchInformation($email): bool
    {
        $name = substr($email, 0, strpos($email, "@"));
        $mailFile = fopen("../mail/registrieren_info_" . $name . ".txt", "w");
        if ($mailFile == false) {
            return false;
        }
        $txt = "Bitte ignoriere die E-Mail, wenn du es nicht warst, der sich versucht hat zu registrieren.\nDu bist aber bereits registriert.\nSolltest du dein Password vergessen habe, klicke bitte hier\n(Passwort via Mail ändern funktioniert noch nicht) ";
        fwrite($mailFile, $txt);
        return fclose($mailFile);
    }


    public function registrierungAbschluss($registrierenID, $email, $name, $passwort): int
    {
        $rueckgabe = -3;
        try {
            try {
                $this->datenbank->beginTransaction();
                $stmt_Name = $this->datenbank->prepare('SELECT * FROM ACCOUNT WHERE NAME = :name');
                $stmt_Name->bindParam(":name", $name);
                $stmt_Name->execute();
                $tmpName = "TMP_ACCOUNT" . $email;
                if (empty($stmt_Name->fetchAll(PDO::FETCH_ASSOC)) && $name !== $tmpName && $name != "TMP_ACCOUNT") {//existiert der Name bereits?
                    $stmt_Mail = $this->datenbank->prepare('SELECT UID, PASSWORT FROM ACCOUNT WHERE EMAIL = :mail');
                    $stmt_Mail->bindParam(":mail", $email);
                    $stmt_Mail->execute();
                    $accountDaten = $stmt_Mail->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($accountDaten)) {//gibt es die E-Mail?
                        if (password_verify($registrierenID, $accountDaten[0]["PASSWORT"])) {//stimmt die registrierenID überein?
                            $passwortNeu = password_hash($passwort, PASSWORD_DEFAULT);
                            $stmt_Registrieren = $this->datenbank->prepare('UPDATE ACCOUNT SET NAME= :name, PASSWORT= :passwort WHERE EMAIL = :mail');
                            $stmt_Registrieren->bindParam(':name', $name);
                            $stmt_Registrieren->bindParam(':passwort', $passwortNeu);
                            $stmt_Registrieren->bindParam(':mail', $email);
                            if ($stmt_Registrieren->execute()) {
                                $rueckgabe = $accountDaten[0]["UID"];
                            }

                        } else {
                            $rueckgabe = -2;
                        }
                    } else {
                        $rueckgabe = -2;
                    }
                } else {
                    $rueckgabe = -1;
                }
                $this->datenbank->commit();

            } catch (Exception $e) {
                $this->datenbank->rollBack();
            }
        } catch (Error $e) {
        }
        return $rueckgabe;
    }


    public function login($email, $passwort): array
    {
        try {
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

        } catch (Exception|Error $e) {
            return array(false, -1);
        }
    }


    public function getAccountName($uid): string
    {
        return $this->getAccountNameLogik($uid);
    }

    private function getAccountNameLogik($uid): string
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT NAME FROM ACCOUNT WHERE UID == :u_id');
            $stmt->bindParam('u_id', $uid);
            $stmt->execute();
            $fetchArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($fetchArray)) {
                return $fetchArray[0]["NAME"];

            }
            return "";
        } catch (Exception|Error $e) {
            return "";
        }
    }

    public function getEintrag($e_id): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT * FROM EINTRAG WHERE EID == :eid');
            $stmt->bindParam(':eid', $e_id);
            $stmt->execute();
            $eintrag = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($eintrag)) {
                return $eintrag[0];
            }
            return array();
        } catch (Exception|Error $e) {
            return array();
        }
    }

    public function getDatenIndexUebersicht(): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception|Error $e) {
            return array();
        }
    }

    public function getDatenProfilUebersicht($uid): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG WHERE UID == :u_id');
            $stmt->bindParam('u_id', $uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception|Error $e) {
            return array();
        }
    }


    public function eintragErstellen($uid, $titel, $originalerName, $typ, $beschreibung, $tags): int
    {
        $eid = -1;
        try {//Error von beginTransaction/rollback wird abgefangen
            try {//Exception innerhalb von Transaktion
                $this->datenbank->beginTransaction();
                $datum = date("d.m.Y", time());
                $sql = 'INSERT INTO EINTRAG(TITEL, ORIGINALERNAME, TYP, BESCHREIBUNG, TAGS, DATUM, UID)' . 'VALUES(:titel,:inhalt, :typ,:beschreibung, :tags, :datum, :uid);';
                $stmt = $this->datenbank->prepare($sql);
                $stmt->bindParam(':titel', $titel);
                $stmt->bindParam(':inhalt', $originalerName);
                $stmt->bindParam(':typ', $typ);
                $stmt->bindParam(':beschreibung', $beschreibung);
                $stmt->bindParam(':tags', $tags);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':uid', $uid);
                if ($stmt->execute()) {
                    $eid = $this->datenbank->lastInsertId();
                }
                $this->datenbank->commit();
            } catch (Exception $e) {
                $this->datenbank->rollback();
            }
        } catch (Error $e) {

        }
        return $eid;
    }

    public function eintraegeSuchen(string $suchString): array
    {
        try {
            try {
                $this->datenbank->beginTransaction();

                //Durchsuche Einträge:
                $sucheEintragString = "%" . $suchString . "%";
                $stmtEintrag = $this->datenbank->prepare('SELECT EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG WHERE TITEL LIKE :suchEintragString OR BESCHREIBUNG LIKE :suchEintragString OR TAGS LIKE :suchEintragString');
                $stmtEintrag->bindParam(':suchEintragString', $sucheEintragString);
                $stmtEintrag->execute();
                $eintraege = $stmtEintrag->fetchAll(PDO::FETCH_ASSOC);

                //Durchsuche Profile
                $sucheProfilString = "%" . $suchString . "%";
                $verboten = "TMP_ACCOUNT%";
                $stmtProfil = $this->datenbank->prepare('SELECT UID, NAME FROM ACCOUNT WHERE NAME LIKE :suchProfilString AND NAME NOT LIKE :verboten');
                $stmtProfil->bindParam(':suchProfilString', $sucheProfilString);
                $stmtProfil->bindParam(':verboten', $verboten);
                $stmtProfil->execute();
                $profile = $stmtProfil->fetchAll(PDO::FETCH_ASSOC);
                $this->datenbank->commit();
                return array($eintraege, $profile);
            } catch (Exception $e) {
                $this->datenbank->rollback();
                return array(array(), array());
            }
        } catch (Error $e) {
            return array(array(), array());
        }
    }

    public function eintragEditierenErlaubnisCheck(int $uid, int $eid): bool
    {
        return $this->eintragEditierenErlaubnisCheckLogik($uid, $eid);
    }

    private function eintragEditierenErlaubnisCheckLogik(int $uid, int $eid): bool
    {
        try {
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
        } catch (Exception|Error $e) {
            return false;
        }
    }

    public function eintragEditieren(int $uid, int $eid, string $titel, string $beschreibung, string $tags): int
    {
        try {
            try {
                $this->datenbank->beginTransaction();
                if (!$this->eintragEditierenErlaubnisCheckLogik($uid, $eid)) {
                    return -1;
                }
                $stmt = $this->datenbank->prepare('UPDATE EINTRAG SET TITEL = :titel, BESCHREIBUNG = :beschreibung, TAGS = :tags WHERE EID = :eid; ');
                $stmt->bindParam(':titel', $titel);
                $stmt->bindParam(':beschreibung', $beschreibung);
                $stmt->bindParam(':tags', $tags);
                $stmt->bindParam(':eid', $eid);
                $executeErfolgreich = $stmt->execute();
                $this->datenbank->commit();
                if ($executeErfolgreich) {
                    return $eid;
                } else {
                    return -2;
                }
            } catch (Exception $e) {
                $this->datenbank->rollback();
                return -2;
            }
        } catch (Error $e) {
            return -2;
        }
    }

    public function lesezeichenSetzen(int $uid, int $eid): bool
    {
        try {
            try {
                $this->datenbank->beginTransaction();
                if (!$this->isLesezeichenGesetztLogik($uid, $eid)) {

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
                }
            } catch (Exception $e) {
                $this->datenbank->rollback();
                return false;
            }
        } catch (Error $e) {

        }
        return false;
    }

    public function lesezeichenEntfernen(int $uid, int $eid): bool
    {
        try {
            try {
                $this->datenbank->beginTransaction();
                if ($this->isLesezeichenGesetztLogik($uid, $eid)) {

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
                }
            } catch (Exception $e) {
                $this->datenbank->rollback();
                return false;
            }
        } catch (Error $e) {

        }
        return false;
    }


    public function isLesezeichenGesetzt(int $uid, int $eid): bool
    {
        return $this->isLesezeichenGesetztLogik($uid, $eid);
    }

    private function isLesezeichenGesetztLogik(int $uid, int $eid): bool
    {
        try {
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
        } catch (Exception|Error $e) {
            return false;
        }
    }


    public function getDatenLesezeichenUebersicht(int $uid): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT EINTRAG.EID, TITEL, ORIGINALERNAME, TYP FROM EINTRAG JOIN LESEZEICHEN L on EINTRAG.EID = L.EID WHERE L.UID = :uid');
            $stmt->bindParam(':uid', $uid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception|Error $e) {
            return array();
        }
    }

    public function kommentarErstellen(int $uid, int $eid, string $text): bool
    {
        try {
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
                return true;
            } catch (Exception $e) {
                $this->datenbank->rollback();
                return false;
            }
        } catch (Error $e) {
            return false;
        }
    }

    public function kommentareVonEintrag(int $eid): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT KID,KOMMENTARTEXT,DATUM,A.UID, A.NAME FROM KOMMENTAR LEFT JOIN ACCOUNT A on KOMMENTAR.UID = A.UID WHERE EID = :eid');
            $stmt->bindParam(':eid', $eid);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception|Error $e) {
            return array();
        }
    }

    public function kommentarLoeschen(int $kid, int $uid): bool
    {
        try {
            try {
                $this->datenbank->beginTransaction();
                $stmt = $this->datenbank->prepare('DELETE FROM KOMMENTAR WHERE KID = :kid AND UID=:uid');
                $stmt->bindParam(':kid', $kid);
                $stmt->bindParam(':uid', $uid);
                $erfolg = $stmt->execute();
                $this->datenbank->commit();
                return $erfolg;
            } catch (Exception$e) {
                $this->datenbank->rollback();
                return false;
            }
        } catch (Error $e) {
            return false;
        }
    }

    public function isBenutzerName(string $name): bool
    {
        try {
            $stmt = $this->datenbank->prepare("SELECT NAME FROM ACCOUNT WHERE  :name = NAME");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            if (!empty($stmt->fetchAll(PDO::FETCH_ASSOC))) {
                return true;
            }
            return false;
        } catch (Exception|Error $e) {
            return false;
        }
    }

    public function getAlleName(): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT NAME FROM ACCOUNT');
            $stmt->execute();
            $ergebnis = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($ergebnis)) {
                return $ergebnis;
            }
            return array();
        } catch (Exception|Error $e) {
            return array();
        }
    }

    public function eintragLoeschen(int $uid, int $eid): bool
    {
        try {
            return $this->eintraegeLoeschenLogik($uid, $eid);
        } catch (Exception|Error $e) {
            return false;
        }
    }

    /**
     * löscht den Eintrag, die zugehörigen Kommentare und Lesezeichen
     *
     * ACHTUNG: keine Error/Exception Handling oder Transaktion
     *          !!!Methodenaufruf muss innerhalb von Transaktion stattfinden!!!
     *
     * return bool
     * @param int $uid
     * @param int $eid
     * @return bool
     */
    private function eintraegeLoeschenLogik(int $uid, int $eid): bool
    {//Transaktion und Error abfangen wurde rausgenommen, da es innerhalb anderer Transaktionen verwendbar sein muss
        //Check, ob Eintrag löschbar ist
        $stmtLoeschErlaubnis = $this->datenbank->prepare('SELECT * FROM EINTRAG WHERE :uid = UID AND :eid = EID');
        $stmtLoeschErlaubnis->bindParam(':uid', $uid);
        $stmtLoeschErlaubnis->bindParam(':eid', $eid);
        $stmtLoeschErlaubnis->execute();
        if (!empty($stmtLoeschErlaubnis->fetchAll(PDO::FETCH_ASSOC))) {
            //Lesezeichen löschen
            $stmtLesezeichenLoeschen = $this->datenbank->prepare("DELETE FROM LESEZEICHEN WHERE :eid = EID");
            $stmtLesezeichenLoeschen->bindParam(':eid', $eid);
            $stmtLesezeichenLoeschen->execute();
            //Kommentare löschen

            $stmtKommentarLoeschen = $this->datenbank->prepare("DELETE FROM KOMMENTAR WHERE :eid = EID");
            $stmtKommentarLoeschen->bindParam(':eid', $eid);
            $stmtKommentarLoeschen->execute();
            //Inhalt aus upload Ordner entfernen
            $stmtInhalt = $this->datenbank->prepare("SELECT TYP, ORIGINALERNAME FROM EINTRAG WHERE EID = :eid");
            $stmtInhalt->bindParam(':eid', $eid);
            $stmtInhalt->execute();
            $info = $stmtInhalt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($info)) {
                $typ = $info[0]["TYP"];
                if ($typ != "text") {
                    $originalName = $info[0]["ORIGINALERNAME"];
                    $fileEndung = "." . substr($originalName, strrpos($originalName, '.') + 1);
                    $pfad = $this->defaultDatabasePath . '/upload/' . $eid . $fileEndung;
                    if (is_file($pfad)) {
                        echo unlink($pfad);
                    }
                }
            }
            //Eintrag aus Datenbank löschen
            $stmtEintragLoeschen = $this->datenbank->prepare("DELETE FROM EINTRAG WHERE :eid = EID");
            $stmtEintragLoeschen->bindParam(':eid', $eid);
            $stmtEintragLoeschen->execute();
        }
        return true;
    }

    public function accountLoeschen(int $uid): bool
    {
        try {
            try {
                $this->datenbank->beginTransaction();

                //Kommentare Löschen
                $stmtKommentareloeschen = $this->datenbank->prepare("DELETE FROM KOMMENTAR WHERE UID = :uid");
                $stmtKommentareloeschen->bindParam(":uid", $uid);
                $stmtKommentareloeschen->execute();

                //Lesezeichen löschen
                $stmtLesezeichenLoeschen = $this->datenbank->prepare("DELETE FROM LESEZEICHEN WHERE UID = :uid");
                $stmtLesezeichenLoeschen->bindParam(":uid", $uid);
                $stmtLesezeichenLoeschen->execute();

                //select alle Einträge von Account
                $stmtgetEintraege = $this->datenbank->prepare("SELECT EID FROM EINTRAG WHERE UID = :uid");
                $stmtgetEintraege->bindParam(":uid", $uid);
                $stmtgetEintraege->execute();
                $eidArray = $stmtgetEintraege->fetchAll(PDO::FETCH_ASSOC);

                //lösche alle Einträge
                foreach ($eidArray as $key) {
                    $this->eintraegeLoeschenLogik($uid, $key["EID"]);
                }

                //Account löschen
                $stmtAccountLoeschen = $this->datenbank->prepare("DELETE FROM ACCOUNT WHERE UID = :uid");
                $stmtAccountLoeschen->bindParam(":uid", $uid);
                $stmtAccountLoeschen->execute();

                $this->datenbank->commit();
                return true;
            } catch (Exception $e) {
                $this->datenbank->rollback();
            }

        } catch (Error $e) {

        }
        return false;
    }

    public function getLeseichenAnzahl(int $eid): int
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT COUNT(*) as anzahl FROM LESEZEICHEN WHERE EID = :eid');
            $stmt->bindParam(":eid", $eid);
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["anzahl"];
            } else {
                return 0;
            }
        } catch (Exception|Error $e) {
            return 0;
        }
    }

    public function passwortAendern(int $uid, string $passwortAlt, string $passwortNeu): bool
    {
        try {
            try {
                $erfolg = false;
                $this->datenbank->beginTransaction();
                $stmtPwCheck = $this->datenbank->prepare("SELECT PASSWORT FROM ACCOUNT WHERE UID = :uid");
                $stmtPwCheck->bindParam(":uid", $uid);
                $stmtPwCheck->execute();
                $pw = $stmtPwCheck->fetchALL(PDO::FETCH_ASSOC)[0]["PASSWORT"];
                if (!empty($pw) && password_verify($passwortAlt, $pw)) {
                    $pwNeuHashed = password_hash($passwortNeu, PASSWORD_DEFAULT);

                    $stmtPwAendern = $this->datenbank->prepare("UPDATE ACCOUNT SET PASSWORT = :pwNeuHashed WHERE UID = :uid");
                    $stmtPwAendern->bindParam(":pwNeuHashed", $pwNeuHashed);
                    $stmtPwAendern->bindParam(":uid", $uid);
                    $erfolg = $stmtPwAendern->execute();


                }
                $this->datenbank->commit();
                return $erfolg;
            } catch (Exception $e) {
                $this->datenbank->rollback();
                return false;
            }
        } catch (Error $e) {
            return false;
        }
    }

    public function getProfilEinstellungDaten(int $uid): array
    {
        try {
            $stmt = $this->datenbank->prepare('SELECT NAME, EMAIL FROM ACCOUNT WHERE UID = :uid');
            $stmt->bindParam(":uid", $uid);
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            } else {
                return array();
            }
        } catch (Exception|Error $e) {
            return array();
        }
    }


}