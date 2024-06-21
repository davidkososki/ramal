<?php

namespace Sed\Ramal\Session\Admin;

class Login{
    
    /*
     * Método responsável por iniciar a sessão
     */
    private static function init(){
        //VERIFICA SE A SESSÃO NÃO ESTÁ ATIVA E INICIA A SESSÃO
        if(session_start() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }


    /*
     * Méodo responsável por criar o login do usuário
     * @param User $obUser
     * @return boolean
     */
    public static function login($obUser) {
        //INICIA A SESSÃO
        self::init();
        
        //DEFINE A SESSÃO DO USUÁRIO
        $_SESSION['admin']['usuario'] = [
            'id' => $obUser->id_usuario,
            'nome' => $obUser->nome_usuario,
            'email' => $obUser->nome_usuario
        ];
                
        return true;
                    
    }
    
    public static function isLogged() {
        //INICIA A SESSÃO
        self::init();
        
        //RETORNA A VERIFICAÇÃO
        return isset($_SESSION['admin']['usuario']['id']);
    }
    
    
    public static function logout() {
        //INICIA A SESSÃO
        self::init();
        
        //DESLOGA O USUÁRIO
        unset($_SESSION['admin']['usuario']);
        
        return true;
    }
    
}

