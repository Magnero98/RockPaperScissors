/* include '../sessionHelper.js' */
/* include '../ajaxHelper.js' */
/* include '../authenticatePlayer.js' */

$(document).ready(function(){
    
    getPlayerData();

    $("#logoutBtn").click(function(){
        logout();
    }); 

});

function logout()
{
    var url = "http://localhost:8000/api/logout";
    var callback = onLogout;

    if(isTokenSet()) // sessionHelper.js
        url += "?token=" + getToken(); // sessionHelper.js

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onLogout(data)
{
    if(!('error' in data))
    {
        clearStorage(); // sessionHelper.js
        window.location = "../Login/login.html";
    }
    else
    {
        alert(data.error);
    }
}

function getPlayerData()
{
    if(getAuthPlayer() != null) return;
    
    var url = "http://localhost:8000/api/player";
    var callback = setAuthPlayer; // sessionHelper.js

    if(isTokenSet()) // sessionHelper.js
        url += "?token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}