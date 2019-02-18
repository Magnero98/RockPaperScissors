/* include '../ajaxHelper.js' */
/* include '../authenticatePlayer.js' */
/* include '../RoomState.js' */

$(document).ready(function(){
    
    renderPlayerData();
    searchingForOpponent();

    $('#readyBtn').click(function(){
    	setPlayerReady() // RoomState.js
    });

});

function renderOpponentData(opponent)
{
	$('#opponentName').text(opponent.username);
	$('#opponentStatus').text("Not Ready");

	if(opponent.gender == "Male")
		$('#opponentImg').attr('src', 'https://res.cloudinary.com/black-pearls/image/upload/v1550398551/RPS/Players/boy.svg');
	else
		$('#opponentImg').attr('src', 'https://res.cloudinary.com/black-pearls/image/upload/v1550398551/RPS/Players/girl.svg');
}

function renderPlayerData()
{
	$('#playerName').text(getAuthPlayer().username); // include '../sessionHelper.js' 
	$('#playerStatus').text("Not Ready");

	if(getAuthPlayer().gender == "Male") // include '../sessionHelper.js'
		$('#playerImg').attr('src', 'https://res.cloudinary.com/black-pearls/image/upload/v1550398551/RPS/Players/boy.svg');
	else
		$('#playerImg').attr('src', 'https://res.cloudinary.com/black-pearls/image/upload/v1550398551/RPS/Players/girl.svg');	
}

function renderOpponentReset()
{
	$('#opponentName').text("Opponent");
	$('#opponentStatus').text("Not Ready");
	$('#opponentImg').attr('src', 'https://res.cloudinary.com/black-pearls/image/upload/v1550398551/RPS/Players/unknown.svg');
}