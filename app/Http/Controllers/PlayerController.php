<?php

namespace App\Http\Controllers;

use App\Domain\Services\PlayerService;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->playerService = new PlayerService();
    }

    protected $playerService;

    public function login(Request $request) : string
    {
        if(isset($request->token))
            session()->setId($request->token);

        $success = $this->playerService->login($request->all());
        $message = [
            'success' => 'login successful',
            'token' => session()->getId()
        ];

        if(!$success)
            $message = [
                'error' => 'username and password does not match',
                'token' => session()->getId()
            ];

        return json_encode($message);
    }

    public function logout(Request $request)
    {
        $success = $this->playerService->logout($request->token);
        $message = ['success' => 'logout successful'];

        if(!$success)
            $message = ['error' => 'file not found'];

        deleteSessionFile(session()->getId());
        return json_encode($message);
    }

    public function register(Request $request) : string
    {
        if($request->has('token'))
            session()->setId($request->token);

        $success = $this->playerService->register($request->all());
        $message = [
            'success' => 'register successful',
            'token' => session()->getId()
        ];

        if(!$success)
            $message = [
                'error' => 'username has already been taken',
                'token' => session()->getId()
            ];

        return json_encode($message);
    }

    public function authenticatePlayer(Request $request) : string
    {
        $success = sessionFileExists($request->token);
        $message = ['success' => 'player is authenticated'];

        if(!$success)
            $message = ['error' => 'unauthenticated player'];

        return json_encode($message);
    }

    public function getPlayer(Request $request) : string
    {
        session()->setId($request->token);
        session()->start();
        return json_encode(authPlayer()->toArray());
    }
}
