function checkCookieLog(){
    var user = getCookie("first_name");
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

function logOut(){

	document.cookie = 'first_name=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
	document.cookie = 'admin_id=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';	
	var div = document.getElementById("log_out_button");
	var button = document.getElementById("log_in_button");
	div.style.display = "none";
	button.style.display = "block";
	location.reload(true);
}