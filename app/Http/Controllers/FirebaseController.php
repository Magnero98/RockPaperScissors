<?php

namespace App\Http\Controllers;

use App\Domain\Models\DomainModel;
use App\Domain\Models\Guid;
use App\Domain\Models\PlayerDomain;
use App\Infrastructure\Models\Player;
use App\Infrastructure\Repositories\FirebaseRepository;
use App\Infrastructure\Repositories\PlayerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    public function index()
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('RoomList/31b4d70f-804c-4e2e-ad24-3341dbab9c56/players');
        return $firebase->getValue();
    }

    public function getId(Request $request)
    {
        $roomId = Guid::generateId();

        $firebase = new FirebaseRepository();

        $firebase->setReference('RoomList');
        return $firebase->getValue();
    }
}
