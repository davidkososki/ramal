<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Admin;

//ROTA ADMIN
$obRouter->get('/admin', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Home::getHome($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);



