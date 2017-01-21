/*
	Author: Michael Carey
	BYU-Idaho: CS-313
*/

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function redirectUrl(curl)
{
	window.location = curl;
}

function setCookieAndRedirect(cname, cvalue, exdays, curl){
	setCookie(cname, cvalue, exdays);
	redirectUrl(curl);
}

function testCookieValueAndClearIfSame(cname,tvalue)
{
	var cookieVal = getCookie(cname);
	
	if( tvalue===cookieVal )
	{
		setCookie(cname, 'javaScriptPost', -1);
	}
}