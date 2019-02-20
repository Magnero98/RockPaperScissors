<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/10/2019
 * Time: 2:02 PM
 */

namespace App\Infrastructure\Repositories;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseRepository
{
    public function __construct()
    {
        if(!isset(self::$database))
        {
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/Firebase/firebase_key.json');
            $firebase = (new Factory)->withServiceAccount($serviceAccount)
                                    ->create();

            self::$database = $firebase->getDatabase();
        }
    }

    protected static $database;
    protected $reference;

    public function getDatabase()	{ return self::$database; }
    public function getReference()	{ return $this->reference; }

    public function setReference($reference)	{ $this->reference = self::$database->getReference($reference); }


    public function getSnapshot()
    {
        return $this->reference->getSnapshot();
    }

    public function getValue()
    {
        return $this->reference->getValue();
    }

    public function setValue($newValue)
    {
        $this->reference->set($newValue);
    }
}