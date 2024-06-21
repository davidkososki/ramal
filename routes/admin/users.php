<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Admin;

//ROTA DE LISTAGEM DE USUÁRIOS
$obRouter->get('/admin/users', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::getUsers($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO USUÁRIO
$obRouter->get('/admin/users/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::getNewUsers($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO USUÁRIO (POST)
$obRouter->post('/admin/users/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::setNewUsers($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM USUÁRIO
$obRouter->get('/admin/users/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::getEditUsers($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM USUÁRIO (POST)
$obRouter->post('/admin/users/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::setEditUsers($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EXCLUSÃO DE UM USUÁRIO
$obRouter->get('/admin/users/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::getDeleteUsers($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


//ROTA DE EXCLUSÃO DE UM USUÁRIO
$obRouter->post('/admin/users/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Users::setDeleteUsers($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


