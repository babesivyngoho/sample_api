<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['prefix' => ''], function () use ($router) {
    // User Auth
    $router->post('login','UserController@login');
    $router->post('loginUsingFB', ['uses' => 'UserController@loginUsingFB']);

    $router->get('getUserPermissions', ['uses' => 'UserController@getUserPermissions']);

    $router->post('register', 'UserController@register');
    $router->get('home/search', ['uses' => 'PlayerController@showByName']);
    $router->get('home/search/player_product', ['uses' => 'PlayerController@showPlayerProducts']);
    $router->get('home/search/product', ['uses' => 'ProductController@showByName']);
    $router->get('home/search/player', ['uses' => 'PlayerController@getPlayer']);
    $router->get('home/search/final_player', ['uses' => 'PlayerController@getFinalPlayer']);
    $router->get('home/search/actor', ['uses' => 'PlayerController@getActor']);
    $router->get('home/search/player_by_product', ['uses' => 'PlayerController@getPlayerByProduct']);
    $router->get('home/search/allproducts', ['uses' => 'ProductController@show']);
    $router->get('home/search/alllocations', ['uses' => 'AddressController@show']);
});

$router->group(['prefix' => 'account'], function () use ($router) {
    $router->post('change/profile', 'UserController@updateProfile');
    $router->post('change/password', 'UserController@updatePassword');
    $router->get('status', ['uses' => 'UserController@show']);
    $router->get('status/roles', ['uses' => 'UserController@showRoles']);
    $router->get('status/permissions', ['uses' => 'UserController@showPermissions']);
    $router->get('status/get_player', ['uses' => 'PlayerController@getPlayerByRepresentative']);
    $router->get('status/get_player_by_address', ['uses' => 'PlayerController@getPlayerByAddress']);
    $router->post('update_permissions', 'UserController@updatePermissions');
    $router->post('delete_permissions', 'UserController@deletePermissions');
});


$router->group(['prefix' => 'api'], function () use ($router){

    // USER ROUTES
    $router->get('users', ['uses' => 'UserController@show']);


    // VCPLAYER ROUTES
    $router->get('players', ['uses' => 'PlayerController@show']);
    $router->get('player/search', ['uses' => 'PlayerController@showByName']);
    $router->get('player/products', ['uses' => 'PlayerController@showPlayerProducts']);


    // PRODUCT ROUTES
    $router->get('products', ['uses' => 'ProductController@show']);
    $router->get('products/search', ['uses' => 'ProductController@showByName']);
});

$router->group(['prefix' => 'home'], function () use ($router){
    $router->get('vcmgt/data/players', ['uses' => 'PlayerController@show']);
    $router->post('vcmgt/data/input', 'PlayerController@addPlayer');
    $router->post('vcmgt/data/edit', 'PlayerController@editPlayer');
    $router->post('vcmgt/data/input_again', 'PlayerController@addPlayerAgain');
    
    $router->post('vcmgt/data/delete', 'PlayerController@deletePlayerProduct');

    $router->post('vcmgt/data/input/product', 'ProductController@addProduct');
    $router->post('vcmgt/data/input/edit_product', 'ProductController@editPlayerProduct');
    
    $router->post('vcmgt/data/input/majorinput', 'InputController@addInput');
    $router->get('vcmgt/data/input/player_product_input', ['uses' => 'InputController@getPlayerProductInput']); 
    $router->post('vcmgt/data/input/supplier', 'TransactionController@addSupplierTransaction');
    $router->post('vcmgt/data/input/buyer', 'TransactionController@addBuyerTransaction');
    $router->post('vcmgt/data/input/enabler', 'EnablerController@addEnabler');
    $router->post('vcmgt/data/input/representative', 'UserController@addUser');
    $router->post('vcmgt/data/input/industryplayer', 'TransactionController@addIndustryPlayer');
    $router->get('vcmgt/data/user', ['uses' => 'UserController@searchUser']);
    $router->post('vcmgt/data/set_representative', 'PlayerController@setRepresentative');
    $router->post('vcmgt/data/delete_player', 'PlayerController@deletePlayer');
    $router->get('vcmgt/data/get_player', ['uses' => 'PlayerController@getPlayerByPlayerID']);
    $router->get('vcmgt/data/get_input', ['uses' => 'InputController@getInput']);
    $router->get('vcmgt/graph/vcplayer/supplier', ['uses' => 'TransactionController@getSupplier']);
    $router->get('vcmgt/graph/vcplayer/buyer', ['uses' => 'TransactionController@getBuyer']);
    $router->get('vcmgt/graph/products/get_input_name', ['uses' => 'InputController@getInputByName']);
    $router->get('vcmgt/graph/products/get_ppinput_by_input', ['uses' => 'InputController@getPlayerProductInputByInput']);
    $router->get('vcmgt/graph/products/get_pproduct_by_input', ['uses' => 'InputController@getPlayerProductByInput']);
    $router->get('vcmgt/data/input/get_enabler_product', ['uses' => 'EnablerController@getEnablerProduct']);
    $router->get('vcmgt/data/input/get_enabler', ['uses' => 'EnablerController@getEnabler']);
    $router->get('vcmgt/data/get_regions', ['uses' => 'AddressController@getRegions']);
    $router->get('vcmgt/data/get_provinces', ['uses' => 'AddressController@getProvinces']);
    $router->get('vcmgt/data/get_province_name', ['uses' => 'AddressController@getProvinceName']);
    $router->get('vcmgt/data/get_municipalities', ['uses' => 'AddressController@getMunicipalities']);
    $router->get('vcmgt/data/get_municipality_name', ['uses' => 'AddressController@getMunicipalityName']);
    $router->get('vcmgt/data/get_business_address', ['uses' => 'AddressController@getBusinessAddress']);
    $router->get('vcmgt/data/get_all_municipalities', ['uses' => 'AddressController@getAllMunicipalities']);

});
