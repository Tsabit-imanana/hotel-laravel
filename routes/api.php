<?php

use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

use App\Http\Controllers\TypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersDetailController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['jwt.verify']], function(){
    Route::group(['middleware' => ['api.receptionist']], function(){

        Route::put('/orders/status/{id}', [OrderController::class, 'upstatus']); //update status
        Route::post('/orderfilter', [OrderController::class, 'orderFilter']);
        Route::get('/orders', [OrderController::class, 'show']);
        Route::get('/orders/{id}', [OrderController::class, 'detail']);
        Route::put('/orders/{id}', [OrderController::class,'store']); //TIDAK PERLU

    });
    Route::group(['middleware' => ['api.admin']], function(){
        // CRUD user
        Route::post('/register', [UserController::class, 'register']);
        Route::put('/user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'delete']);
        Route::get('/user', [UserController::class, 'show']);

            // CRUD type
        Route::post('/type',[TypeController::class,'store']);
        Route::delete('/type/{id}',[TypeController::class,'destroy']);
        Route::post('/type/{id}', [TypeController::class,'update']);


        // CRUD room
        Route::get('/room',[RoomController::class,'show']); 
        Route::get('/room/{id}',[RoomController::class,'detail']); 
        Route::post('/room',[RoomController::class,'store']);
        Route::delete('/room/{id}',[RoomController::class,'destroy']);
        Route::put('/room/{id}', [RoomController::class,'update']);
    });
    
});


    Route::get('/type',[TypeController::class,'show']);
    Route::get('/type/{id}',[TypeController::class,'detail']);
    Route::get('/type/detail/{type_id}',[TypeController::class,'detailType']); // TIDAK PERLU


//Orders
Route::post('/orders', [OrderController::class,'create']); //bikin order

//date filter
Route::post('/datefilter',[OrdersDetailController::class, 'index']);

//check order
// Route::post('/checkorder',[OrdersDetailController::class, 'checkorder']);

//reciept
Route::get('/receipt/{order_number}',[OrdersDetailController::class, 'reciept']);


Route::post('/login', [UserController::class, 'login']);



