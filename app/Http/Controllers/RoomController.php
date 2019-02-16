<?php

namespace App\Http\Controllers;

use App\Domain\Models\Guid;
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
        $room = [
            'rooms' => $this->roomService
                    ->getRoomsLimitTo15Data($request->roomId)
        ];

        return json_encode($room);
    }

    public function createRoom(Request $request)
    {
        $room = [
            'roomId' => $this->roomService
                    ->createNewRoom($request->roomTitle)
        ];

        return json_encode($room);
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
}
