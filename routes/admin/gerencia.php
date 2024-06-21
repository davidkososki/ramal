<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Admin;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->get('/admin/gerencia', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::getGerencia($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO
$obRouter->get('/admin/gerencia/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::getNewGerencia($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO (POST)
$obRouter->post('/admin/gerencia/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::setNewGerencia($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM DEPOIMENTO
$obRouter->get('/admin/gerencia/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::getEditGerencia($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM DEPOIMENTO (POST)
$obRouter->post('/admin/gerencia/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::setEditGerencia($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EXCLUSÃO DE UM DEPOIMENTO
$obRouter->get('/admin/gerencia/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::getDeleteGerencia($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


//ROTA DE EXCLUSÃO DE UM DEPOIMENTO
$obRouter->post('/admin/gerencia/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Gerencia::setDeleteGerencia($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


