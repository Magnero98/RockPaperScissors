$(document).ready(function(){
    redirectIfLoggedIn();

    $("#registerForm").on("submit", function(e){

        e.preventDefault();
        if(!validateData()) return;

        var redirectUrl = "http://localhost:8000/api/register";
        if(isTokenSet())
            redirectUrl += "?token=" + getToken();

        $.ajax({
            type: "POST",
            url:  redirectUrl,
            data: $('#registerForm').serialize(),
            dataType: "json",
            success: function(data){
                onRegister(data);
            },
            error: function(errMsg) {
                alert(JSON.stringify(errMsg));
            }
        });
    }); 
});

function onRegister(data)
{
    if(!("error" in data))
    {
        authenticate(data['token']);

        window.location = "file:///C:/Users/User/Desktop/UI/Dashboard/dashboard.html";    
    }
    else
    {
        setToken(data['token']);
        alert(data['error']);
    }
}

function validateData()
{
    var data = $('#registerForm').serializeArray();

    var username = $.trim(data[0]
                            .value
                            .replace(/[^a-zA-Z]/g,''));
    if(username.length < 6)
    {
        alert('username must contains only alphabets or more than 5 characters');
        return false;
    }

    var password = $.trim(data[1].value);
    if(password.length < 6)
    {
        alert('password must be more than 5 characters');
        return false;
    }

    return true;
}

function redirectIfLoggedIn()
{
    if(isAuthenticated())
        window.location = "file:///C:/Users/User/Desktop/UI/Dashboard/dashboard.html";       
}