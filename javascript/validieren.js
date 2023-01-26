window.addEventListener("keyup", function (){
    var benutzername = document.getElementById("registrieren-name").value;
    var pw = document.getElementById("registrieren-passwort").value;
    var pw_wiederholung = document.getElementById("registrieren-passwort-wiederholen").value;
     
    if (benutzername == "Ricardo"){
         document.getElementById("benutzername-vergeben").innerHTML = "Dieser Benutzername ist schon vergeben";
     } else {
        document.getElementById("benutzername-vergeben").innerHTML = "Benutzername verfügbar";
     }

    if (pw !== pw_wiederholung){
        document.getElementById("passwort-ungleich").innerHTML = "Passwörter sind nicht gleich";
    } else {
        document.getElementById("passwort-ungleich").innerHTML = "";
    }
})


// function validieren (benutzername){
//     var test = benutzername;
//             $(document).ready(function() {
//                 $("button").click(function() {
//                     $.post("3-gethint.php", {
//                         q: test
//                     },
//                            function(data, status) {
//                         document.getElementById("test").innerHTML = data;
//                         alert("Data: " + data + "\nStatus: " + status);
//                     }).done(function() {
//                         alert("second success");
//                     })
//                         .fail(function() {
//                         alert("error");
//                     })
//                         .always(function() {
//                         alert("finished");
//                     });
//                 });
//             });}