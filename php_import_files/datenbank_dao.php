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
     * legt den User in der Datenbank an und gibt den Fehlercode und die UID zurück
     *
     * Fehlercodes:
     *      0 Erfolg
     *      1 E-Mail existiert bereits
     *      2 Name existiert bereits
     *      3 unbekannter Fehler
     *
     * return-array: (Fehlercode, UID)
     *
     * @param $email
     * @param $name
     * @param $passwort
     * @return array(0 => int, 1 => int)
     */
    public function registrieren($email, $name, $passwort): array;

    /**
     * gibt den Namen des Accounts zurück, der zu der Session-uid zurück
     *
     * return-string NAME
     * @param $uid
     * @return string
     */
    public function getAccountName($uid): string;


    //---Einträge:

    /**
     * return-array(EID, TITEL,ORIGINALERTITEL, TYP, BESCHREIBUNG, TAGS, DATUM, UID)
     * @param $e_id
     * @return array()
     */
    public function getEintrag($e_id): array;

    /**
     * gibt die Daten für die Index-Übersicht zurück(Titel, EintragsId und Kategorie)
     *
     * return-array(array(EID,ORIGINALERTITEL, TYP, TITEL)
     *
     * @return array
     */
    public function getDatenIndexUebersicht(): array;

    /**
     * gibt die Daten für die Profil-Übersicht zurück(Titel, EintragsId und Kategorie)p
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
     * gibt die Daten für die Lesezeichen-Übersicht zurück
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
     * return-array(array(KID,KOMMENTARTEXT,DATUM,UID, USERNAME))
     *
     * @param int $eid
     * @return array
     */
    public function kommentareVonEintrag(int $eid): array;

    /**
     * return-bool
     *
     * @param int $kid
     * @return bool
     */
    public function kommentarLoeschen(int $kid): bool;

    /**
     * gibt zurück ob der eingegebene Benutzername schon in der Datenbank vorhanden ist oder nicht
     *
     * @param string $name
     * @return bool
     */
    public function isBenutzerName(string $name):bool;

    /**
     * gibt zurück ob die eingegebene Emailadresse schon in der Datenbank vorhanden ist oder nicht
     *
     * @param string $mail
     * @return bool
     */
    public function isEMail(string $mail):bool;

    /**
     * return-array(array("NAME"))
     *
     * @return array
     */
    public function getAlleName():array;
}

?>