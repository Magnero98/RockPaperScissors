<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/13/2019
 * Time: 6:24 PM
 */
use App\Domain\Models\PlayerDomain;

if(!function_exists('authPlayer'))
{
    function authPlayer() : ?PlayerDomain
    {
        return (session()->has('authPlayer'))
                ? session()->get('authPlayer')
                : null;
    }
}

if(!function_exists('deleteSessionFile'))
{
    function deleteSessionFile($sessionId) : bool
    {
        $path = 'framework\\sessions\\' . $sessionId;

        try {
            unlink(storage_path($path));
            return true;
        } catch(Exception $e){
            return false;
        }
    }
}

if(!function_exists('sessionFileExists'))
{
    function sessionFileExists($sessionId) : bool
    {
        $path = storage_path() . '\\framework\\sessions\\' . $sessionId;
        return (file_exists($path));
    }
}