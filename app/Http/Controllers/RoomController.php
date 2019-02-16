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
        $rooms = $this->roomService
                    ->getRoomsLimitTo15Data($request->roomId);

        return json_encode($rooms);
    }

    public function createRoom(Request $request)
    {

    }
}
