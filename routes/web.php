<?php

use App\Models\{
    Image,
    Permission,
    User,
    Preference
};
use Faker\Provider\ar_EG\Person;
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

Route::get('many-to-many-pivot', function(){
    $user = User::with('permissions')->find(1);

    $user->permissions()->attach([
        1 => [ 'active'=> false],
        3 => [ 'active'=> false],

    ]);
    $user->refresh();

    echo "<b>{$user->name}</b> </br>";

    foreach ($user->permissions as $permission)
    {
        echo "{$permission->name} - {$permission->pivot->active} </br>";
    }

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


Route::get('/many-to-many', function(){
   // dd(Permission::create(['name'=>'menu_03']));
   $user = User::with('permissions')->find(1);
   //$permission = Permission::find(1);

  // $user->permissions()->save($permission);
//   $user->permissions()->saveMany([
//     Permission::find(1),
//     Permission::find(2),
//     Permission::find(3)
//   ]);


$user->refresh();

  //$user->permissions()->sync([2]);
  //$user->permissions()->attach([1,3]);
  $user->permissions()->detach([1,3]);

  $user->refresh();
   dd($user->permissions);
});


Route::get('/one-to-one-polymorphic' , function(){
    $user = User::first();

    $data =['path'=>'path/nome-image3.png'];


   // $user->image->delete();

    if($user->image){
        $user->image->update($data);
    }else{

        $user->image()->create($data);

    }

    // $user->image()->save(
    //     new Image(['path'=>'path/nome-image.png'])
    // );

    dd($user->image);

});
