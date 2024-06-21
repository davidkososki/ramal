<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\GerenciaModel;
use Sed\Ramal\Model\DiretoriaModel;
use WilliamCosta\DatabaseManager\Pagination;


class Gerencia extends Page{
        
    /**
     * Método responsável por obter a renderização dos itens de gerência para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */
    public static function getGerenciaItens($request, &$obPagination){
        //DEPOIMENTOS
        $itens = '';
        
        //QUANTIDADE TOAL DE REGISTROS
        $quantidadetotal = GerenciaModel::getGerencia(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
        
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);
        
        //RESULTADOS DA PÁGINA
        $results = GerenciaModel::getGerencia(null, 'id_gerencia DESC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obGerencia = $results->fetchObject(GerenciaModel::class)){
            $itens.= View::render('admin/modules/gerencia/item', [
                'id' => $obGerencia->id_gerencia,
                'nome' => $obGerencia->nome_gerencia,
                'sigla' => $obGerencia->sigla_gerencia,
                'telefone' => $obGerencia->sigla_gerencia,
                'id_diretoria_gerencia' => self::getGerenciaDiretoriaItens($obGerencia->id_diretoria_gerencia)
            ]);
        }

        return $itens;
    }
    
    /**
     * Método responsável por obter a renderização dos itens de diretoria para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */

    public static function getGerenciaDiretoriaItens($id){
        //DEPOIMENTOS
        $options = '';
        
        //RESULTADOS DA OPTIONS
        $results = DiretoriaModel::getAllDiretoria();
        
        //RENDERIZA O ITEM
        while($obGerencia = $results->fetchObject(DiretoriaModel::class)){
            $selected = $id == $obGerencia->id_diretoria ? "selected" : "";
            $options.= View::render('admin/modules/gerencia/option', [
                'id' => 'value="'.$obGerencia->id_diretoria.'" '.$selected,
                'nome' => $obGerencia->nome_diretoria,
                'sigla' => $obGerencia->sigla_diretoria
            ]);
        }


        return $options;
    }
    
    
    /*
     * Método responsável por renderizar a view de gerência
     * @param Request $request
     * @return string
     */
    public static function getGerencia($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/gerencia/index', [
            'itens' => self::getGerenciaItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Gerencia >Ramal', $content, 'gerencia');
    }
    
    /*
     * Método responsável por retornar o formulário de cadastro de uma nova gerência
     * @param Request $request
     * @return string
     */
    public static function getNewGerencia($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/gerencia/form', [
            'title' => 'Cadastrar Gerencia',
            'nome' => '',
            'sigla' => '',
            'id_diretoria_gerencia' => self::getGerenciaDiretoriaItens(""),
            'status' => ''
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Cadastrar Gerencia > Ramal', $content, 'gerencia');
    }
    
    /*
     * Método responsável por cadastrar uma nova gerência no banco
     * @param Request $request
     * @return string
     */
    public static function setNewGerencia($request) {
        //POST VARS
        $postVars = $request->getPostVars();
//                echo '<pre>';
//        print_r($postVars);
//        echo '</pre>';
//        exit();
        //NOVA INSTÂNCIA DA GERÊNCIA
        $obGerencia = new GerenciaModel();
        $obGerencia->nome_gerencia = $postVars['nome'];
        $obGerencia->sigla_gerencia = $postVars['sigla'];
        $obGerencia->id_diretoria_gerencia = $postVars['diretoria'];
        $obGerencia->cadastrar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/gerencia/'.$obGerencia->id_gerencia.'/edit?status=created');
    }
    
    /*
     * Método responsável por retornar a sigla de status
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
                return Alert::getSuccess('Gerencia criada com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Gerencia atualizada com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Gerencia excluida com sucesso!');
                break;
            
        }
    }

    /*
     * Método responsável por retornar o formulário de edição de um gerência
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditGerencia($request,$id) {

        //OBTÉM A GERÊNCIA DO BANCO DE DADOS
        $obGerencia = GerenciaModel::getGerenciaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obGerencia instanceof GerenciaModel){
            $request->getRouter()->redirect('/admin/gerencia');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/gerencia/form', [
            'title' => 'Editar Gerência',
            'id' => $obGerencia->id_gerencia,
            'nome' => $obGerencia->nome_gerencia,
            'sigla' => $obGerencia->sigla_gerencia,
            'id_diretoria_gerencia' => self::getGerenciaDiretoriaItens($obGerencia->id_diretoria_gerencia),
            'status' => self::getStatus($request)
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Gerencia >Ramal', $content, 'gerencia');
    }
     
    /*
     * Método responsável por gravar a atualização de um gerência
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditGerencia($request,$id) {
        
        //OBTÉM A GERÊNCIA DO BANCO DE DADOS
        $obGerencia = GerenciaModel::getGerenciaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obGerencia instanceof GerenciaModel){
            $request->getRouter()->redirect('/admin/gerencia');
        }
        
        //POST VARS
         $postVars = $request->getPostVars();

         //ATUALIZA A INSTÃNCIA
         $obGerencia->nome_gerencia = $postVars['nome'] ?? $obGerencia->nome_gerencia;
         $obGerencia->sigla_gerencia = $postVars['sigla'] ?? $obGerencia->sigla_gerencia;
         $obGerencia->id_diretoria_gerencia = $postVars['diretoria'] ?? $obGerencia->id_diretoria_gerencia;
         $obGerencia->atualizar();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/gerencia/'.$obGerencia->id_gerencia.'/edit?status=updated');
        
    }

     /*
     * Método responsável por retornar o formulário de exclusão de um gerência
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteGerencia($request,$id) {
        //OBTÉM A GERÊNCIA DO BANCO DE DADOS
        $obGerencia = GerenciaModel::getGerenciaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obGerencia instanceof GerenciaModel){
            $request->getRouter()->redirect('/admin/gerencia');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/gerencia/delete', [
            'nome' => $obGerencia->nome_gerencia,
            'sigla' => $obGerencia->sigla_gerencia
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Gerencia > Ramal', $content, 'gerencia');
    }
    
    /*
     * Método responsável por excluir um gerência
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteGerencia($request,$id) {
        //OBTÉM A GERÊNCIA DO BANCO DE DADOS
        $obGerencia = GerenciaModel::getGerenciaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obGerencia instanceof GerenciaModel){
            $request->getRouter()->redirect('/admin/gerencia');
        }

        //EXCLUIR A GERÊNCIA
         $obGerencia->excluir();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/gerencia?status=deleted');
        
    }
    
}

