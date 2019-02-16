<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/12/2019
 * Time: 9:11 PM
 */

namespace App\Domain\Services;


use App\Domain\Models\PlayerDomain;
use App\Infrastructure\Repositories\PlayerRepository;
use Illuminate\Support\Facades\Cache;
use function MongoDB\BSON\toJSON;

class PlayerService
{
    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
    }

    protected $playerRepo;

    public function login(array $data) : bool
    {
        $player = $this->playerRepo->loginUser(
            $data['username'],
            $data['password']
        );

        if(isset($player))
        {
            $authPlayer = PlayerDomain::createFromDataModel($player);
            $authPlayer->saveToSession();
            //echo json_encode(authPlayer());
        }

        return isset($player);
    }

    public function logout($sessionId) : bool
    {
        return deleteSessionFile($sessionId);
    }

    public function register(array $data) : bool
    {
        if(!$this->usernameHasBeenTaken($data['username']))
        {
            $playerDomain = PlayerDomain::createFromDataModel(
                                $this->playerRepo->insertNewPlayer($data));
            $playerDomain->saveToSession();
            return true;
        }
        return false;
    }

    public function usernameHasBeenTaken(string $username) : bool
    {
        $player = $this->playerRepo->findByUsername($username);
        return isset($player);
    }

    public function getAuthPlayer()
    {
        return authPlayer();
    }
}