<?php

namespace App\Http\Controllers;

use App\Domain\Models\DomainModel;
use App\Domain\Models\Guid;
use App\Domain\Models\PlayerDomain;
use App\Infrastructure\Models\Player;
use App\Infrastructure\Repositories\FirebaseRepository;
use App\Infrastructure\Repositories\PlayerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    public function index()
    {
        $firebase = new FirebaseRepository();
        $firebase->setReference("Subjects/-LERI23i894DSU34dh43P/SubjectCategories/CategoriesName/0");

        return var_dump($firebase->setValue("Mimi"));
    }

    public function getId()
    {
        $redis = app()->make('redis');
        $redis->set("me", "his");
        return $redis->get("me");
    }
}
