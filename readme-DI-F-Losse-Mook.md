## Features in der Abgabe
In dieser Abgabe wurde sich hauptsächlich darauf konzentriert, die Fehler der letzten Abgabe zu beheben. 
Z. B. ist es jetzt möglich:
- Einträge zu bearbeiten
- Kommentare zu erstellen und zu löschen
- Lesezeichen zu setzen und zu entfernen
- Wenn der Ordner "Datenbank" gelöscht wird, wird die automatisch neu erstellte Datenbank mit Dummy-Daten befüllt

Darüber hinaus wird dem Nutzer nun angezeigt, wenn ein Nutzername bei der Registrierung schon vergeben ist oder das Passwort und das wiederholte Passwort nicht gleich sind. Wenn ein neuer Eintrag erstellt wird, dann wird der Titel des Eintrages automatisch der Tag-Liste hinzugefügt.

## Zu beachten bei der Ausführung
Die Datenbank wird nur neu erstellt, wenn der komplette Datenbank Ordner gelöscht wird. 

$_SERVER["DOCUMENT-ROOT"] wird dreimal verwendet, daher kann es vorkommen, dass die Pfade in den Methoden datenbankBeispieleErstellen() und __construct() in der Datei sqlite_dao.php angepasst werden müssen. 

## Bekannte Fehler
- CSS ist teilweise noch fehlerhaft
- SQL-Fehler werden teilweise noch nicht abgefangen
- dummy_dao wurde noch nicht gefixt
- Einträge/Account lassen sich noch nicht löschen
- Accountdaten sind noch nicht bearbeitbar
- Die Überprüfung, ob ein Benutzername schon vergeben ist, ist momentan noch hardgecodet
- Aufgabe 7 (Ajax) wurde nicht bearbeitet
