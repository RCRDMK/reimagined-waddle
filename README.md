<h1 align="center"> ReiWa: Eine Kunstausstellung für jedermann!</h1>

<h2 align="center"> English version follows the German one</h2>

Im Rahmen eines Universitätsmodul der Carl-von-Ossietzky Universität Oldenburg wurde diese Webseite entwickelt. Die gestellte Aufgabe war eine digitale Kunstausstellung zu entwickeln. Da Kunst sich aber nicht definieren lässt, sind auf dieser Seite Kunst jeglicher Art willkommen. Ins besondere sind die Künste von Amateuren willkommen, um ihnen einen Platz zu geben, ihre Künste ohne Angst ausstellen zu können. Die anvisierte Zielgruppe sind hier junge Künstler, welche sich durch Bilder, Videos und Dokumenten künstlerisch ausdrücken können.

Sofern nicht anders angemerkt, wurde sämtlicher Code selber geschrieben.

## Voraussetzungen

Für dieses Projekt wurde PHP 8 verwendet. Im Backend befinden sich SQLite und jQuery 3.6.0 um Beiträge abzuspeichern und diese auch zu durchsuchen. Es wurden darüber hinaus jedoch keine Frameworks oder Bibliotheken benutzt, sondern einzig und allein die Funktionen von HTML, PHP 8 und Javascript. Da es sich um eine Abgabe für ein Modul handelt, lässt sich dieses Projekt komplett als localhost ausführen.

## Über das Projekt

Wie zu sehen ist, sind gleich schon auf der Index Beiträge zu sehen, um den Nutzer so schnell wie möglich mit anderen interagieren zu lassen. Ein Bneutzerkonto nur nötig, wenn selbst Kunst hochgeladen werden soll, ein Kommentar zu einem Kunstwerk zu machen oder sich dieses als "Lesezeichen" für später abzuspeichern. Selbstverständlich ist die Seite auch für den mobilen Gebrauch angepasst. Von Bootstrap inspiriet befinden sich die Media-Queries hier bei 768px, welches den Footer verschwinden und ein Hamburger-Menü zur leichteren Navigation erscheinen lässt.

Beim ersten Starten wird eine beispielhafte Datenbank erstellt und mit Einträgen befüllt, sodass schon zu Beginn sich das ungefähre Look & Feel der Seite erahnen lässt, ohne dass man erst mühsam die Datenbank befüllen muss. Selbst wenn die Datenbank gelöscht wird, wird sie beim nächsten Start wieder neu erstellt und mit den beispielhaften Einträgen gefüllt. Gültige Dateiformate für Einträge sind für Bilder .jpg, .jpeg, .gif, .png, für Videos .ogg, .mp4, .webm und für Dokumente .pdf Formate. Auch Nutzer sind hier schon vorhanden, sodass man sich nicht neu registrieren muss, um die komplette Seite zu benutzen. 

Falls man sich aber doch registrieren möchte, so geht man zuerst auf die dafür vorgesehene Seite und gibt seine E-Mail Adresse ein. Da in diesem Projekt keine E-Mails verschickt werden, wird der Vorgang einer versendeten E-Mail simuliert, indem in dem Order "mail" eine Datei generiert wird. Mit dem in der Datei zu findenen Link wird man auf eine neue Seite weitergeleitet, wo noch einmal nach der registrierten E-Mail Adresse gefragt wird und ein Nutzername und ein Passwort ausgewählt werden kann. Die Registration ist hierbei nur erfolgreich und wird in die Datenbank eingetragen, wenn die E-Mail Adressen übereinstimmen.

## Sitemap:

Index: Die Startseite auf dem jeder Nutzer landet, wenn er die URL eingibt. Hier sind alle Kunstwerke zu finden, wobei der Nutzer nach den neuesten, den ältesten und den besten filtern kann, wobei "beste" durch die Anzahl der gesetzten "Lesezeichen" definiert wird. Selbstverständlich kann er auch nach bestimmten Formen von Kunstwerken wie Bilder, Videos und Dokumente filtern und diese mit den vorhergenannten Filtern verbinden, um so zum Beispiel die neusten Videos ohne großen Aufwand finden zu können.

Anmelden/Registrieren: Hier kann sich der Nutzer anmelden, wofür er seine registrierte E-Mail Adresse und Passwort benötigt. Sollte er noch kein Benutzerkonto haben, kann er durch einen Link zur Registrierung weitergeleitet werden. Wie oben schon beschrieben, muss der User zuerst seine E-Mail Adresse eingeben und nachdem er diese bestätigt hat, kann er seinen Nutzernamen und Passwort auswählen.

Nutzungsbedingungen/Datenschutzbedingungen/Impressum: Seiten, welche rechtlich vorhanden sein müssen. Sie wurden nach der Rechtslage des Jahres 2022 erstellt.

Eintrag: Hier sind die Kunstwerke der Nutzer zu finden. Jedes Kunstwerk hat seine eigene Seite. Angemeldete Nutzer können hier ein "Lesezeichen" für dieses Kunstwerk setzen oder ein Kommentar für den Ersteller hinterlassen. Kommentare können nach gefiltert werden, ob zuerst neue oder alte Kommentare erscheinen sollen. Sollte man der Ersteller des angezeigten Kunstwerkes sein, so besteht die Möglichkeit den Titel, Beschreibungstext oder die Tags, welche für die Suche benutzt werden können, zu ändern.

Neuer Eintrag: Hier können neue Einträge hochgeladen werden. Es müssen dabei Titel, Beschreibungstext und Tags angegeben werden. Diese Seite ist nur für angemeldete Nutzer verfügbar.

Profil: Anzeige des Profil eines Nutzers. Hier können alle hochgeladenen Kunstwerke des Nutzers angesehen werden und gefiltert werden. Sollte das angezeigte Profil das eigene sein, so kann von hier aus weitergeleitet werden, um weitere Kunstwerke hochzuladen, es können die bisher hochgeladenen Kunstwerke angesehenen werden und Kunstwerke, bei welchen ein "Lesezeichen" gesetzt worden ist. Diese können auf die bekannte Art gefiltert werden. Darüber hinaus gelangt der Nutzer von hier aus zu seinen Profil Einstellungen. Hier kann er sein Passwort ändern oder sein Konto löschen, wenn er dies wünscht.

Suche: Über die Suche kann der Nutzer nach Kunstwerken als auch nach anderen Nutzern suchen. Für Nutzer muss nur der Nutzername eingeben werden, währenddessen Kunstwerke durch Titel, Tags oder Beschreibungstext gefunden werden können. Selbstverständlich können diese Ergebnisse auch wieder gefilter werden.


## Lizenz

Der Code dieses Projektes untersteht der GNU General Public License. In der LICENSE Datei sind hier zu weitere Informationen zu finden.

