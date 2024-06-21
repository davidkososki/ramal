<?php

namespace Sed\Ramal\Controller\Api;

use Sed\Ramal\Model\RamalModel;
use WilliamCosta\DatabaseManager\Pagination;

class ApiRamalController extends Api{

    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */
    public static function getRamalItens($request, &$obPagination){
        //DEPOIMENTOS
        $itens = [];
        
        //QUANTIDADE TOAL DE REGISTROS
        $quantidadetotal = RamalModel::getRamal(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
        
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 20);
        
        //RESULTADOS DA PÁGINA
        $results = RamalModel::getRamal(null, 'id DESC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obRamal = $results->fetchObject(RamalModel::class)){
            $itens[] = [
                'id' => $obRamal->id,    
                'nome' => $obRamal->nome,
                'ramal' => $obRamal->ramal,
                'departamento' => $obRamal->departamento,
                'email' => $obRamal->email,
                'celular' => $obRamal->celular
            ];
        }
        
        return $itens;
    }
    
    /**
     * 
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getRamal($request,$id) {
        //VALIDA O ID DO DEPOIMENTO
        if(!is_numeric($id)){
            throw new \Exception("O ID ".$id." não é válido.", 400);
        }

        //BUSCA DEPOIMENTO
        $obRamal = RamalModel::getRamalById($id);
        
        //VALIDA SE O DEPOIMENTO EXISTE
        if(!$obRamal instanceof RamalModel){
            throw new \Exception("O Ramal de ".$id." não foi encontrado.", 404);
        }
        
        return [
                'id' => $obRamal->id,    
                'nome' => $obRamal->nome,
                'ramal' => $obRamal->ramal,
                'departamento' => $obRamal->departamento,
                'email' => $obRamal->email,
                'celular' => $obRamal->celular
            ];
    }
        
     /**
     * Método responsável por retornar os detalhes da API
     * @param Request $request
     * @return array
     */
    public static function getRamais($request) {

        //DADOS DE RAMAIS
        return [
            'itens' => self::getRamalItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ];

    }

}
