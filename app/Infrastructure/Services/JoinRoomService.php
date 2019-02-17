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

    public function join($roomId, $totalPlayer = null) : bool
    {
        if(!isset($totalPlayer))
            $totalPlayer = $this->getRoomService()
                ->getTotalPlayerInRoom($roomId);

        $this->getRoomService()
            ->updateTotalPlayerInRoom($roomId, ++$totalPlayer);

        $this->getRoomService()
            ->updatePlayerShape(
                $roomId,
                authPlayer()->getId(),
                0
            );

        return true;
//
//        $firebase = new FirebaseRepository();
//        $firebase->setReference('RoomList/' . $roomId . '/totalPlayer');
//
//
//
//        $firebase->setValue($totalPlayer + 1);
//
//        $firebase->setReference('ActiveRooms/'
//                                        . $roomId . '/'
//                                        . $this->getPlayerDomain()->getId());
//        $firebase->setValue(0);
    }


}