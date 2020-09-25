<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iredirect'], function (Router $router) {
    \CRUD::resource('iredirect','redirect', 'RedirectController');
});

