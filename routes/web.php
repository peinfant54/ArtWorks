<?php

use App\User;
//use App;




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
    //$artist = \App\Models\SysModel\SysObra::all();
    //DebugBar::info($artist);
    //dd(Request::ip());
    //app('debugbar')->info($artist);
    //dd(Request::ip());
    return view('auth.login');
});

Route::get('index', function(){
    //dd(Request::ip());
   return view('auth.login');
});

Route::get('admin/logout', function()
{
    Auth::logout();
    return view('admin/logout');
});


Route::get('/logout', function()
{
    Auth::logout();
    return view('auth.login');
});

/* Autentificacion del Sistema **/

Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
//Password reset routes
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('register', 'Auth\RegisterController@showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register');

/* Termino Autentificacion del Sistema **/


/*
Route::post('/register', function()
{
    $user = new User;
    $user->email = Input::get('email');
    $user->username = Input::get('username');
    $user->password = Hash::make(Input::get('password'));

    $user->save();
    $theEmail = Input::get('email');

    return view('thanks')->with('theEmail', $theEmail);
});*/

/*-********************** Links de Administración************************/



Route::post('admin/login', function()
{

    return Redirect::to('admin/index');

    //return view('admin/login');
});
//Route::get('admin/localization/{lang?}', 'LanguageLocalizationController@inbdex');
Route::get('admin/index', 'HomeController@AdminIndex')->middleware('auth');
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageLocalizationController@index']);

/* Inicio Rutas Modulo User */
Route::get('admin/user/index', 'admin\user\UserController@UserIndex')->middleware('auth');
Route::post('admin/user/delete','admin\user\UserController@UserDestroy')->middleware('auth');
Route::post('admin/user/create','admin\user\UserController@UserCreate')->middleware('auth');
Route::put('admin/user/edit','admin\user\UserController@UserEdit')->middleware('auth');
Route::put('admin/user/pass2','admin\user\UserController@UserEditPass')->middleware('auth');
Route::put('admin/user/pass3','admin\user\UserController@UserEditPassUser')->middleware('auth');
Route::post('admin/user/pass','admin\user\UserController@UserCheckPass')->middleware('auth');
Route::get('admin/user/changepassword','admin\user\UserController@UserChangePassword')->middleware('auth');
/* Termino Rutas Modulo User */
/* Incio Rutas modulo Perfiles*/
Route::get('admin/profile/index', 'admin\profile\ProfileController@ProfileIndex')->middleware('auth');
Route::post('admin/profile/delete','admin\profile\ProfileController@ProfileDestroy')->middleware('auth');
Route::post('admin/profile/create','admin\profile\ProfileController@ProfileCreate')->middleware('auth');
Route::post('admin/profile/edit','admin\profile\ProfileController@ProfileEdit')->middleware('auth');
Route::post('admin/profile/permissions','admin\profile\ProfileController@ProfilePermissions')->middleware('auth');

/* Terminop Rutas modulo Perfiles*/

/* Incio Rutas modulo Log*/

Route::get('admin/log/index', 'admin\log\LogController@LogIndex')->middleware('auth');
Route::get('admin/log/summary', 'admin\log\LogController@LogSummary')->middleware('auth');
Route::get('admin/log/summary/search/{opc}/{id}/{opc2}', 'art\search\SearchController@Summary')->middleware('auth');
Route::get('admin/log/summary/search2/{opc}/{id}/{opc2}', 'art\search\SearchController@SummaryArtist')->middleware('auth');

/* Termino Rutas modulo Log*/

/* Incio Rutas modulo Ubicaciones*/
Route::get('art/location/index', 'art\location\LocationController@LocationIndex')->middleware('auth');
Route::post('art/location/delete','art\location\LocationController@LocationDestroy')->middleware('auth');
Route::post('art/location/create','art\location\LocationController@LocationCreate')->middleware('auth');
Route::post('art/location/edit','art\location\LocationController@LocationEdit')->middleware('auth');
Route::get('art/location/export/{id}','art\location\LocationController@LocationExport')->middleware('auth');
Route::post('art/location/pdfexport','art\location\LocationController@LocationExportpdf')->middleware('auth');

/* Cuando una Routa POST no funciona es por el CsrToken. Desabilitar en Middleware/VerifyCsrfToken.php*/


/* Terminop Rutas modulo Ubicaciones*/


/* Incio Rutas modulo Obras*/
Route::get('art/obra/index', 'art\obra\ObraController@ObraIndex')->middleware('auth');
Route::post('art/obra/delete','art\obra\ObraController@ObraDestroy')->middleware('auth');
Route::post('art/obra/deletepdf','art\obra\ObraController@ObraPdfDestroy')->middleware('auth');
Route::post('art/obra/create','art\obra\ObraController@ObraCreate')->middleware('auth');
Route::post('art/obra/create2','art\obra\ObraController@ObraCreateArtist')->middleware('auth');
Route::post('art/obra/createpdf','art\obra\ObraController@ObraCreatePdf')->middleware('auth');
Route::post('art/obra/edit','art\obra\ObraController@ObraEdit')->middleware('auth');
Route::get('art/obra/edit/{id}/{opc}/{textsearch}/{opc2}/{xid}','art\obra\ObraController@ObraEditIndex')->middleware('auth');
Route::get('art/obra/pdf/{id}','art\obra\ObraController@ObraPdfIndex')->middleware('auth');
Route::get('art/obra/list/{id}','art\obra\ObraController@ObraByArtist')->middleware('auth');
Route::get('art/obra/exportArt/{id}','art\obra\ObraController@ObraPdf')->middleware('auth');
//Route::get('art/obra/export','art\obra\ObraController@ObraExport')->middleware('auth');
/* Terminop Rutas modulo Obras*/

/* Incio Rutas modulo Artista*/
Route::get('art/artist/index', 'art\artist\ArtistController@ArtistIndex')->middleware('auth');
Route::post('art/artist/delete','art\artist\ArtistController@ArtistDestroy')->middleware('auth');
Route::post('art/artist/create','art\artist\ArtistController@ArtistCreate')->middleware('auth');
Route::post('art/artist/edit','art\artist\ArtistController@ArtistEdit')->middleware('auth');
Route::get('art/artist/export/{id}','art\artist\ArtistController@ArtistExport')->middleware('auth');

Route::post('art/artist/pdfexport','art\artist\ArtistController@ArtistExportpdf')->middleware('auth');


/* Terminop Rutas modulo Artista*/


/* Inicio Rutas modulo Search*/
Route::post('art/search','art\search\SearchController@Index')->middleware('auth');
Route::get('art/search/{text}','art\search\SearchController@SearchIndex')->middleware('auth');
Route::get('art/search1/{text}','art\search\SearchController1@SearchIndex')->middleware('auth');
//Route::get('art/{text}','art\search\SearchController@SearchIndex')->middleware('auth');
/*Route::post('art/search', function()
{
    $texto = Input::get('textsearch');
    dd($texto);
});*/

Route::get('art/search/details/{opc}/{textsearch}/{opc2}','art\search\SearchController@SearchDetails')->middleware('auth');
Route::get('art/search/details2/{opc}/{id}/{textsearch}/{opc2}','art\search\SearchController@SearchDetails2')->middleware('auth');
/* Termino Rutas modulo Search*/


/*-********************** Termino Links de Administración************************/
Auth::routes();

/* Ver el tema de las urles correctamente */

Route::any('/info', function()
{
    echo "Hello Wolrd";
    phpinfo();
});
