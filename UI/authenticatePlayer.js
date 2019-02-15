function redirectIfAuthenticated()
{
	$.ajax({
        type:     "GET",
        url:      "http://localhost:8000/api/authenticate?token=" + getToken(),
        dataType: "json",
        success: function(data){
            onAuthenticated(data);
        },
        error: function(errMsg) {
            alert(JSON.stringify(errMsg));
        }
    });
}

function onAuthenticated(data)
{
	if(('error' in data))
		window.location = "file:///C:/Users/User/Desktop/UI/Login/login.html";
}

redirectIfAuthenticated();