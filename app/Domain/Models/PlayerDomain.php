<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/11/2019
 * Time: 7:00 PM
 */

namespace App\Domain\Models;


use App\Infrastructure\Models\Player;
use App\Infrastructure\Services\JoinRoomService;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Cookie;

class PlayerDomain extends DomainModel
{
    public function __construct(
        $id,
        $username,
        $points,
        $gender)
    {
        $this->id = $id;
        $this->username = $username;
        $this->points = $points;
        $this->gender = $gender;
        $this->joinRoomService = new JoinRoomService();
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

    public function toDataModel() : Player
    {
        $player = new Player();

        $player->id = $this->id;
        $player->username = $this->username;
        $player->points = $this->points;
        $player->gender = $this->gender;

        return $player;
    }

    public function saveToSession()
    {
        session(['authPlayer' => $this]);
    }
}