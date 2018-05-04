alphaIntvl = null;
alpha = 0;

function increaseBoardAlpha(){
	var board = document.getElementById("playfield");
	if(alpha >= 1){
		clearInterval(alphaIntvl);
		alphaIntvl = null;
	}
	board.setAttribute("style","opacity: "+alpha+";");
	alpha += 0.01;
	return;
}