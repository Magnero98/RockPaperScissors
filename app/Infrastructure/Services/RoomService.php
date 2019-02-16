<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2019
 * Time: 9:14 PM
 */

namespace App\Infrastructure\Services;

use App\Infrastructure\Repositories\FirebaseRepository;

class RoomService
{
    public function getRoomsLimitTo15Data($index = null) : array
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList');

        $rooms = isset($index)
                ? $firebase->getReference()
                            ->orderByKey()
                            ->limitToFirst(15)
                            ->startAt($index)
                            ->getSnapshot()
                            ->getValue()
                : $firebase->getReference()
                            ->orderByKey()
                            ->limitToFirst(15)
                            ->getSnapshot()
                            ->getValue();
        return $rooms;
    }

    public function createNewRoom()
    {

    }
}