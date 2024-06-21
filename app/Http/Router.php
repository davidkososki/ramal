<?php
namespace Sed\Ramal\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use Sed\Ramal\Http\Middleware\Queue as MiddlewareQueue;


class Router {
    /*
     * URL completa da requisição (raiz)
     * @var string
     */

    private $url = '';

    /*
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /*
     * índece das rotas
     * @var array
     */
    private $routes = [];

    /*
     * instância de request
     * @var Request
     */
    private $request;
    
    /**
     * Content type padrão
     * @var string
     */
    private $contentType = 'text/html';

    public function __construct($url) {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }
    
    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }
    
    

    /*
     * Método responsável por definir o prefixo das rotas
     */
    private function setPrefix() {
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url); //função do PHP que pega os dados da URL
        
        
        //DEFINE PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /*
     * Método responsável por adicionar uma rota na classe
     * @var string $method
     * @var string $route
     * @var array $params
     */
    public function addRoute($method, $route, $params = []) {
        //VALIDAÇÃO DOS PARÂMETROS
        foreach ($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller']=$value;
                unset($params[$key]);
                continue;
            }
        }
        
        //MIDDLEWARES DA ROTA
        $params['middlewares'] = $params['middlewares'] ?? [];
        
        //VARIÁVEIS DA ROTA
        $params['variables'] = [];
        
        //PADRÃO DE VALIDAÇÃO DAS VARIÁVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/';
        $matches = '';
        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }
        
        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
        
        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }

    /*
     * Método responsável por definir uma rota de GET
     * @var string $route
     * @var array $params
     */
    public function get($route, $params = []) {
        return $this->addRoute('GET', $route, $params);
    }
    /*
     * Método responsável por definir uma rota de POST
     * @var string $route
     * @var array $params
     */
    public function post($route, $params = []) {
        return $this->addRoute('POST', $route, $params);
    }
    /*
     * Método responsável por definir uma rota de PUT
     * @var string $route
     * @var array $params
     */
    public function put($route, $params = []) {
        return $this->addRoute('PUT', $route, $params);
    }
    /*
     * Método responsável por definir uma rota de DELETE
     * @var string $route
     * @var array $params
     */
    public function delete($route, $params = []) {
        return $this->addRoute('DELETE', $route, $params);
    }
    
     /*
     * Método responsável por retornar a URI desconsiderando o prefixo
     * @return string
     */
    public function getUri() {
        //URI DA REQUEST
        $uri = $this->request->getUri();
        
        //FATIA A URI COM O PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        
        //RETORNA A URI SEM PREFIXO
        return rtrim(end($xUri),'/');
    }
    
    /*
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    public function getRoute() {
        //URI
        $uri = $this->getUri();
        
        //METHOD
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            
            //echo print_r($patternRoute).'</br>';
            //echo print_r($methods).'</br>';

            //VERIFICA SE A ROTA BATE COM O PADRÃO
            if(preg_match($patternRoute, $uri, $matches)){
                        
                //VERIFICAR O MÉTODO
                if(isset($methods[$httpMethod])){
                    //REMOVE A PRIMEIRA POSIÇÃO
                    unset($matches[0]);
                    
                    //VARIÁVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    
                    //RETORNO DOS PARÂMETROS DA ROTA
                    return $methods[$httpMethod];
                }
                throw new Exception("Método não permitido", 405);
            }
        }
            echo '<pre>';
//        print_r($uri);
//        //print_r($httpMethod);
//        print_r($this->routes);
//        echo '</pre>';
//        exit();    
        throw new Exception("URL não encontrada", 404);
    }
    
    /*
     * Método responsável por executar a rota atual
     * @return Response
     */
   public function run(){
        try {
            //OBTÉM A ROTA ATUAL
            $route = $this->getRoute();

            
            //VERIFICA O CONTROLADOR
            if (!isset($route['controller'])){
                throw new Exception("A URL não pode ser processada", 500);
            }
            
            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            
            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? ''; 
            }
            
            //RETORNA A EXECUÇÃO DA FILA DE MIDDLEWARES
            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);            
        } catch (Exception $exc) {
            return new Response($exc->getCode(), $this->getErrorMessage($exc->getMessage()), $this->contentType);
        }
    }
    
    /**
     * Método responsável por retornar a mensagem de erro de acordo com o content type
     * @param string $message
     * @return mixed
     */
    private function getErrorMessage($message) {
        switch ($this->contentType) {
            case 'application/json':
                return [
                    'error' => $message
                ];

            default:
                return $message;

        }
    }
    
    /*
     * Método responsável por retornar a URL atual
     * @return string
     */
    public function getCurentUrl() {
        return $this->url.$this->getUri();
    }
    
    /*
     * Método responsável por redirecionar a URL
     * @param string $route
     */
    public function redirect($route) {
        //URL
        $url = $this->url.$route;
        header('location: '.$url);
        exit;
        
    }
    

    
}
