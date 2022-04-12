var endless = {
url: "endless-logic.php",
proceed: true,
page: 0,
moreToLoad: true,

init: () =>{
    window.addEventListener("scroll",()=>{
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight){
            endless.load();
        }
    });

    endless.load();
},

//Ajax Methode zum laden
load : () => {
    if (endless.proceed && endless.moreToLoad){
        endless.proceed = false;//Lock damit nur eine Seite auf einmal beim Scrollen geladen wird

        var data = new FormData(),
        nextPage = endless.page +1;

        data.append("page", nextPage);

        fetch(endless.url, {method:"POST", body:data})
        .then(res=>res.text()).then((res) => {
            if (res == "END") {endless.moreToLoad = false;}
            else {
                var e = document.createElement("div");
                e.innerHTML = res;
                document.getElementById("page-content").appendChild(e);
                endless.proceed = true;//Lock aufgehoben, Seite wurde geladen
                endless.page = nextPage;
                
            }
        });
    }
}
};
window.addEventListener("DOMContentLoader", endless.init);