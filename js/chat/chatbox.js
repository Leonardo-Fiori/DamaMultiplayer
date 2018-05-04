// RICHIESTA NUOVI DATI E RELATIVA RISPOSTA

function updateChat(data){

	var chat = document.getElementById("chatbox");

	if(typeof data == "string" && data == "ChatEmpty"){
		while (chat.hasChildNodes()) 
			chat.removeChild(chat.lastChild);
		return;
	}

	// analizza e decodifica la stringa scritta in json e creane un oggetto 
	var out = JSON.parse(data);
	
	// svuota la chatbox
	while (chat.hasChildNodes())
		chat.removeChild(chat.lastChild);

	// aggiorna la chat con i dati aggiornati
	for(var pos in out){
		// creo l'elemento per un messaggio
		var val = out[pos]['nickname']+": "+out[pos]['messaggio'];
		var post = document.createElement("P");
		var text = document.createTextNode(val);
		post.setAttribute("class", "chatpost");
		post.appendChild(text);
		
		chat.appendChild(post);
	}
}

function checkNewPosts(){
	AJAX.performAjaxRequest("POST","./php/ajax/chatDownload.php",true,null,updateChat);
}

// INVIO NUOVI DATI E RELATIVA RISPOSTA

function postSent(data){
	if(data == "Ok"){
		document.getElementById("textbox").value = "";
	}
	else{
		alert("Errore: "+data);
	}
	return;
}

function sendPost(local){
	var data = document.getElementById("textbox").value;
	var string = "message="+data;
	AJAX.performAjaxRequest("POST","./php/ajax/chatPost.php",true,string,postSent);
}

// CICLO DI CONTROLLO NUOVI DATI

var chatIntvl = null;
function checkNewPostsInterval(control){
	if(control==true && chatIntvl == null){
		chatIntvl = setInterval(checkNewPosts, 1000);
	}
	else{
		clearInterval(chatIntvl);
		chatIntvl = null;
	}
}