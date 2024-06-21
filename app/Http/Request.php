<?php

/*
 * Classe de requisições
 */

namespace Sed\Ramal\Http;

class Request {
    /*
     * Instãncia do router
     * @var Router
     */
    private $router;

   /*
     * Método HTTP da requisição
     * @var string
     */
    private $httpMethod;

    /*
     * URI da página
     * @var string
     */
    private $uri;

    /*
     * parâmetros da URl ($_GET)
     * @var array
     */
    private $queryParams = [];

    /*
     * parâmetros da URl ($_POST)
     * @var array
     */
    private $postVars = [];

    /*
     * cabeçalho da requisição
     * @var array
     */
    private $headers = [];

    /*
     * construtor da classe
     */
    public function __construct($router) {
        $this->router = $router;
        $this->queryParams = $_GET ?? []; //fica vazio se não existir
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /*
     * Método responsável por definir a URI
     * @return string
     */
    public function setUri() {
        //URI COMPLETA COM GET
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        
        //REMOVE GET DA URI
        $xURI = explode('?', $this->uri);
        $this->uri = $xURI[0];
    }

    /*
     * Método responsável por retornar a instãncia de router
     * @return string
     */
    public function getRouter() {
        return $this->router;
    }

    /*
     * Método responsável por retornar o HTTP da requisição
     * @return string
     */
    public function getHttpMethod() {
        return $this->httpMethod;
    }

    /*
     * Método responsável por retornar a URI da requisição
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /*
     * Método responsável por retornar os headers da requisição
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /*
     * Método responsável por retornar os parâmetros GET da URL da requisição
     * @return array
     */
    public function getQueryParams() {
        return $this->queryParams;
    }

    /*
     * Método responsável por retornar as variáveis POST da requisição
     * @return array
     */
    public function getPostVars() {
        return $this->postVars;
    }

}
