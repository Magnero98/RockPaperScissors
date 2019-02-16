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
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/Firebase/firebase_key.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)
                                ->create();

        $this->database = $firebase->getDatabase();
    }

    protected $database;
    protected $reference;

    public function getDatabase()	{ return $this->database; }
    public function getReference()	{ return $this->reference; }

    public function setReference($reference)	{ $this->reference = $this->database->getReference($reference); }


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