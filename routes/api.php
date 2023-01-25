<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;


Route::middleware(['auth:api'])->group(function () {
    Route::get('/todos', [TodoController::class, 'index']);
    Route::post('/todos', [TodoController::class, 'store']);
    Route::put('/todos/{todo}', [TodoController::class,'update']);
    Route::delete('/todos/{todo}', [TodoController::class,'destroy']);
    Route::post('/oauth/clients', [clientController::class, 'createClient']);

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/test', function(ClientRepository $repo){

    $client = $repo->create(null, "Innocent", "https://todo12.requestcatcher.com");


  return   [
        "id" => $client->id,
        "name" => $client->name,
        "redirectUrl" => $client->redirect,
        "secret" => $client->plainSecret
    ];
});


Route::get ('/test2', function(){


    return $client = DB::select('select * from oauth_clients where id = ? ', [1]);


});




