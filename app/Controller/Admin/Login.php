<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\UserModel;
use Sed\Ramal\Session\Admin\Login as SessionAdminLogin;


class Login extends Page{
    /*
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null) {
        //RETORNA O CONTEUDO DE STATUS
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage): '';
                
        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/login',[
            'status' => $status
        ]);
        
        //RETORNA A PÁGINA COMPLETA
        return parent::getPage('Login > RAMAL', $content); //title, content
    }
    
    /*
     * Método responsável por definir o login do usuário
     * @param Request $request
     * @return string
     */
    public static function setLogin($request) {
        //POST VARS
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
      
        //VERIFICA A SENHA DO USUÁRIO e USUÁRIO POR EMAIL
        $obUser = UserModel::getUserByEmail($email);
        if(!$obUser instanceof UserModel or !password_verify($senha, $obUser->senha_usuario)){
            return self::getLogin($request, 'E-mail ou senha inválidos.');
        }
                
        
        //CRIA A SESSÃO DE USUÁRIO
        SessionAdminLogin::login($obUser);
        
        //REDIRECIONA USUÁRIO PARA HOME DO ADMIN
        $request->getRouter()->redirect('/admin');

    }
    
    /*
     * Método responsável por deslogar o usuário
     * @param Request $request
     */
    public static function setLogout($request) {
        //DESTRÓI A SESSÃO DE LOGIN
        SessionAdminLogin::logout();
        
        //REDIRECIONA O USUÁRIO PARA A TELA DE LOGIN
        $request->getRouter()->redirect('/admin/login');
    }
    
}

