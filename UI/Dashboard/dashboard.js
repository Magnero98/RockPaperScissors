$(document).ready(function(){
   $("#logoutBtn").click(function(){
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
    }); 
});

function onLogout(data)
{
    if(!('error' in data))
    {
        window.location = "file:///C:/Users/User/Desktop/UI/Login/login.html";
        unauthenticate();
    }
    else
    {
        alert(data.error);
    }
}

//alert(getToken());
$.ajax({
    type: "GET",
    url:  "http://localhost:8000/api/player?token=" + getToken(),
    dataType: "json",
    success: function(data){
        alert(JSON.stringify(data));
    },
    error: function(errMsg) {
        alert(JSON.stringify(errMsg));
    }
});