<?php

namespace Sed\Ramal\Controller\Pages;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\RamalModel;
use WilliamCosta\DatabaseManager\Pagination;

class RamalController extends Page {

    /**
     * Método responsável por os itens de Ramal para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */
    public static function getRamalItens($request, &$obPagination){
        //RESULTADOS DA PÁGINA
        $results = RamalModel::getRamal(null, 'id_pessoa', 50);
        
        // Os dados em array
        $obRamal = $results->fetchAll();

        // Convertendo para JSON
        $dados_json = json_encode($obRamal);

        return $dados_json;
    }
        
     /**
     * Método responsável por retornar o conteúdo (através do model e view) de depoimentos
     * @return string
     */
    public static function getRamal($request) {
        //VIEW DE DEPOIMENTOS
        $content = View::render('pages/ramais', [
            'ramais' => self::getRamalItens($request, $obPagination)
        ]);
        
        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Ramal', $content);
    }

/**
     * Método responsável por catastrar um depoimento
     * @return string
     */
    public static function searchRamal($request) {
        //DADOS DO POST
        $postVars = $request->getPostVars();
        
        //VERIFICA SE FOI REQUISITADA A PESQUISA
        $value = $postVars['search'] ?? '';

        //PASSA DADOS PARA PESQUISA
        $results = RamalModel::searchRamal("nome_pessoa LIKE '%".$value."%'", "nome_pessoa ASC", 50,"nome_pessoa, email_pessoa, telefone_pessoa, andar_pessoa, sigla_gerencia, sigla_diretoria");
        
        //PEGA DADOS DA PESQUISA EM ARRAY
        $obRamal = $results->fetchAll();

        //CONTERTE PARA JSON
        $dados_json = json_encode($obRamal);
        
        //VIEW DE DEPOIMENTOS
        $content = View::render('pages/ramais', [
            'ramais' => $dados_json
        ]);
        
        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Ramal', $content);
    }

}
