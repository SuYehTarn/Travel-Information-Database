<?php

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

include_once(app_path().'/includes/funcs.php');
include_once(app_path().'/includes/Path_Builder.php');

Route::get('/', function () {
	$attras = DB::select('SELECT attra_name FROM attraction_location');
    return view('index', ['attras' => $attras]);
});

Route::get('/attractions/info={attra_name}', function($attra_name) {    
	$info = getInfo(urldecode($attra_name));
    return view('modal-info', $info);
});

Route::get('/path/from={attra_name1}+to={attra_name2}', function($attra_name1, $attra_name2) {
	$paths = getPaths(urldecode($attra_name1), urldecode($attra_name2)); 
    //return ;
    return json_encode([
    	'html' => view('modal-path', ['paths' => $paths])->render(),
    	'paths' => $paths
    ]);
});