/* include '../sessionHelper.js' */
/* include '../ajaxHelper.js' */

var RoomStates = Object.freeze({"Idle":1, "Has2Player":2, "BothPlayerReady":3});
var state = RoomStates.Idle;
var isPlayerReady = false;

function searchingForOpponent()
{
	getTotalPlayerInRoom();
	state = RoomStates.Has2Player;

	checkBothPlayerReadiness();
}

function getTotalPlayerInRoom()
{
	var url = "http://localhost:8000/api/players/total?roomId=" + getRoomId(); // sessionHelper.js
    var callback = onGetTotalPlayer;

    if(isTokenSet()) // sessionHelper.js
        url += "&token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onGetTotalPlayer(data)
{
	if(data['totalPlayer'] < 2)
		setTimeout(getTotalPlayerInRoom, 1000);
	else
		setTimeout(loadOpponentData, 1000);
}

function loadOpponentData()
{
	getOpponentData();
	//alert(JSON.stringify(getGameOpponent()));
	setTimeout(function(){
		renderOpponentData(getGameOpponent());
	}, 2500);
	
}

function getOpponentData()
{
	if(getGameOpponent() != null)
		return;

	var url = "http://localhost:8000/api/rooms/opponent?roomId=" + getRoomId();
    var callback = onGetOpponentData; // sessionHelper.js

    if(isTokenSet()) // sessionHelper.js
        url += "&token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onGetOpponentData(data)
{
	setGameOpponent(data['opponent']);
	//alert(JSON.stringify(getGameOpponent()));
}

function checkBothPlayerReadiness()
{

}

function exitGame()
{

}