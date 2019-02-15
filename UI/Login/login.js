$(document).ready(function(){
    redirectIfLoggedIn();

    $("#loginForm").on("submit", function(e){
        e.preventDefault();

        var redirectUrl = "http://localhost:8000/api/login";
        if(isTokenSet())
            redirectUrl += "?token=" + getToken();

        $.ajax({
            type: "POST",
            url:  redirectUrl,
            data: $('#loginForm').serialize(),
            dataType: "json",
            success: function(data){
                onLogin(data);
            },
            error: function(errMsg) {
                alert(JSON.stringify(errMsg));
            }
        });
    }); 
});

function onLogin(data)
{
    if(!("error" in data))
    {
        authenticate(data['token']);

        window.location = "file:///C:/Users/User/Desktop/UI/Dashboard/dashboard.html";    
    }
    else
    {
        setToken(data['token']);
        alert(JSON.stringify(data['error']));
    }
}

function redirectIfLoggedIn()
{
    if(isAuthenticated())
        window.location = "file:///C:/Users/User/Desktop/UI/Dashboard/dashboard.html";       
}

//clearStorage();