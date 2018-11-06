<?php
use Dingo\Api\Routing\Router;

$api = app( Router::class );
$api->version('v1',function ( Router $api ){
    $api->group(['prefix' => 'session', 'namespace' => 'App\Api\Controllers'], function (Router $api){
        $api->get('/{sessionId}', 'SessionController@show');
    });
});
