<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Admin;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->get('/admin/ramais', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::getRamal($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO
$obRouter->get('/admin/ramais/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::getNewRamal($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO (POST)
$obRouter->post('/admin/ramais/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::setNewRamal($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM DEPOIMENTO
$obRouter->get('/admin/ramais/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::getEditRamal($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM DEPOIMENTO (POST)
$obRouter->post('/admin/ramais/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::setEditRamal($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EXCLUSÃO DE UM DEPOIMENTO
$obRouter->get('/admin/ramais/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::getDeleteRamal($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


//ROTA DE EXCLUSÃO DE UM DEPOIMENTO
$obRouter->post('/admin/ramais/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Ramal::setDeleteRamal($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


