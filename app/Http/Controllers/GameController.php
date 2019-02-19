<?php

namespace App\Http\Controllers;

use App\Infrastructure\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct()
    {
        $this->gameService = new GameService();
    }

    protected $gameService;

    public function setPlayerShape(Request $request)
    {
        $success = $this->gameService
                        ->setPlayerShape($request->roomId,
                                         $request->shape);
        $message = [
            'success' => 'successfully set player shape'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to set player shape'
            ];

        return json_encode($message);
    }

    public function chooseTheGameWinner(Request $request)
    {
        $result = $this->gameService
                            ->determineGameResultAndGiveRewardOrPenalty($request->roomId);
        $data = [];

        if(empty($result))
            $data['error'] = 'Opponent Still Playing';
        else
            $data = $result;

        return json_encode($data);
    }
}
