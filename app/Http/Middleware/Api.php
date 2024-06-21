<?php

namespace Sed\Ramal\Http\Middleware;

class Api{
    
    /*
     * Método responsável por executaar o middleware
     * @param $request
     * @param Closure next
     * @return Response
     */
    public function handle($request, $next) {
        //ALTERA O CONTENTTYPE PARA JSON
        $request->getRouter()->setContentType('application/json');
        
        //EXECUTA O PRÓXIMO NÍVEL DO MIDDLEWARE
        return $next($request);
    }
}

