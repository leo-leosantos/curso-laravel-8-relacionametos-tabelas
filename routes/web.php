<?php

use App\Models\{
    User,
    Preference
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/one-to-one', function () {
    $user =  User::with('preference')->find(3);
    $data = [
        'background_color' => '#fff',
    ];

    if ($user->preference) {

        $user->preference->update($data);
    } else {
        //$user->preference()->create([$data]);

        $preference = new Preference($data);
        $user->preference()->save($preference);

    }
    //$preference = $user->preference;


    $user->refresh();

    $user->preference->delete();
    $user->refresh();

    dd($user->preference);
});
