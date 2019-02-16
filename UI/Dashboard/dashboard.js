/* include '../sessionHelper.js' */
/* include '../ajaxHelper.js' */
/* include '../authenticatePlayer.js' */

$(document).ready(function(){
    
    getPlayerData();
    getRoomList();
    alert(getAuthPlayer().id);
    $("#logoutBtn").click(function(){
        logout();
    }); 

    $("#createRoomForm").on("submit", function(e){
        e.preventDefault();
        createNewRoom();
    }); 

});

function getRoomList()
{
    var url = "http://localhost:8000/api/rooms";
    var callback = onGetRoomList;

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onGetRoomList(data)
{
    var roomListScrollBox = $('#roomList');
    var rooms = data['rooms'];

    $.each(rooms, function(key, value){
        var item = $('<li class="list-group-item">' + value.title + '</li>');

        if(value.totalPlayer < 2)
            item.append($('<button onclick="joinRoom(\'' + key + '\')">Join</button>'));
        roomListScrollBox.append(item);
    });
}

function createNewRoom()
{
    var url = "http://localhost:8000/api/rooms/create";
    var data = $('#createRoomForm').serialize();
    var callback = onCreateRoom;

    if(isTokenSet()) // sessionHelper.js
        url += "?token=" + getToken(); // sessionHelper.js

    sendPostMethod(url, data, callback); // ajaxHelper.js
}

function onCreateRoom(data)
{
    alert(data['roomId']);
    setRoomId(data['roomId']); // sessionHelper.js
    joinRoom(data['roomId']);
}

function joinRoom(roomId)
{
    var url = "http://localhost:8000/api/rooms/join?roomId=" + roomId;
    var callback = onJoinRoom;

    if(isTokenSet()) // sessionHelper.js
        url += "&token=" + getToken(); // sessionHelper.js

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onJoinRoom(data)
{
    alert(data['success']);
}

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
    //var data = null;
    var callback = setAuthPlayer; // sessionHelper.js

    if(isTokenSet()) // sessionHelper.js
        url += "?token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}