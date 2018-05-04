// Se il browser non supporta il session storage.
if(typeof(Storage) == "undefined") {
    alert("Attenzione: il tuo browser non supporta il Local Storage!");
	window.href("./matchMaker.php");
}

// Quando si ricarica la pagina imposta il tag nel session storage:
function eventHandler(){
	sessionStorage.setItem('refreshed','true');
}

window.onunload = eventHandler;
