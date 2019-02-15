function getToken()
{
	return localStorage.getItem('token');
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

function unauthenticate()
{
	localStorage.removeItem('token');
	localStorage.removeItem('authenticated');
}

function clearStorage()
{
	localStorage.clear();
}
