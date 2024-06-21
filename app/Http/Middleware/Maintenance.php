<?php

namespace Sed\Ramal\Http\Middleware;

class Maintenance{
    
    /*
     * Método responsável por executaar o middleware
     * @param $request
     * @param Closure next
     * @return Response
     */
    public function handle($request, $next) {
        //VERIFICA O ESTADO DE MANUTENÇÃO DA PÁGINA
        if(getenv('MAINTENANCE')=='true'){
            throw new \Exception("Página em Manutenção! Tente novamente mais tarde.", 200);
        }
        
        //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }
}

