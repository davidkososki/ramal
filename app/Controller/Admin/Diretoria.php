<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\DiretoriaModel;
use WilliamCosta\DatabaseManager\Pagination;


class Diretoria extends Page{
        
    /**
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */
    public static function getDiretoriaItens($request, &$obPagination){
        //DEPOIMENTOS
        $itens = '';
        
        //QUANTIDADE TOAL DE REGISTROS
        $quantidadetotal = DiretoriaModel::getDiretoria(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
        
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);
        
        //RESULTADOS DA PÁGINA
        $results = DiretoriaModel::getDiretoria(null, 'id_diretoria DESC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obDiretoria = $results->fetchObject(DiretoriaModel::class)){
            $itens.= View::render('admin/modules/diretoria/item', [
                'id' => $obDiretoria->id_diretoria,
                'nome' => $obDiretoria->nome_diretoria,
                'sigla' => $obDiretoria->sigla_diretoria
            ]);
        }

        return $itens;
    }
    
    /*
     * Método responsável por renderizar a view de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getDiretoria($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/diretoria/index', [
            'itens' => self::getDiretoriaItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Diretorias > Ramal', $content, 'diretoria');
    }
    
    /*
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewDiretoria($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/diretoria/form', [
            'title' => 'Cadastrar Diretoria',
            'nome' => '',
            'sigla' => '',
            'status' => ''
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Cadastrar Diretoria > Ramal', $content, 'diretoria');
    }
    
    /*
     * Método responsável por cadastrar um novo depoimento no banco
     * @param Request $request
     * @return string
     */
    public static function setNewDiretoria($request) {
        //POST VARS
        $postVars = $request->getPostVars();
        
        //NOVA INSTÂNCIA DE DEPOIMENTOS
        $obDiretoria = new DiretoriaModel();
        $obDiretoria->nome_diretoria = $postVars['nome'];
        $obDiretoria->sigla_diretoria = $postVars['sigla'];
        $obDiretoria->cadastrar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/diretoria/'.$obDiretoria->id.'/edit?status=created');
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
                return Alert::getSuccess('Diretoria criada com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Diretoria atualizada com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Diretoria excluida com sucesso!');
                break;
            
        }
    }

    /*
     * Método responsável por retornar o formulário de edição de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditDiretoria($request,$id) {

        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obDiretoria = DiretoriaModel::getDiretoriaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obDiretoria instanceof DiretoriaModel){
            $request->getRouter()->redirect('/admin/diretoria');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/diretoria/form', [
            'title' => 'Editar Diretoria',
            'id' => $obDiretoria->id_diretoria,
            'nome' => $obDiretoria->nome_diretoria,
            'sigla' => $obDiretoria->sigla_diretoria,
            'status' => self::getStatus($request)
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Diretoria > Ramal', $content, 'diretoria');
    }
     
    /*
     * Método responsável por gravar a atualização de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditDiretoria($request,$id) {
        
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obDiretoria = DiretoriaModel::getDiretoriaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obDiretoria instanceof DiretoriaModel){
            $request->getRouter()->redirect('/admin/diretoria');
        }
        
        //POST VARS
         $postVars = $request->getPostVars();

         //ATUALIZA A INSTÃNCIA
         $obDiretoria->nome_diretoria = $postVars['nome'] ?? $obDiretoria->nome_diretoria;
         $obDiretoria->sigla_diretoria = $postVars['email'] ?? $obDiretoria->sigla_diretoria;
         $obDiretoria->atualizar();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/diretoria/'.$obDiretoria->id_diretoria.'/edit?status=updated');
        
    }

     /*
     * Método responsável por retornar o formulário de exclusão de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteDiretoria($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obDiretoria = DiretoriaModel::getDiretoriaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obDiretoria instanceof DiretoriaModel){
            $request->getRouter()->redirect('/admin/diretoria');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/diretoria/delete', [
            'nome' => $obDiretoria->nome_diretoria,
            'sigla' => $obDiretoria->sigla_diretoria
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Diretoria > Ramal', $content, 'diretoria');
    }
    
    /*
     * Método responsável por excluir um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteDiretoria($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obDiretoria = DiretoriaModel::getDiretoriaById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obDiretoria instanceof DiretoriaModel){
            $request->getRouter()->redirect('/admin/diretoria');
        }

        //EXCLUIR O DEPOIMENTO
         $obDiretoria->excluir();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/diretoria?status=deleted');
        
    }
    
}

