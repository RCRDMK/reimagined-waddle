/**
 Fügt den Titel #neu-titel automatisch zu den Tags #neu-tags
 */
function titelInTagAutomatisch() {
    var titel = document.getElementById("neu-titel").value;
    var alterText = document.getElementById("neu-tags").value;
    alterText = alterText.substring(alterText.indexOf(";") + 1);
    document.getElementById("neu-tags").value = titel + ";" + alterText;
}


/**
 * kehre die Reihenfolge der Kommentare um
 *
 * verwendet Class  .kommentarbereich und .kommentar
 */
function kommentareSortieren() {
    //$("")  <- Selektor eines Elements https://www.w3schools.com/jquery/jquery_selectors.asp
    var kommentarbereich = $(".kommentarbereich");
    var items = $(".kommentar");

    //sort() https://www.w3schools.com/jsref/jsref_sort.asp
    //https://api.jquery.com/each/
    items.sort().each(
        function () {
            kommentarbereich.prepend(this); //füge das item vorne im Kommentarbereich an
        }
    );
}

/**
 * Zeige an, ob Benutzername vergeben ist.
 * Verwendet IDs #registrieren-name (Name) und #benutzername-vergeben (Anzeige)
 */
function isNameFrei() {
    var name = $("#registrieren-name").val();

    //https://www.w3schools.com/jquery/ajax_ajax.asp
    $.ajax({
        url: "logik/ajaxCall.php",
        type: 'post',
        data: {isNameCall: name},
        success: function (erfolg) {
            if (erfolg === "1") {
                $("#benutzername-vergeben").show();
            } else {
                $("#benutzername-vergeben").hide();
            }

        }
    });
}

/**
 * Hide/Show von Class = ".ueberischt-eintraege-eintrag"
 * Benutzt value von Class = ".dropdown-kategorien" zur Auswahl der Kategorie
 *
 * values:
 *      alle
 *      text
 *      bild
 *      video
 *      dokument
 */
function uebersichtKategorie() {
    var kategorie = $(".dropdown-kategorien").val();
    var eintraege = $(".ueberischt-eintraege-eintrag");

    eintraege.each(function (a) {
        if (kategorie === "alle") {
            $(this).show();
        } else if ($(this).attr("data-typ") === kategorie) {
            $(this).show();
        } else {
            $(this).hide();
        }
    })
}

/**
 * data-eid
 * data-lea
 *
 * values:
 *      neu
 *      alt
 *      beste
 */
function uebersichtSortieren() {

    var sortierenWahl = $(".dropdown-sortieren").val();
    var container = $(".ueberischt-eintraege-body");
    var eintraege = $(".ueberischt-eintraege-eintrag");
    console.log(sortierenWahl);
    if (sortierenWahl === "neu") {//Neu
        eintraege.sort(
            function (a, b) {
                a = $(a).attr("data-eid");
                b = $(b).attr("data-eid");
                return a - b;
            }
        ).each(function () {
            container.prepend(this);
        });
    } else if (sortierenWahl === "alt") {//Alt
        eintraege.sort(
            function (a, b) {
                a = $(a).attr("data-eid");
                b = $(b).attr("data-eid");
                return b - a;
            }
        ).each(function () {
            container.prepend(this);
        });
    } else {//Beste
        eintraege.sort(
            function (a, b) {
                a = $(a).attr("data-lea");
                b = $(b).attr("data-lea");
                return a - b;
            }
        ).each(function () {
            container.prepend(this);
        });
    }
}

function passwoerterRegistierenIdentischVergleich() {
    var pw = $("#registrieren-passwort").val();
    var pwWdh = $("#registrieren-passwort-wiederholen").val();

    if (pw !== pwWdh) {
        $("#passwort-nicht-identisch").show();
    } else {
        $("#passwort-nicht-identisch").hide();
    }
}

function suchVorschlaege() {
    var input = $("#suche");
    $.ajax({
        url: "logik/ajaxCall.php",
        type: 'post',
        data: {suchText: input.val()},
        success: function (ergebnis) {
            if (ergebnis[0].length > 0 || ergebnis[1].length > 0) {

            }
        },
        dataType: "json"
    });


}


