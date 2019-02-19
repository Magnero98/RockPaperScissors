<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/19/2019
 * Time: 10:06 AM
 */

namespace App\Infrastructure\Services;


use App\Domain\Models\PointsDomain;
use App\Domain\Models\Shapes;
use App\Infrastructure\Repositories\FirebaseRepository;

class GameService
{
    public function setPlayerShape($roomId, $shape) : bool
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('ActiveRooms/'
                                . $roomId . '/'
                                . authPlayer()->getId());
        $firebase->setValue($shape);

        return true;
    }

    public function determineGameResultAndGiveRewardOrPenalty($roomId)
    {
        $winnerPlayer = $this->chooseTheWinnerPlayer($roomId);
        if($winnerPlayer == 'Invalid')
            return $winnerPlayer;

        if(authPlayer()->getId() == $winnerPlayer)
            authPlayer()->setPoints(
                authPlayer()->getPoints()
                            ->add(new PointsDomain(10))
            );
        else
            authPlayer()->setPoints(
                authPlayer()->getPoints()
                            ->substract(new PointsDomain(10))
            );

        authPlayer()->saveToDatabase();

        return $winnerPlayer;
    }

    protected function chooseTheWinnerPlayer($roomId) : array
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference('ActiveRooms/' . $roomId);
        $result = $firebase->getValue();

        $playerShapes = [];
        $firstShape = $secondShape = -1;
        foreach ($result as $key => $value)
        {
            if($value == -1)
                return [];

            $playerShapes[$value] = $key;
            if($firstShape == -1)
                $firstShape = $value;
            else
                $secondShape = $value;
        }

        $winnerShape = $this->calculateWinnerShape($firstShape, $secondShape);

        $result['winnerShape'] = $winnerShape;
        $result['playersShape'] = $playerShapes;

        return $result;
    }

    protected function calculateWinnerShape($firstShape, $secondShape)
    {
        if($firstShape == $secondShape)
            return Shapes::NotSet;

        if($firstShape == Shapes::NotSet)
            return $secondShape;

        if($secondShape == Shapes::NotSet)
            return $firstShape;

        if(($firstShape == Shapes::Rock && $secondShape == Shapes::Paper)
        || $secondShape == Shapes::Rock && $firstShape == Shapes::Paper)
            return Shapes::Paper;

        if(($firstShape == Shapes::Rock && $secondShape == Shapes::Scissors)
        || $secondShape == Shapes::Rock && $firstShape == Shapes::Scissors)
            return Shapes::Rock;

        if(($firstShape == Shapes::Paper && $secondShape == Shapes::Scissors)
        || $secondShape == Shapes::Paper && $firstShape == Shapes::Scissors)
            return Shapes::Scissors;

    }
}