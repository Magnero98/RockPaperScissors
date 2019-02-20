<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/11/2019
 * Time: 7:32 PM
 */

namespace App\Domain\Models;


abstract class Entity
{
    protected $id;

    public function getId()			{ return $this->id; }

    /**
     * Entity comparison with ID
     * @param Entity
     * @return bool
     */

    public function equals(Entity $model) : bool
    {
        if($model == null) return false;
        if($model->getId() != $this->getId()) return false;
        return true;
    }
}