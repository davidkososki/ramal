<?php

namespace Sed\Ramal\Controller\Api;

class Api{
    
    /**
     * Método responsável por retornar os detalhes da API
     * @param Request $request
     * @return array
     */
    public static function getDetails($request) {
        return [
            'nome' => 'API',
            'versão' => 'v1.0.0.0',
            'autor' => 'David Kososki',
            'email' => 'davidkososki@sed.sc.gov.br'
        ];
    }
    
    /**
     * 
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    public static function getPagination($request, $obPagination) {
        //QUERY PARAMS 
        $queryParams = $request->getQueryParams();
        
        //PÁGINA
        $pages = $obPagination->getPages();
        
        //RETORNO
        return [
            'paginaAtual' => isset($queryParams['page']) ? $queryParams['page'] : 1,
            'quantidadePaginas' => !empty($pages) ? count($pages) : 1
        ];
    }
    
    
}

