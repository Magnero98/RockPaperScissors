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
        $player = $this->playerService->login($request->all());

        $message = [
            'success' => 'login successful',
            'token' => session()->getId()
        ];

        if(!isset($player))
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

    public function getPlayer(Request $request)
    {
        return json_encode(authPlayer()->toArray());
    }
}
