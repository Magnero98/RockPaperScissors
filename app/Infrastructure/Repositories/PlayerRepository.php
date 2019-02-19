<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/12/2019
 * Time: 7:41 AM
 */

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Guid;
use App\Domain\Models\PlayerDomain;
use App\Infrastructure\Models\Player;

class PlayerRepository
{
    public function findById(string $id) : ?Player
    {
        $player = Player::where('id', 'LIKE', $id)
            ->get(['id', 'username', 'gender', 'points'])
            ->first();
        return $player;
    }

    public function findByUsername(string $username) : ?Player
    {
        $player = Player::where('username', 'LIKE', $username)
            ->first();
        return $player;
    }

    public function loginUser(string $username, string $password) : ?Player
    {
        $player = Player::where('username', 'LIKE', $username)
            ->where('password', 'LIKE', $password)
            ->get(['id', 'username', 'gender', 'points'])
            ->first();
        return $player;
    }

    public function insertNewPlayer(array $data) : Player
    {
        $player = new Player();

        $player->id = Guid::generateId();
        $player->username = $data['username'];
        $player->password = $data['password'];
        $player->gender = $data['gender'];
        $player->points = 0;

        return $player;
    }

    public function updatePlayer(PlayerDomain $model)
    {
        $player = $this->findById($model->getId());

        $player->username = $model->getUsername();
        $player->gender = $model->getGender();
        $player->points = $model->getPoints()->getValue();

        $player->save();
    }
}