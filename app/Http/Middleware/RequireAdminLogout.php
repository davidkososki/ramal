<?php

namespace Sed\Ramal\Http\Middleware;

use Sed\Ramal\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout {

    /*
     * Método responsável por executar o middlaware
     * @paraem Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next) {
        //VERIFICA SE O USUÁRIO ESTÁ LOGADO E REDIRECIONA PARA ADMIN
        if (SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }
        
        //CONTINUA A EXECUÇÃO SE NÃO ESTIVER LOGADO
        return $next($request);
    }
    
    

}