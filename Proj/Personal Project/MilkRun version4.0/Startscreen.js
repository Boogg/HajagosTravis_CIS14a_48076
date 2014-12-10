		
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


function checkCookieLog(){
    var user = getCookie("username");
	var div = document.getElementById("log_out_button");
	var login = document.getElementById("log_in_button");
    if (user != ""){
		div.style.display = "block";
		login.style.display = "none";	
    } else{
		div.style.display = "none";
		login.style.display = "block";
	}
}

function getCookie(cname){
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays){
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
	
function GetScore(){
	var score = getCookie("score");
	var div = document.getElementById("Score");
	div.innerHTML = "Your Distance was "+score+ "!";
}
	
function logOut(){

	document.cookie = 'username=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
		
	var div = document.getElementById("log_out_button");
	var button = document.getElementById("log_in_button");
	div.style.display = "none";
	button.style.display = "block";
	location.reload(true);
}

	
	
	
	
	
	
	
	
	