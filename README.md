<h1 align="center"> ReiWa: Eine Kunstausstellung für jedermann!</h1>

<h2 align="center"> English version follows the German one</h2>

Im Rahmen eines Universitätsmodul der Carl-von-Ossietzky Universität Oldenburg wurde diese Webseite im Sommersemester 2022 entwickelt. Die gestellte Aufgabe war eine digitale Kunstausstellung zu entwickeln. Da Kunst sich aber nicht definieren lässt, sind auf dieser Seite Kunst jeglicher Art willkommen. Insbesondere sind die Künste von Amateuren willkommen, um ihnen einen Platz zu geben, ihre Künste ohne Angst ausstellen zu können. Die anvisierte Zielgruppe sind hier junge Künstler, welche sich durch Bilder, Videos und Dokumenten künstlerisch ausdrücken können.

Sofern nicht anders angemerkt, wurde sämtlicher Code selber von mir und meinem Gruppenpartner geschrieben.

## Voraussetzungen

Für dieses Projekt wurde PHP 8 verwendet. Im Backend befinden sich SQLite und jQuery 3.6.0 um Beiträge abzuspeichern und diese auch zu durchsuchen. Es wurden darüber hinaus jedoch keine Frameworks oder Bibliotheken benutzt, sondern einzig und allein die Funktionen von HTML, PHP 8 und Javascript. Da es sich um eine Abgabe für ein Modul handelt, lässt sich dieses Projekt komplett als localhost ausführen.

## Über das Projekt

Wie zu sehen ist, sind gleich schon auf der Index Beiträge zu sehen, um den Nutzer so schnell wie möglich mit anderen interagieren zu lassen. Ein Benutzerkonto nur nötig, wenn selbst Kunst hochgeladen werden soll, ein Kommentar zu einem Kunstwerk zu machen oder sich dieses als "Lesezeichen" für später abzuspeichern. Selbstverständlich ist die Seite auch für den mobilen Gebrauch angepasst. Von Bootstrap inspiriet befinden sich die Media-Queries hier bei 768px, welches den Footer verschwinden und ein Hamburger-Menü zur leichteren Navigation erscheinen lässt.

Beim ersten Starten wird eine beispielhafte Datenbank erstellt und mit Einträgen befüllt, sodass schon zu Beginn sich das ungefähre Look & Feel der Seite erahnen lässt, ohne dass man erst mühsam die Datenbank befüllen muss. Selbst wenn die Datenbank gelöscht wird, wird sie beim nächsten Start wieder neu erstellt und mit den beispielhaften Einträgen gefüllt. Gültige Dateiformate für Einträge sind für Bilder .jpg, .jpeg, .gif, .png, für Videos .ogg, .mp4, .webm und für Dokumente .pdf Formate. Auch Nutzer sind hier schon vorhanden, sodass man sich nicht neu registrieren muss, um die komplette Seite zu benutzen. 

Die Login-Daten hierfür sind: 

E-Mail: magnat@mail.de
Passwort: 123

E-Mail: muster@mail.de
Passwort: 123


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


----------------------------------------------------------------------------------------------------------------------------------------

<h1 align="center"> ReiWa: An art Exhibition for everyone!</h1>

In the course of a class for the Carl-von-Ossietzky University Oldenburg this website was being created during the summer-term 2022. The presented task was to develop a website for a digital art Exhibition. But as it is rather difficult to define what now is art and what not, art of every kind is welcome here. Especially amateurs are welcome here to give them a place to showcase their arts without any fear. The targeted group are young artists which express themselves through images, videos or writing.

If not being referred to otherwise at the beginning of a method, each and every line of code was being written by myself or my group partner.

## Requirements

For this project PHP 8 was being used. In the backend there's SQLite and jQuery 3.6.0 to save the entries to a database and to search said entries. Besides this, there were no other frameworks or libraries being used, but only the functions found in HTML, PHP 8 and Javascript. As it was being written for a university class, the entire project can be executed as localhost.

## The project itself

As you can see, right at the beginning on the index page, there are entries to be found to enable the user to interact with these as soon as possible. A user account is only neccessary, if the user themselves want to upload artwork, comment artwork of others or "bookmark" a specific one to find it again later. Naturally is this website also designed for mobile usage. Inspired by Bootstrap the media-queries are at 768px, which will then hide the footer and lets a hamburger-menu appear to make navigation more easy.

Upon first start-up, a default database will be created and be filled with entries, so that from the beginning a rough look&feel of the website can be felt, without filling up the database beforehand. Even if accidentially the database will be deleted, upon next start-up the default database will be created once again. Valid data formats are for images .jpg, .jpeg, .gif, .png, for videos .ogg, .mp4, .webm and for writings .pdf formats. The default database also already has default users already saved in it, so that you don't have to register yourself and can experience the whole website from the start.

The login-data are:

E-Mail: magnat@mail.de
Password: 123

E-Mail: muster@mail.de
Password: 123

In case you do want to register yourself, you first go to the dedicated page and enter your e-mail address. As in this projects no real e-mails will be send, it will be simulated as in the folder "mail" a file will be generated. In this file, a link will appear through which you will be redirected to a new page where you have to input the registered e-mail again and afterwards, you can pick a username and password for your account. Be aware though, that you can only register yourself here, if the e-mail address is the same as in the first step.

## Sitemap:

Index: The landing page for everyone who inputs the URL. Here all artworks are to be found, whereas the user can filter the results to look for the newest, oldest or best artwork. "Best" will be quantified by the amount of "bookmarks" set by other users. Of course, it can also be used to look for certain kinds of artworks like images, videos and writing and can be combined with the aforementioned filter options to find effortless, for instance, the newest videos on the website.

Sign in/Sign up: Here a user can sign in while using his registered e-mail address and password. Should the user not have any account until now, he can also be redirected to get a user account. As already mentioned above, the user will need to input his e-mail address first and after confirming it, he can pick his username and password.

EULA/data protection/imprint: Pages, which have to be existing due to German law. They were being created under the legal situation in Germany 2022.

Entries: Here the artworks of the users are to be found. Every artwork has its own dedicated page. Signed-in users can set "bookmark" for this specific artwork or leave a comment for the creator. Comments can be filtered after a user first wants to see all of the new comments or the old ones. Should the creator look at his own artwork, he will be able to change the title, description or the tags, which can be used for searching the website.

New entry: Here new entries can be uploaded. It's mandatory to give it a title, description and tags. This page is only available for signed-in users.

Profile: Profile of a signed-in user. Here every uploaded artwork by this user can be seen and be filtered. Should the shown profile be your own, you'll be able to be redirected directly to a page where you can upload your artwork. You also can see all of your uploaded artwork up until now and see the artwork you "bookmarked". These can be filtered by the aforementioned methods. Further users can access their profile settings here, where they can change their password or delete their account, if they chooses to.

Search: Over the searchbar, the user can not only search for artwork but also other users. For users he only needs look search for the username, whereas for artwork he can choose between the title, tags or even the description. Naturally, all of these search results can be filtered again.

## License

The code of this project is under the GNU General Public License. In the LICENSE file are more information about this to be found.

## Language usage

As this was only a university project, it only is available in the German language.
