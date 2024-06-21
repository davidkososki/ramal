<?php

namespace Sed\Ramal\Http;

class Response {
    /*
     * Propriedade do código de status HTTP
     * @var integer
     */

    private $httpCode = 200;

    /*
     * Propriedade do cabeçalho de Response
     * @var array
     */
    private $headers = [];

    /*
     * Propriedade do tipo de conteúdo que está sendo retornado
     * @var string
     */
    private $contentType = 'text/html';

    /*
     * Propriedade do conteúdo de Response
     * @var mixed
     */
    private $content;

    /*
     * Método responsável por iniciar a classe e definir os valores
     */

    public function __construct($httpCode, $content, $contentType = 'text/html') {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /*
     * Método responsável por alterar o content type do response
     * @param string $contentType
     */

    public function setContentType($contentType) {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /*
     * Método responsável por adicionar um registro no cabeçalho de response
     * @param string $key (chave)
     * @param string $value (valor)
     */

    public function addHeader($key, $value) {
        $this->headers[$key] = $value;
    }

    /*
     * Método responsável por enviar os headers para o navegados
     */

    private function sendHeaders() {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /*
     * Método responsável por enviar a resposta para o usuário
     */

    public function sendResponse() {
        //ENVIA OS HEADERS
        $this->sendHeaders();

        //IMPRIME O CONTEÚDO
        switch ($this->contentType) {
            case 'text/html';
                echo $this->content;
                exit;
        case 'application/json';
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
        }
    }

}
