<?php 

namespace App\Http;


use \Closure;
use \Exception;
use \ReflectionFunction;

class Router{
    
    /**
     * URL completa do projeto (raiz)
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instancia de Request
     *
     * @var Request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     *
     * @param string $url
     */
    public function __construct($url){
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();

    }

    /**
     * Método Responsável por devinir os prefixos das rotas
     *
     */
    public function setPrefix(){
        //Informações da url atual
        $parseUrl = parse_url($this->url);
        
        //Define prefixo
        $this->prefix = $parseUrl['path'] ?? '';
        
    }

    /**
     * Metodo Responsável por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $routes
     * @param array $params
     */
    public function addRouter($method,$routes,$params =[]){
        
        //Validação dos parametros
        foreach($params as $key=>$values){
            if ($values instanceof Closure) {
                $params['controller'] = $values;
                unset($params[$key]); 
                continue;
            }
        }

        //Variáveis da Rota
        $params['variables'] = [];

        //Padrão de Validação das Variaveis das Rotas
        $patternVariables = '/{(.*?)}/';
        if (preg_match_all($patternVariables, $routes ,$matches)) { 
            $routes = preg_replace($patternVariables, '(.*?)', $routes);
            $params['variables'] = $matches[1];
            
        }

        //Padrao de Validação da URL
        $patternRoute = '/^'.str_replace('/','\/', $routes). '$/';

        //Adiciona  a rota dentro da Classe
        $this->routes[$patternRoute][$method] = $params;
        
      
    }

    /**
     * Metodo responsavel por definir uma rota de GET
     *
     * @param string $route
     * @param array $params
     */
    public function get($route,$params = []){
        return $this->addRouter('GET',$route,$params);     
    }

    /**
     * Metodo responsavel por definir uma rota de POSTS
     *
     * @param string $route
     * @param array $params
     */
    public function post($route,$params = []){
        return $this->addRouter('POST',$route,$params);     
    }

    /**
     * Metodo responsavel por definir uma rota de PUT
     * @param string $route
     * @param array $params
        */

    public function put($route,$params = []){
        return $this->addRouter('PUT',$route,$params);     
    }

    /**
     * Metodo responsavel por definir uma rota de DELETE
     *
     * @param string $route
     * @param array $params
     */

    public function delete($route,$params = []){
        return $this->addRouter('DELETE',$route,$params);     
    }

    /**
     * Metodo Responsavel por retornar a URI desconsiderando o prefixo 
     *
     * @return string
     */ 
    public function getUri(){
        //URI do Request
        $uri=$this->request->getUri();

        //retorna a URI com o prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri): [$uri];

        //retorna a URI sem prefixo
        return end($xUri);
    }

    /**
     * Metodo responsavel por retornar o dados  da rota atual
     *
     * @return array
     */
    public function getRoute(){
        //URI
        $uri = $this->getUri();

        //METHOD
        $httpMethod = $this->request->getHttoMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $method) {
            //Verifica se a URI bate com o padrao
            if (preg_match($patternRoute, $uri, $matches)) {
                //Verifica o Metodo
                if (isset($method[$httpMethod])) {
                    //Remove a primeira posição
                    unset($matches[0]);

                    //Variaves Processadas
                    $keys = $method[$httpMethod]['variables'];
                    $method[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $method[$httpMethod]['variables']['request'] = $this->request;

                  

                
            
                    
                    //Retorno dos parametros da rota
                    return $method[$httpMethod];
                }

                throw new Exception("Método não permitido", 405);
            }
        }

        //URL não encontrada
        throw new Exception("URL não encontrada ", 404);
        
    }

    /**
     * Método responsável por executar a rota atual
     *
     * @return void
     */
    public function run(){
        try {
            
            $route = $this->getRoute();

            //Verifica o Controlador
            if (!isset($route['controller'])) {
                throw new Exception("A URL não pode  ser processada", 500);
            }

            //Argumentos  da Função
            $args = [];

            //Reflection
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';

                
                
            
            }

            //Retorna a execução da função
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new  Response ($e->getCode(), $e->getMessage());
        }
    }
}