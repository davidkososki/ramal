<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Admin;

//ROTA LOGIN GET
$obRouter->get('/admin/login', [
    'middlewares' => [
        'require-admin-logout'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Login::getLogin($request));//PASSA O STATUS E O CONTROLADOR
    }
]);

//ROTA LOGIN POST
$obRouter->post('/admin/login', [
    'middlewares' => [
        'require-admin-logout'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Login::setLogin($request));//PASSA O STATUS E O CONTROLADOR
    }
]);

//ROTA LOGOUT GET
$obRouter->get('/admin/logout', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Login::setLogout($request));//PASSA O STATUS E O CONTROLADOR
    }
]);

