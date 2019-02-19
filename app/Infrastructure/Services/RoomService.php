<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2019
 * Time: 9:14 PM
 */

namespace App\Infrastructure\Services;

use App\Domain\Models\Guid;
use App\Domain\Models\PlayerDomain;
use App\Infrastructure\Repositories\FirebaseRepository;
use App\Infrastructure\Repositories\PlayerRepository;

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
        return isset($rooms) ? $rooms : [];
    }

    public function createNewRoom($roomTitle) : string
    {
        $roomId = Guid::generateId();

        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/' . $roomId);

        $roomItem = [
            'title' => $roomTitle,
            'players' => true,
            'ready' => true,
            'created_at' => date("-YmdHis",time())
        ];
        $firebase->setValue($roomItem);

        return $roomId;
    }

    public function removeRoom($roomId) : bool
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/' . $roomId);
        $firebase->getReference()->remove();

        $firebase->setReference('ActiveRooms/' . $roomId);
        $firebase->getReference()->remove();

        return true;
    }

    public function getTotalPlayerInRoom($roomId)
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/' . $roomId . '/players');

        return $firebase->getSnapshot()->numChildren();
    }

    public function setPlayerInRoom($roomId, $playerId) : bool
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/'
                                . $roomId . '/'
                                . 'players/'
                                . $playerId);

        $firebase->setValue(true);

        return true;
    }

    public function removePlayerFromRoom($roomId, $playerId) : bool
    {
        if($this->getTotalPlayerInRoom($roomId) < 2)
            return $this->removeRoom($roomId);

        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/'
            . $roomId . '/'
            . 'players/'
            . $playerId);
        $firebase->getReference()->remove();

        $firebase->setReference('RoomList/'
            . $roomId . '/'
            . 'ready/'
            . $playerId);
        $firebase->getReference()->remove();

        return true;
    }

    public function setPlayerReadyInRoom($roomId) : bool
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/'
            . $roomId . '/'
            . 'ready/'
            . authPlayer()->getId());

        $firebase->setValue(true);

        return true;
    }

    public function resetAllPlayerReadyInRoom($roomId) : bool
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/'
            . $roomId . '/'
            . 'ready');

        $firebase->setValue(true);

        return true;
    }

    public function updatePlayerShape($roomId, $playerId, $shape) : bool
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('ActiveRooms/'
            . $roomId . '/'
            . $playerId);
        $firebase->setValue($shape);

        return true;
    }

    public function getRoomOpponent($roomId)
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/'
            . $roomId . '/players');
        $players = $firebase->getValue();

        $opponentId = $this->determineOpponentId($players);

        $playerRepo = new PlayerRepository();
        $opponent = PlayerDomain::createFromDataModel(
            $playerRepo->findById($opponentId)
        );

        return $opponent->toArray();
    }

    protected function determineOpponentId(array $playersId) : ?string
    {
        foreach ($playersId as $key => $value)
        {
            if($key != authPlayer()->getId())
                return $key;
        }

        return null;
    }

    public function getRoomData($roomId)
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/'
            . $roomId);
        return $firebase->getValue();
    }

}