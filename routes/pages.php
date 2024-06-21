<?php

use Sed\Ramal\Http\Response;
use Sed\Ramal\Controller\Pages;

//ROTA HOME
$obRouter->get('', [
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
        return new Response(200, Pages\RamalController::searchRamal($request));//PASSA O STATUS E O CONTROLADOR DO RAMAL
    }
]);

//ROTA RAMAL (SEARCH)
$obRouter->post('', [
    function($request){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE      
        return new Response(200, Pages\RamalController::searchRamal($request));//PASSA O REQUEST PARA O INSERT
    }
]);

//ROTA DINÂMICA
//$obRouter->get('/pagina/{idPagina}/{acao}', [
//    function($idPagina, $acao){//FUNÇÃO ANÔNIMA QUE RETORNA UMA INSTÂNCIA DE RESPONSE
//        return new Response(200, 'Página '.$idPagina.' - '.$acao);//PASSA O STATUS E O CONTROLADOR DA PÁGINA DINÂMICA
//    }
//]);

//echo '<pre>';
//print_r($request);
//echo '</pre>';exit;
