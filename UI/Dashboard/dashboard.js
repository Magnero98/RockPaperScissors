$(document).ready(function(){
    $("#logoutBtn").click(function(){
        logout();
    }); 

    getPlayerData();
});

function logout()
{
    $.ajax({
        type: "GET",
        url:  "http://localhost:8000/api/logout?token=" + getToken(),
        dataType: "json",
        success: function(data){
            onLogout(data);
        },
        error: function(errMsg) {
            alert(JSON.stringify(errMsg));
        }
    });
}

function onLogout(data)
{
    if(!('error' in data))
    {
        clearStorage();
        window.location = "../Login/login.html";
    }
    else
    {
        alert(data.error);
    }
}

function getPlayerData()
{
    if(getAuthPlayer() != null)
        return;
    
    $.ajax({
        type: "GET",
        url:  "http://localhost:8000/api/player?token=" + getToken(),
        dataType: "json",
        success: function(data){
            setAuthPlayer(data);
        },
        error: function(errMsg) {
            alert(JSON.stringify(errMsg));
        }
    });
}