<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/12/2019
 * Time: 7:40 AM
 */

namespace App\Infrastructure\Services;

use App\Domain\Models\PlayerDomain;

class JoinRoomService
{
    public function __construct(PlayerDomain $playerDomain)
    {
        $this->playerDomain = $playerDomain;
        $this->roomService = new RoomService();
    }

    protected $playerDomain;
    protected $roomService;

    public function getPlayerDomain()		{ return $this->playerDomain; }
    public function getRoomService()		{ return $this->roomService; }

    public function join($roomId) : bool
    {
        $this->getRoomService()
            ->setPlayerInRoom(
                $roomId,
                $this->getPlayerDomain()->getId()
            );

        $this->getRoomService()
            ->updatePlayerShape(
                $roomId,
                $this->getPlayerDomain()->getId(),
                -1
            );

        return true;
    }


}