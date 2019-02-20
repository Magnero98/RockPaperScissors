<?php

namespace App\Http\Controllers;

use App\Domain\Models\Entity;
use App\Domain\Models\Guid;
use App\Domain\Models\PlayerDomain;
use App\Infrastructure\Models\Player;
use App\Infrastructure\Repositories\FirebaseRepository;
use App\Infrastructure\Repositories\PlayerRepository;
use App\Infrastructure\Services\GameService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    public function index()
    {
        $gameService = new GameService();
        $result = $gameService->chooseTheWinnerPlayer('e424945f-3389-409e-a1b5-bc8829d61b82');

        return $result;
    }

    public function getId(Request $request)
    {
        $roomId = Guid::generateId();

        $firebase = new FirebaseRepository();

        $firebase->setReference('RoomList');
        return $firebase->getValue();
    }
}
