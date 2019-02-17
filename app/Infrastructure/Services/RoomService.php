<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2019
 * Time: 9:14 PM
 */

namespace App\Infrastructure\Services;

use App\Domain\Models\Guid;
use App\Infrastructure\Repositories\FirebaseRepository;

class RoomService
{
    public function getRoomsLimitTo15Data($index = null) : array
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList');

        $rooms = isset($index)
                ? $firebase->getReference()
                            ->orderByChild('created_at')
                            ->limitToFirst(15)
                            ->startAt($index)
                            ->getSnapshot()
                            ->getValue()
                : $firebase->getReference()
                            ->orderByChild('created_at')
                            ->limitToFirst(15)
                            ->getSnapshot()
                            ->getValue();
        return $rooms;
    }

    public function createNewRoom($roomTitle) : string
    {
        $roomId = Guid::generateId();

        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/' . $roomId);

        $roomItem = [
            'title' => $roomTitle,
            'totalPlayer' => 0,
            'totalReady' => 0,
            'created_at' => date("-YmdHis",time())
        ];
        $firebase->setValue($roomItem);

        return $roomId;
    }

    public function getTotalPlayerInRoom($roomId)
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/' . $roomId . '/totalPlayer');

        return $firebase->getValue();
    }

    public function updateTotalPlayerInRoom($roomId, $totalPlayer)
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/' . $roomId . '/totalPlayer');

        $firebase->setValue($totalPlayer);
    }

    public function updateTotalReadyInRoom($roomId, $totalReady)
    {

    }

    public function updatePlayerShape($roomId, $playerId, $shape)
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('ActiveRooms/'
            . $roomId . '/'
            . $playerId);
        $firebase->setValue($shape);
    }
}