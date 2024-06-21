<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\UserModel;
use WilliamCosta\DatabaseManager\Pagination;


class Users extends Page{
        
    /**
     * Método responsável por obter a renderização dos itens de usuários para a página
     * @param Request $request
     * @param Pagination $obPagination é uma referência de memoria
     * @return string
     */
    public static function getUsersItens($request, &$obPagination){
        //USUÁRIOS
        $itens = '';
        
        //QUANTIDADE TOAL DE REGISTROS
        $quantidadetotal = UserModel::getUser(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
        
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTÂNCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);
        
        //RESULTADOS DA PÁGINA
        $results = UserModel::getUser(null, 'id_usuario DESC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obUser = $results->fetchObject(UserModel::class)){
            $itens.= View::render('admin/modules/users/item', [
                'id' => $obUser->id_usuario,
                'nome' => $obUser->nome_usuario,
                'email' => $obUser->email_usuario
            ]);
        }
        
        return $itens;
    }
    
    /*
     * Método responsável por renderizar a view de usuários
     * @param Request $request
     * @return string
     */
    public static function getUsers($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/users/index', [
            'itens' => self::getUsersItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Usuários > RAMAL', $content, 'users');
    }
    
    /*
     * Método responsável por retornar o formulário de cadastro de um novo usuário
     * @param Request $request
     * @return string
     */
    public static function getNewUsers($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/users/form', [
            'title' => 'Cadastrar Usuário',
            'nome' => '',
            'email' => '',
            'status' => self::getStatus($request)
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Cadastrar Usuário > RAMAL', $content, 'users');
    }
    
    /*
     * Método responsável por cadastrar um novo usuário no banco
     * @param Request $request
     * @return string
     */
    public static function setNewUsers($request) {
        //POST VARS
        $postVars = $request->getPostVars();
        
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
        
        //VALIDA USUÁRIO POR EMAIL
        $obUser = UserModel::getUserByEmail($email);
        if($obUser instanceof UserModel){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }
                            
        //NOVA INSTÂNCIA DE USUÁRIO
        $obUserIn = new UserModel();
        $obUserIn->nome_usuario = $nome;
        $obUserIn->email_usuario = $email;
        $obUserIn->senha_usuario = password_hash($senha,PASSWORD_DEFAULT);
//        echo '<pre>';
//        print_r($obUserIn);
//        echo '</pre>';
//        exit();
        $obUserIn->cadastrar();
        
        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$obUserIn->id_usuario.'/edit?status=created');
    }
    
    /*
     * Método responsável por retornar a email de status
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
                return Alert::getSuccess('Usuário criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluido com sucesso!');
                break;
            case 'duplicated':
                return Alert::getError('Email já cadastrado!');
                break;
            
        }
    }

    /*
     * Método responsável por retornar o formulário de edição de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUsers($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = UserModel::getUserById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obUser instanceof UserModel){
            $request->getRouter()->redirect('/admin/users');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/users/form', [
            'title' => 'Editar Usuário',
            'nome' => $obUser->nome_usuario,
            'email' => $obUser->email_usuario,
            'status' => self::getStatus($request)
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Usuário > RAMAL', $content, 'users');
    }
     
    /*
     * Método responsável por gravar a atualização de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditUsers($request,$id) {
        //OBTÉM O USUÁRIO DO BANCO DE DADOS
        $obUserIn = UserModel::getUserById($id);
               

        //VALIDA A INSTÂNCIA
        if(!$obUserIn instanceof UserModel){
            $request->getRouter()->redirect('/admin/users');
        }

        //POST VARS
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
         
        //VALIDA USUÁRIO POR EMAIL
        $obUserEmail = UserModel::getUserByEmail($email);

        if($obUserEmail instanceof UserModel && $obUserEmail->id_usuario != $id){
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
        }
                            
        //NOVA INSTÂNCIA DE USUÁRIO
        $obUserIn->nome_usuario = $nome;
        $obUserIn->email_usuario = $email;
        $obUserIn->senha_usuario = password_hash($senha,PASSWORD_DEFAULT);
//        echo '<pre>';
//        print_r($obUserIn);
//        print_r($postVars);
//        print_r($obUserEmail);
//        echo '</pre>';
//        exit();

        $obUserIn->atualizar();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/'.$obUserIn->id_usuario.'/edit?status=updated');
        
    }

     /*
     * Método responsável por retornar o formulário de exclusão de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUsers($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = UserModel::getUserById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obUser instanceof UserModel){
            $request->getRouter()->redirect('/admin/users');
        }
        
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/users/delete', [
            'nome' => $obUser->nome_usuario,
            'email' => $obUser->email_usuario
            
        ]);
                
        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Usuário > RAMAL', $content, 'users');
    }
    
    /*
     * Método responsável por excluir um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUsers($request,$id) {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = UserModel::getUserById($id);
        
        //VALIDA A INSTÂNCIA
        if(!$obUser instanceof UserModel){
            $request->getRouter()->redirect('/admin/users');
        }

        //EXCLUIR O DEPOIMENTO
         $obUser->excluir();
         
         //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users?status=deleted');
        
    }
    
}

