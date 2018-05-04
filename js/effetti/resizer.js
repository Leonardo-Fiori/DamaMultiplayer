function centerPageDiv(divname,offset){
	var div = document.getElementById(divname);
	var divH = div.clientHeight+offset;
	var winH = window.innerHeight;
	var pos = (winH-divH)/2;
	document.getElementById(divname).style.top=""+pos+"px";
}