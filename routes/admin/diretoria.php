<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Admin;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$obRouter->get('/admin/diretoria', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::getDiretoria($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO
$obRouter->get('/admin/diretoria/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::getNewDiretoria($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE CADASTRO DE UM NOVO DEPOIMENTO (POST)
$obRouter->post('/admin/diretoria/new', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::setNewDiretoria($request));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM DEPOIMENTO
$obRouter->get('/admin/diretoria/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::getEditDiretoria($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EDIÇÃO DE UM DEPOIMENTO (POST)
$obRouter->post('/admin/diretoria/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::setEditDiretoria($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);

//ROTA DE EXCLUSÃO DE UM DEPOIMENTO
$obRouter->get('/admin/diretoria/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::getDeleteDiretoria($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


//ROTA DE EXCLUSÃO DE UM DEPOIMENTO
$obRouter->post('/admin/diretoria/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
        ],
    function($request,$id){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Admin\Diretoria::setDeleteDiretoria($request,$id));//PASSA O STATUS E O CONTROLADOR DA HOME
    }
]);


