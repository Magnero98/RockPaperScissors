function getToken()
{
	return localStorage.getItem('token');
}

function getAuthPlayer()
{
	var player = JSON.parse(localStorage.getItem('authPlayer'));
	return player;
}

function setAuthPlayer(player)
{
	player = JSON.stringify(player);
	localStorage.setItem('authPlayer', player);
}

function isTokenSet()
{
	return !(localStorage.getItem('token') === null);
}

function isAuthenticated()
{
	return !(localStorage.getItem('authenticated') === null);
}

function setToken(newToken)
{
	localStorage.setItem('token', newToken);	
}

function authenticate(newToken)
{
	localStorage.setItem('token', newToken);
	localStorage.setItem('authenticated', true);
}

function clearStorage()
{
	localStorage.clear();
}
