<?php

interface datenbank_dao
{
    //---Account
    /**
     * gibt zurück ob das anmelden erfolgreich war und welche u_id der User hat
     *
     * return-array: (boolean-Erfolg, UID)
     *
     * @param $email
     * @param $passwort
     * @return array(0 => boolean, 1 => int)
     */
    public function login($email, $passwort): array;


    /**
     * Check, ob die Mail bereits existiert:
     *   -existiert nicht:
     *      -Erstellt einen Eintrag in der Tabelle Account, mit den Daten: NAME: "TMP_ACCOUNT"; PASSWORT: "registrierenID"
     *      -Sendet eine E-Mail an die gegebene Adresse(erstellt eine Datei im Ordner "mail"), welche den Link zur eigentlichen Registrierung enthält
     *   -existiert bereits, Name ist "TMP_ACCOUNT...":
     *      -Updated den Eintrag mit einer neuen "registrierenID" und sendet die Registrierungsmail erneut
     *  -existiert bereits, Name ist nicht "TMP_ACCOUNT...":
     *      -sendet eine Mail an die gegebene Adresse, mit der Information, dass sich jemand mit der E-Mail registrieren wollte.
     *
     * gibt zurück, ob die "Registrierung-Mail" erstellt wurde, oder ob es Probleme mit der Datenbank gab.
     *
     * return-bool
     *
     * @param string $email
     * @return bool
     */
    public function registrierungMail(string $email): bool;


    /**
     * Schließt die Registrierung ab.
     * Der Account-Eintrag, der mit der E-Mail und der registrierenID übereinstimmt, wird mit den neuen Daten überschrieben
     * Der Account wird nicht überschrieben, wenn der Name bereits existiert oder der Name "TMP_ACCOUNT..." ist
     * Gibt die UID zurück oder einen Fehlercode
     *
     * return-int
     *
     * Fehlercodes:
     *      -1 Name vergeben
     *      -2 "Passwort" oder Mail falsch
     *      -3 unbekannter Fehler
     * @param $registrierenID
     * @param string $email
     * @param string $name
     * @param string $passwort
     * @return int
     */
    public function registrierungAbschluss($registrierenID, string $email, string $name, string $passwort): int;


    /**
     * gibt den Namen des Accounts zurück, der zu der Session-uid zurück
     *
     * Fehler: ""
     *
     * return-string NAME
     * @param $uid
     * @return string
     */
    public function getAccountName($uid): string;


    //---Einträge:

    /**
     * Fehler: array()
     *
     * return-array(EID, TITEL,ORIGINALERTITEL, TYP, BESCHREIBUNG, TAGS, DATUM, UID)
     *
     * @param $e_id
     * @return array()
     */
    public function getEintrag($e_id): array;

    /**
     * gibt die Daten für die Index-Übersicht zurück(Titel, EintragsId und Kategorie)
     *
     * Fehler: array()
     *
     * return-array(array(EID,ORIGINALERTITEL, TYP, TITEL)
     *
     * @return array
     */
    public function getDatenIndexUebersicht(): array;

    /**
     * gibt die Daten für die Profil-Übersicht zurück(Titel, EintragsId und Kategorie)p
     *
     * Fehler: array()
     *
     * return-array(array(EID,ORIGINALERTITEL, TYP, TITEL)
     *
     * @param int $uid
     * @return array
     */
    public function getDatenProfilUebersicht(int $uid): array;

    /**
     * bei Fehler: return-int -> -1
     * return-int : EID
     *
     * @param $uid int(u_id aus Session)
     * @param $titel String
     * @param $originalerName String oder leer wenn Text
     * @param $typ String
     * @param $beschreibung String
     * @param $tags String
     * @return int
     */
    public function eintragErstellen(int $uid, string $titel, string $originalerName, string $typ, string $beschreibung, string $tags): int;

    /**
     * Sucht nach Einträgen
     *
     * Fehler: array(array(),array())
     *
     * return-array(array(EID,ORIGINALERTITEL, TYP, TITEL),array(UID, NAME))
     * @param string $suchString
     * @return array
     */
    public function eintraegeSuchen(string $suchString): array;

    /**
     * gibt zurück, ob der Eintrag bearbeitet werden darf
     *
     * @param int $uid
     * @param int $eid
     * @return bool
     */
    public function eintragEditierenErlaubnisCheck(int $uid, int $eid): bool;

    /**
     * return-int:eid oder Fehler
     *
     * Fehlercode:
     *  -1 darf nicht bearbeiten
     *  -2 Update fehlgeschlagen
     *
     *
     * @param int $uid
     * @param int $eid
     * @param string $titel
     * @param string $beschreibung
     * @param string $tags
     * @return int
     */
    public function eintragEditieren(int $uid, int $eid, string $titel, string $beschreibung, string $tags): int;

    /**
     * setzt das Lesezeichen und gibt zurück, ob es erfolgreich war
     *
     * @param int $uid
     * @param int $eid
     * @return bool
     */
    public function lesezeichenSetzen(int $uid, int $eid): bool;

    /**
     * entfernt das Lesezeichen und gibt zurück, ob das Entfernen erfolgreich war.
     * @param int $uid
     * @param int $eid
     * @return bool
     */
    public function lesezeichenEntfernen(int $uid, int $eid): bool;

    /**
     * zeigt an, ob ein Lesezeichen gesetzt ist
     * @param int $uid
     * @param int $eid
     * @return bool
     */
    public function isLesezeichenGesetzt(int $uid, int $eid): bool;

    /**
     * gibt die Daten für die Lesezeichen-Übersicht des Profils zurück
     * (anzeigen der vom User gesetzten Lesezeichen)
     *
     *
     * return-array(array(EID,ORIGINALERTITEL, TYP, TITEL)
     *
     * @param int $uid
     * @return array
     */
    public function getDatenLesezeichenUebersicht(int $uid): array;

    /**
     * return-bool : Erfolg/Misserfolg
     *
     * @param int $uid
     * @param int $eid
     * @param string $text
     * @return bool
     */
    public function kommentarErstellen(int $uid, int $eid, string $text): bool;

    /**
     * gibt die Kommentare eines spezifischen Eintrags zurück
     * neben den Daten aus Tabelle KOMMENTAR auch den userName
     *
     * return-array(array(KID,KOMMENTARTEXT,DATUM,UID, NAME))
     *
     * @param int $eid
     * @return array
     */
    public function kommentareVonEintrag(int $eid): array;

    /**
     * return-bool
     *
     * @param int $kid
     * @param int $uid
     * @return bool
     */
    public function kommentarLoeschen(int $kid, int $uid): bool;

    /**
     * gibt zurück ob der eingegebene Benutzername schon in der Datenbank vorhanden ist oder nicht
     *
     * @param string $name
     * @return bool
     */
    public function isBenutzerName(string $name): bool;


    /**
     * Fehler: array();
     *
     * return-array(array("NAME"))
     *
     * @return array
     */
    public function getAlleName(): array;


    /**
     * löscht den Eintrag, die zugehörigen Kommentare und Lesezeichen
     *
     * return bool
     *
     * @param int $uid
     * @param int $eid
     * @return bool
     */
    public function eintragLoeschen(int $uid, int $eid): bool;

    /**
     * löscht den Account, die verfassten Einträge, die erstellten Kommentare und die Lesezeichen
     *
     * @param int $uid
     * @return bool
     */
    public function accountLoeschen(int $uid): bool;

    /**
     * gibt die Anzahl der Lesezeichen eines Eintrags zurück.
     * return-int
     * bei Fehler : 0
     *
     * @param int $eid
     * @return int
     */
    public function getLeseichenAnzahl(int $eid): int;

    /**
     * Ändere das Passwort
     *
     * @param int $uid
     * @param String $passwortAlt
     * @param String $passwortNeu
     * @return bool
     */
    public function passwortAendern(int $uid, string $passwortAlt, string $passwortNeu): bool;

    /**
     * return-array(EMAIL, NAME)
     *
     * Fehler: array()
     * @param int $uid
     * @return array
     */
    public function getProfilEinstellungDaten(int $uid): array;
}

?>