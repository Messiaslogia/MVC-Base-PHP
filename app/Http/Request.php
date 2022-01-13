<?php

namespace App\Http;

class Request{
    /** 
     * Método Http  da requisição 
     * @var string
     */
    private $httpMethod;

    /** 
     * URI da página 
     * @var string
     */
    private $uri;

    /** 
     * Parametros da URL ($_GET)
     * @var array
     */
    private $queryParams = [];

    /** 
     * Variaveis recebidas no POST da página ($_POST)
     * @var array
     */
    private $postVars = [];

    /** 
     * cabeçalho da requisição
     * @var array
     */
    private $header = [];

    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->header = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'];

    }

    /**
     * Metodo responsavel por retornar o método HTTP da requisição
     *
     * @return string
     */
    public function getHttoMethod(){
        return $this->httpMethod;
    }

    /**
     * Metodo responsavel por retornar a URI da requisição
     *
     * @return string
     */
    public function getUri(){
        return $this->uri;
    }
    
    /**
     * Metodo responsavel por retornar os Headers da requisição
     *
     * @return array
     */
    public function getHeader(){
        return $this->header;
    }

    /**
     * Metodo responsavel por retornar os parametros da requisição
     *
     * @return array
     */
    public function getQueryParms(){
        return $this->queryParams;
    }

    /**
     * Metodo responsavel por retornar as váriaveis POST da requisição
     *
     * @return array
     */
    public function getPostVars(){
        return $this->postVars;
    }






}