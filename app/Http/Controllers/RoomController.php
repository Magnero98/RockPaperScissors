<?php

namespace App\Http\Controllers;

use App\Infrastructure\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    protected $roomService;

    public function get15Rooms(Request $request)
    {
        $data = [
            'rooms' => $this->roomService
                    ->getRoomsLimitTo15Data($request->roomId)
        ];

        return json_encode($data);
    }

    public function getOpponent(Request $request)
    {
        $opponent = $this->roomService
                        ->getRoomOpponent($request->roomId);
        $data = [
            'opponent' => $opponent
        ];

        //var_dump($opponent);
        return json_encode($data);
    }

    public function getTotalPlayer(Request $request)
    {
        $data = [
            'totalPlayer' => $this->roomService
                ->getTotalPlayerInRoom($request->roomId)
        ];

        return json_encode($data);
    }

    public function createRoom(Request $request)
    {
        $data = [
            'roomId' => $this->roomService
                    ->createNewRoom($request->roomTitle)
        ];

        return json_encode($data);
    }

    public function joinRoom(Request $request)
    {
        $success = authPlayer()->getJoinRoomService()
                                ->join($request->roomId);
        $message = [
            'success' => 'room successfully created'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to create room'
            ];

        return json_encode($message);
    }

    public function leftRoom(Request $request)
    {
        $success = authPlayer()->getJoinRoomService()
            ->join($request->roomId);
        $message = [
            'success' => 'room successfully created'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to create room'
            ];

        return json_encode($message);
    }
}
