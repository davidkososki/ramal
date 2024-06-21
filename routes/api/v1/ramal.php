<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Api;

// ROTA RAIZ DA API
$obRouter->get('/api/v1/apiRamal',[
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200, Api\ApiRamalController::getRamais($request), 'application/json');
    }
]);

// ROTA DE CONSULTA INDIVIDUAL DE RAMAIS
$obRouter->get('/api/v1/apiRamal/{id}',[
    'middlewares' => [
        'api'
    ],
    function($request,$id){
        return new Response(200, Api\ApiRamalController::getRamal($request,$id), 'application/json');
    }
]);

// ROTA DE CONSULTA INDIVIDUAL DE RAMAIS
$obRouter->get('/api/v1/apiRamal/{data}',[
    'middlewares' => [
        'api'
    ],
    function($request,$id){
        return new Response(200, Api\ApiRamalController::getRamalData($request,$id), 'application/json');
    }
]);