<?php

namespace App\Http;

class Response{

    /**
     * Código do Status HTTP
     * @var interger
     */
    public $httpCode = 200;

     /**
     * Cabeçalho do Response
     * @var array
     */
    private $headers = [];

    /**
     * Cabeçalho do Response
     * @var interger
     */
    private $contentType = 'text/html';

    /**
     * Conteudo da response
     * @var array
     */
    private $content = [];
            
     /**
     * Método responsável por iniciar a classe e definir valores 
     * @param interger $httpCode
     * @param mixed $content
     * @param string $contentType
     */

    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por alterar o content type de response
     * @param string $contentType
     */

    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsável Adicionar  um registro de cabeçalho no response   
     * @param string $key
     * @param string $contentType
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar os Headers para o navegador 
     * @param string $key
     * @param string $contentType
     */

    private function sendHeaders($httpCode){
        http_response_code($httpCode);

        foreach($this->headers as $key=>$values);
            header($key.':'.$values);
    }

    /**
     * Método responsável Adicionar  um registro de cabeçalho no response   
     * @param string $key
     * @param string $contentType
     */
    public function sendResponse(){
        //Envia os Headers
        $httpCode = $this->httpCode;
        $this->sendHeaders($httpCode);

        //Imprime o Conteudo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}