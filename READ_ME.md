## Studenten:

- Alexander Losse
- Ricardo Mook

## Vorausetzungen:

- Beispiel-Accounts:
    - Der Schienen Magnat
        - E-Mail: magnat@mail.de
        - Passwort: 123
    - Max Muster
        - E-Mail: muster@mail.de
        - Passwort: 123
      
Die Datenbank wird neu erstellt, wenn die Datei database.sqlite gelöscht wird.
  - Durch das Erstellen der Datenbank wird der alte Inhalt des Ordners upload gelöscht.

Das Projekt wurde nur mit XAMPP getestet

Erlaubte Dateiformate zum hochladen:
- Bilder: .jpg, .jpeg, .gif, .png
- Video: .ogg, .mp4, .webm
- Dokumente: .pdf


- Registrieren:
    - Schritt 1:
        - Eingabe der E-Mail-Adresse in registrieren.php
    - Bei Erfolg wird eine Datei im Ordner mail angelegt
        - E-Mail bereits registriert:
            - registrieren_info_xy.txt wird angelegt
        - E-Mail noch nicht registriert / Registrierung nicht abgeschlossen
            - registrieren_xy.txt wird angelegt / überschrieben
            - beinhaltet den Link zu registrieren.php?reg="registrierenID"
            - registrierenID wird bei jedem "verschicken der Mail" neu erstellt

    - Schritt 2:
        - Nochmalige Eingabe der E-Mail-Adresse
        - Auswahl von Nutzername und Passwort
        - Abschließen der Registration ist nur in der korrekten Kombination von registrierenID und der E-Mail-Adresse
          möglich

## Begriffsdefinition:

- Eintrag: Der Inhalt mit den weiteren Informationen(u.a. Titel, Kommentarbereich)
- Inhalt: Das Bild, Video oder Dokument

## Funktionen/Sitemap:

- index.php:
    - Startseite
    - Übersicht über alle Einträge
        - sortieren nach: Neu - Alt - Beste
        - filtern nach: Alle - Bilder - Videos - Dokumente

- anmelden.php:
    - anmelden mit einem bestehenden Account
    - Link zu registrieren.php

- registrieren.php:
    - Ansicht 1 (kein ?reg=):
        - Eingabe einer E-Mail für das Registrieren
    - Ansicht 2 (?reg=mail):
        - Information über das Verschicken einer E-Mail an die angegebene Adresse
    - Ansicht 3 (?reg="registrierenID"):
        - Eingabe aller notwendigen Daten für das Abschließen des Registrierens

- impressum.php:
    - Das Impressum

- eula.php:
    - Die Nutzungsbedingungen

- datenschutz.php:
    - Die Datenschutzerklärung

- eintrag.php:
    - Anzeige eines vom User erstellten Eintrags
    - Lesezeichen setzen durch angemeldete Nutzer
    - Eintrag-Eigentümer können diesen bearbeiten oder löschen
    - Kommentarbereich
        - sortieren Neu - Alt
        - angemeldete User können Kommentare schreiben
        - eigene Kommentare können gelöscht werden
- eintrag_bearbeiten.php:
    - Möglichkeit den Titel, Beschreibungstext und die Tags zu ändern

- eintrag_neu.php:
    - Möglichkeit einen Eintrag zu erstellen

- profil.php:
    - Ansicht 1:
        - Anzeigen eines fremden Profils
        - Übersicht über die vom Profil-Eigentümers erstellten Einträge
        - sortieren nach: Neu - Alt - Beste
        - filtern nach: Alle - Bilder - Videos - Dokumente
    - Ansicht 2:
        - Anzeige des eigenen Profils
        - Weiterleitung zum Erstellen neuer Einträge
        - Weiterleitung zu den Profil-Einstellungen
        - Wechsel zwischen Lesezeichen- und Eigene-Einträge-Übersicht
        - Ansicht Eigene-Einträge:
            - Übersicht über die eigenen Einträge
            - sortieren nach: Neu - Alt - Beste
            - filtern nach: Alle - Bilder - Videos - Dokumente
        - Ansicht Lesezeichen:
            - Übersicht über die vom Nutzer gesetzten Lesezeichen
            - sortieren nach: Neu - Alt - Beste
            - filtern nach: Alle - Bilder - Videos - Dokumente
- profil_einstellungen.php:
    - Ansicht mit den Nutzerdaten
    - Möglichkeit Passwort zu ändern
    - Möglichkeit Account zu löschen
- suche.php:
    - Anzeige der Suchergebnisse:
    - Übersicht über die gefundenen Profile
    - Übersicht über die gefundenen Einträge
        - sortieren nach: Neu - Alt - Beste
        - filtern nach: Alle - Bilder - Videos - Dokumente

## Javascript

- Jquery mithilfe der Datei jquery-3.6.0.js eingebunden:
    - https://code.jquery.com/jquery-3.6.0.js am 24.07.2022
- Sortieren und Filtern der Übersichten
- Sortieren der Kommentare
- Überprüfen, ob die Passwörter beim Registrieren identisch sind
- Ajax:
    - Überprüfen, ob der Nutzername bereits vergeben ist (registrieren.php?reg="registrierenID")

## fehlende Funktionen / Fehler:

- Bei der Erstellung eines neuen Eintrags wird der Datei auswählen Button nicht in CSS dargestellt.
- "Aufgabe 8: Nutzung von Diensten: WebServices und APIs" wurde nicht bearbeitet.
- Es ist nicht möglich, dass Passwort per E-Mail zurückzusetzen
- Die Suche lässt sich nicht filtern.
- Die Darstellung des Dokuments auf kleinen Bildschirmen funktioniert nicht wie gewollt
- Wave-Fehler: "empty form label", das leere Label wird verwendet um das "x" und das "Burgermenu" bei kleinen
  Bildschirmen darzustellen. Daher kann es nicht befüllt werden.
- "Eintrag erstellen" JavaScript: titelInTagAutomatisch(). ";" in Kombination mit Text wird falsch in, die Tag-Liste
  übertragen
- In der mobilen Ansicht kann es zu leichtem Sidescrolling kommen. Der Grund hierfür ist nicht bekannt, da alle Elemente 
  die Breite von dem mobilen Bildschirm haben und es keinen (sichtbaren) Overflow gibt.
