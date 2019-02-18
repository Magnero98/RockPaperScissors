/* include '../sessionHelper.js' */
/* include '../ajaxHelper.js' */

var RoomStates = Object.freeze({"Idle":1, "Has2Player":2, "BothPlayerReady":3});
var state = RoomStates.Idle;
var isPlayerReady = false;

/* ================================== Idle State ================================ */

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
	}, 4500);
	
}

function getOpponentData()
{
	if(getGameOpponent() != null)
		return;

	var url = "http://localhost:8000/api/rooms/opponent?roomId=" + getRoomId();
    var callback = onGetOpponentData; 

    if(isTokenSet()) // sessionHelper.js
        url += "&token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onGetOpponentData(data)
{
	setGameOpponent(data['opponent']);
}

/* ================================== Has2Player State ================================ */

function checkBothPlayerReadiness()
{
	var url = "http://localhost:8000/api/rooms/data?roomId=" + getRoomId();
    var callback = onCheckBothPlayerReadiness;

    if(isTokenSet()) // sessionHelper.js
        url += "&token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onCheckBothPlayerReadiness(data)
{
	var players = data['players'];
	var ready = data['ready'];

	console.log(Object.keys(players).length);

	if(Object.keys(players).length < 2)
	{
		//opponent left
	}
	else
	{
		if(Object.keys(ready).length > 1)
			window.location = "../GameStage/gameStage.html";

		if(ready != true)
		{
			$.each(ready, function(key, value){
		        if(key != getAuthPlayer().id) // sessionHelper.js
		        	$('#opponentStatus').text("Ready");
		    });
		}	

		setTimeout(checkBothPlayerReadiness, 2500);
	}
}

function setPlayerReady()
{
	var url = "http://localhost:8000/api/rooms/player/ready?roomId=" + getRoomId();
    var callback = onSetPlayerReady;

    if(isTokenSet()) // sessionHelper.js
        url += "&token=" + getToken();

    sendGetMethod(url, callback); // ajaxHelper.js
}

function onSetPlayerReady(data)
{
	isPlayerReady = true;
	$('#playerStatus').text("Ready");
}

/* ================================== Player Left Page ================================ */

function exitGame()
{

}