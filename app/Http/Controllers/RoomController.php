<?php

namespace App\Http\Controllers;

use App\Domain\Services\PlayerService;
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
            'success' => 'player Joined'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to join'
            ];

        return json_encode($message);
    }

    public function leftRoom(Request $request)
    {
        $success = $this->roomService
                        ->removePlayerFromRoom($request->roomId,
                                                $request->playerId);
        $message = [
            'success' => 'player left successfully'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to left room'
            ];

        return json_encode($message);
    }

    public function deleteRoom(Request $request)
    {
        $success = $this->roomService
                        ->removeRoom($request->roomId);
        $message = [
            'success' => 'room removed successfully'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to remove room'
            ];

        return json_encode($message);
    }

    public function getRoomPlayersAndReadyData(Request $request)
    {
        $roomAttrbs = $this->roomService
            ->getRoomData($request->roomId);

        $data = [
            'players' => $roomAttrbs['players'],
            'ready' => isset($roomAttrbs['ready']) ? $roomAttrbs['ready'] : []
        ];

        return json_encode($data);
    }

    public function setPlayerToReady(Request $request)
    {
        $success = $this->roomService
                        ->setPlayerReadyInRoom($request->roomId);
        $message = [
            'success' => 'player is ready'
        ];

        if(!$success)
            $message = [
                'error' => 'failed to update player status'
            ];

        return json_encode($message);
    }

    public function resetAllPlayersReadyStatus(Request $request)
    {
        $success = $this->roomService
            ->resetAllPlayerReadyInRoom($request->roomId);
        $message = [
            'success' => 'All player set to not ready'
        ];

        if(!$success)
            $message = [
                'error' => 'Failed reset ready status'
            ];

        return json_encode($message);
    }
}
