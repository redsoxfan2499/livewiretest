<?php

use App\Livewire;
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

Route::post('/livewire', function(){
   // get a component from snapshot
    $component = (new Livewire)->fromSnapshot(request('snapshot'));
    // call a method on a component
    if($method = request('callMethod')) {
        (new Livewire)->callMethod($component,$method);
    }

    [$html, $snapshot] = (new Livewire)->toSnapshot($component);
    // turn component back into a snapshot and get the HTML
    return [
        'html' => $html,
        'snapshot'  => $snapshot,
    ];
    // send that stuff to the frontend
});

Blade::directive('livewire', function($expression){
   return "<?php echo  (new App\Livewire)->initialRender({$expression}) ?>";
});
