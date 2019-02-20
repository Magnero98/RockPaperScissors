<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/19/2019
 * Time: 10:56 AM
 */

namespace App\Domain\Models;


class PointsDomain
{
    public function __construct($value)
    {
        $this->value = $value;
    }

    protected $value;

    public function getValue()		{ return $this->value; }


    public function equals(PointsDomain $model)
    {
        if ($this->value == $model->getValue())
            return true;
    }

    public function add(PointsDomain $model)
    {
        return new PointsDomain(
            $this->value + $model->getValue());
    }

    public function substract(PointsDomain $model)
    {
        return new PointsDomain(
            $this->value - $model->getValue());
    }
}