<?php

namespace Sed\Ramal\Http\Middleware;

class Queue {//Classe Fila
    
    /*
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

/*
     * Mapeamento de middlewares que serão carregados em todas as rotas
     * @var array
     */
    private static $default = [];


    /*
     * Fila de middlewares a seren executados
     * @var array
     */
    private $middlewares = [];
    
    /*
     * Função de execução do controlador
     * @var Closure
     */
    private $controller;
    
    /*
     * Argumentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];
            
    
    /*
     * Método responsável por construir a classe de fila de middlewares
     * @param array $middlewares
     * @param Closure $controllir
     * @param array $controllerArgs
     */
    function __construct($middlewares, $controller, $controllerArgs) {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }
    
    /*
     * Método responsável por definir o mapeamento de midllewares
     * @var array $map
     */
    public static function setMap($map) {
        self::$map = $map;
    }

/*
     * Método responsável por definir o mapeamento de midllewares padrões
     * @var array $default
     */
    public static function setDefault($default) {
        self::$default = $default;
    }


    /*
     * Método responsável por executr o proxim nível da fila de middlewares
     * @param Request $request
     * @return Response
     */
    public function next($request) {
        //VERIFICA SE A FILA ESTÁ VAZIA
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
        
        //MIDDLEWARE (intermediário)
        $middleware = array_shift($this->middlewares);// remove a primeira posição para ir para a próxima camada
        
        //VERIFICA O MAPEAMENTO, se não existir lança o erro
        if(!isset(self::$map[$middleware])){
            throw new \Exception("Problemas ao processar o middleware da requisição", 500);
        }
        
        //NEXT
        $queue = $this;// instancia da classe
        $next = function($request) use($queue) {
            return $queue->next($request);
        };
        
        //EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware])->handle($request, $next);
        
    }

}

