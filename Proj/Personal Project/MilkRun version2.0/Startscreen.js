function startGame() {
	var div = document.getElementById( "mainCanvas" );	
    var startScreen = document.getElementById( "start_screen" );
	var gameScript = document.getElementById( "mainGame");
		
	div.style.display = "block"; //display the game canvas
	startScreen.style.display = "none"; //hide the title screen
	gameScript.src = "CowSprite.js";	//start the game
}
		
function In(x){
	var div = document.getElementById(x);
	var startScreen = document.getElementById("start_screen");
	
	div.style.display = "block"; //display the x screen
	startScreen.style.display = "none"; //hide the title screen
}
	
function Back(x){
	var div = document.getElementById(x);
	var startScreen = document.getElementById("start_screen");
	div.style.display = "none"; //hide the x screen
	startScreen.style.display = "block"; //display the title screen
}
