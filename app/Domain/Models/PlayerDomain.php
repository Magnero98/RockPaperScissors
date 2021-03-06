<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/11/2019
 * Time: 7:00 PM
 */

namespace App\Domain\Models;


use App\Infrastructure\Models\Player;
use App\Infrastructure\Repositories\PlayerRepository;
use App\Infrastructure\Services\JoinRoomService;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Cookie;

class PlayerDomain extends Entity
{
    public function __construct(
        $id,
        $username,
        $points,
        $gender)
    {
        $this->id = $id;
        $this->username = $username;
        $this->points = new PointsDomain($points);
        $this->gender = $gender;
        $this->joinRoomService = new JoinRoomService($this);
    }

    protected $username;
    protected $points;
    protected $gender;
    protected $joinRoomService;

    public function getUsername()		{ return $this->username; }
    public function getPoints()			{ return $this->points; }
    public function getGender()			{ return $this->gender; }
    public function getJoinRoomService(){ return $this->joinRoomService; }

    public function setUsername( $value ) 		{ $this->username = $value; }
    public function setPoints( $value ) 		{ $this->points = $value; }
    public function setGender( $value ) 		{ $this->gender = $value; }


    public static function createFromDataModel(Player $player) : PlayerDomain
    {
        return new PlayerDomain(
            $player->id,
            $player->username,
            $player->points,
            $player->gender
        );
    }

    public function toArray() : array
    {
        $player = [
            'id' => $this->id,
            'username' => $this->username,
            'points' => $this->points->getValue(),
            'gender' => $this->gender
        ];

        return $player;
    }

    public function saveToSession()
    {
        session(['authPlayer' => $this]);
    }

    public function saveToDatabase()
    {
        $playerRepo = new PlayerRepository();
        $playerRepo->updatePlayer($this);
    }
}