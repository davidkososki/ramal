<?php

namespace Sed\Ramal\Http\Middleware;

use Sed\Ramal\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin {

    /*
     * Método responsável por executar o middlaware
     * @paraem Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next) {
        //VERIFICA SE O USUÁRIO NÃO ESTÁ LOGADO REDIRECIONA PARA LOGIN
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }
        
        //CONTINUA A EXECUÇÃO SE NÃO ESTIVER LOGADO
        return $next($request);
    }


}