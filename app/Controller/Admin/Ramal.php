<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\RamalModel;
use Sed\Ramal\Model\GerenciaModel;
use WilliamCosta\DatabaseManager\Pagination;


class Ramal extends Page{
        
    /**
     * Método responsável por obter a renderização dos itens de ramais
     *  para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */
    public static function getRamalItens($request, &$obPagination){
        //ramais

        $itens = '';
        
        //QUANTIDADE TOAL DE REGISTROS
        $quantidadetotal = RamalModel::getRamal(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
        
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);
        
        //RESULTADOS DA PÁGINA
        $results = RamalModel::getRamal(null, 'id_pessoa DESC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obRamal = $results->fetchObject(RamalModel::class)){
            $itens.= View::render('admin/modules/ramal/item', [
                'id' => $obRamal->id_pessoa,
                'nome' => $obRamal->nome_pessoa,
                'email' => $obRamal->email_pessoa,
                'telefone' => $obRamal->telefone_pessoa,
                'celular' => $obRamal->celular_pessoa,
                'andar' => $obRamal->andar_pessoa,
                'id_gerencia' => $obRamal->id_gerencia_pessoa
            ]);
        }

        return $itens;
    }
    
    /**
     * Método responsável por obter a renderização dos itens de gerência para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */

     public static function getRamalGerenciaItens($id){
        //ramais

        $options = '';
        
        //RESULTADOS DA OPTIONS
        $results = GerenciaModel::getAllGerencia();
        
        //RENDERIZA O ITEM
        while($obRamal = $results->fetchObject(GerenciaModel::class)){
            $selected = $id == $obRamal->id_gerencia ? "selected" : "";
            $options.= View::render('admin/modules/ramal/option', [
                'id' => 'value="'.$obRamal->id_gerencia.'" '.$selected,
                'nome' => $obRamal->nome_gerencia,
                'sigla' => $obRamal->sigla_gerencia
            ]);
        }


        return $options;
    }

    /*
     * Método responsável por renderizar a view de ramais
     * 
     * @param Request $request
     * @return string
     */
    public static function getRamal($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/ramal/index', [
            'itens' => self::getRamalItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Ramals >Ramal', $content, 'ramal');
    }
    
    /*
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewRamal($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/ramal/form', [
            'title' => 'Cadastrar Ramal',
            'nome' => '',
            'email' => '',
            'telefone' => '',
            'celular' => '',
            'andar' => '',
            'id_gerencia' => '',
            'status' => ''
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Cadastrar Ramal >Ramal', $content, 'ramal');
    }
    
    /*
     * Método responsável por cadastrar um novo depoimento no banco
     * @param Request $request
     * @return string
     */
    public static function setNewRamal($request) {
        //POST VARS
        $postVars = $request->getPostVars();

                   echo '<pre>';
                   print_r($postVars);
                   echo '</pre>';
                   exit();
        
        //NOVA INSTÂNCIA DE ramais

        $obRamal = new RamalModel();
        $obRamal->nome_pessoa = $postVars['nome'];
        $obRamal->email_pessoa = $postVars['email'];
        $obRamal->telefone_pessoa = $postVars['telefone'];
        $obRamal->celular_pessoa = $postVars['celular'];
        $obRamal->andar_pessoa = $postVars['andar'];
        $obRamal->id_gerencia_pessoa = $postVars['id_gerencia'];
        $obRamal->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/ramais/'.$obRamal->id.'/edit?status=created');
    }
    
    /*
     * Método responsável por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    public static function getStatus($request) {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();
        
        //STATUS
        if(!isset($queryParams['status'])) return '';
        
        //MENSAGENS DE STATUS
        switch ($queryParams['status']){
            case 'created':
                return Alert::getSuccess('Ramal criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Ramal atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Ramal excluido com sucesso!');
                break;
            
        }
    }

    /*
     * Método responsável por retornar o formulário de edição de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditRamal($request,$id) {

        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obRamal = RamalModel::getRamalById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obRamal instanceof RamalModel){
            $request->getRouter()->redirect('/admin/ramais');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/ramal/form', [
            'title' => 'Editar Ramal',
            'id' => $obRamal->id_pessoa,
            'nome' => $obRamal->nome_pessoa,
            'email' => $obRamal->email_pessoa,
            'telefone' => $obRamal->telefone_pessoa,
            'celular' => $obRamal->celular_pessoa,
            'andar' => $obRamal->andar_pessoa,
            'id_gerencia' => $obRamal->id_gerencia_pessoa,
            'status' => self::getStatus($request)
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Ramal >Ramal', $content, 'ramal');
    }
     
    /*
     * Método responsável por gravar a atualização de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditRamal($request,$id) {
        
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obRamal = RamalModel::getRamalById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obRamal instanceof RamalModel){
            $request->getRouter()->redirect('/admin/ramais');
        }
        
        //POST VARS
         $postVars = $request->getPostVars();

         //ATUALIZA A INSTÃNCIA
         $obRamal->nome_pessoa = $postVars['nome'] ?? $obRamal->nome_pessoa;
         $obRamal->email_pessoa = $postVars['email'] ?? $obRamal->email_pessoa;
         $obRamal->telefone_pessoa = $postVars['telefone'] ?? $obRamal->telefone_pessoa;
         $obRamal->celular_pessoa = $postVars['celular'] ?? $obRamal->celular_pessoa;
         $obRamal->andar_pessoa = $postVars['andar'] ?? $obRamal->andar_pessoa;
         $obRamal->id_gerencia_pessoa = $postVars['id_gerencia'] ?? $obRamal->id_gerencia_pessoa;
         $obRamal->atualizar();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/ramais/'.$obRamal->id_pessoa.'/edit?status=updated');
        
    }

     /*
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteRamal($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obRamal = RamalModel::getRamalById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obRamal instanceof RamalModel){
            $request->getRouter()->redirect('/admin/ramais');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/ramal/delete', [
            'nome' => $obRamal->nome_pessoa,
            'email' => $obRamal->email_pessoa,
            'telefone' => $obRamal->telefone_pessoa,
            'celular' => $obRamal->celular_pessoa,
            'andar' => $obRamal->andar_pessoa
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Ramal >Ramal', $content, 'ramal');
    }
    
    /*
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteRamal($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obRamal = RamalModel::getRamalById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obRamal instanceof RamalModel){
            $request->getRouter()->redirect('/admin/ramais');
        }

        //EXCLUIR O DEPOIMENTO
         $obRamal->excluir();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/ramais?status=deleted');
        
    }
    
}

