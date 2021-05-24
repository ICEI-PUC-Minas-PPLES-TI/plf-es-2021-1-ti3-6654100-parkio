<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
Lumen Documentation: https://lumen.laravel.com/docs/7.x/routing
*/


/**
 * API Routes
 */


$router->group(['prefix' => '/api'], function () use ($router) {
    $router->post('/auth', 'UserController@auth'); // Login Endpoint

    $router->group(['middleware' => ['jwt.auth']], function () use ($router) {
        //users
        $router->post('/users', ['uses' => 'UserController@create', 'auth' => ['A']]); // Route path (used for requests), Controller (Same name as in folder)@Public_function_name
        $router->get('/users', ['uses' => 'UserController@getAll', 'auth' => ['S','R','A']]);
        $router->get('/users/search', ['uses' => 'UserController@search', 'auth' => ['S','R','A']]);
        $router->delete('/users/{id}', ['uses' => 'UserController@delete', 'auth' => ['A']]);

        //complains
        $router->post('/complain', ['uses' => 'ComplainController@create', 'auth' => ['A', 'P']]); // Create a complain
        $router->delete('/complain/{id}', ['uses' => 'ComplainController@delete', 'auth' => ['A']]); //Delete a complain
        $router->get('/complain', ['uses' => 'ComplainController@getAll', 'auth' => ['A', 'P']]); // Get all the complains

        //gates
        $router->get('/gate', ['uses' => 'GateController@getAll', 'auth' => ['S','R','A', 'P']]); // Search for all gates
        $router->post('/gate', ['uses' => 'GateController@create', 'auth' => ['A']]); // Route path (used for requests), Controller (Same name as in folder)@Public_function_name
        $router->delete('/gate/{id}', ['uses' => 'GateController@delete', 'auth' => ['A']]);
        $router->get('/gate/{id}', ['uses' => 'GateController@search', 'auth' => ['A']]); // Find and return a gate
        $router->put('/gate', ['uses' => 'GateController@update', 'auth' => ['A']]); // Update a gate

        $router->get('/destinations', ['uses' => 'DestinationController@getAll', 'auth' => ['A', 'P']]);
        $router->post('/destinations', ['uses' => 'DestinationController@create', 'auth' => ['A']]);
        $router->put('/destinations/{id}', ['uses' => 'DestinationController@update', 'auth' => ['A']]);
        $router->delete('/destinations/{id}', ['uses' => 'DestinationController@delete', 'auth' => ['A']]);

        $router->get('/visitorCategory', ['uses' => 'VisitorCategoryController@getAll', 'auth' => ['A', 'P']]); // Route path (used for requests), Controller (Same name as in folder)@Public_function_name
        $router->post('/visitorCategory', ['uses' => 'VisitorCategoryController@create', 'auth' => ['A']]); // Route path (used for requests), Controller (Same name as in folder)@Public_function_name
        $router->delete('/visitorCategory/{id}', ['uses' => 'VisitorCategoryController@delete', 'auth' => ['A']]);
        $router->put('/visitorCategory', ['uses' => 'VisitorCategoryController@update', 'auth' => ['A']]);

        //vehicles
        $router->get('/vehicles', ['uses' => 'VehicleController@getAll', 'auth' => ['S','R','A', 'P']]); // Search for all vehicles entries
        $router->put('/vehicles/{id}', ['uses' => 'VehicleController@edit', 'auth' => ['R','A']]); // Edit one vehicles entries
        $router->get('/vehicles/search', ['uses' => 'VehicleController@search', 'auth' => ['A', 'P']]); // If exists, searches for the last row filtered by the vehicle plate (for autocomplete)
        $router->get('/vehicles/{id}', ['uses' => 'VehicleController@get', 'auth' => ['S','A', 'P']]); // If exists, searches for the last row filtered by the vehicle plate (for autocomplete)
        $router->post('/vehicles', ['uses' => 'VehicleController@create', 'auth' => ['S','R','A', 'P']]); // For saving incoming vehicles

        //delays
        $router->get('/delay', ['uses' => 'DelayController@getAll', 'auth' => ['A', 'P']]); // Search for all vehicles delays
        $router->post('/delay', ['uses' => 'DelayController@create', 'auth' => ['A', 'P']]); // Create delay for a specific vehicle
    });
});

/* Web Site Routes */
$router->get('/test', function () use ($router) { // used in Browser URL
    return view('pages.test'); // View Name (Same name as in resources/views), custom parameters
});

/*Begin - Web Site Routes */
$router->get('/auth', function () use ($router) {
    return view('pages.login');
});

// Needed auth routes
$router->group(['middleware' => ['web.auth']], function() use ($router) {
    $router->get('/', function () use ($router) {
        return view('pages.menu');
    });

    $router->get('/gate/{id}', function () use ($router) {
        return view('pages.gate');
    });

    $router->get('/vehiclelist', function () use ($router) {
        return view('pages.vehicleslist');
    });

    $router->get('/userlist', function () use ($router) {
        return view('pages.userlist');
    });

    $router->get('/admin', function () use ($router) {
        return view('pages.admin');
    });

});
