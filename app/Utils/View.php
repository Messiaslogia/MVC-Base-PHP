<?php

namespace App\Utils;

class View{

    /**
     * Variaveis padroes da View
     *
     * @var array
     */
    private static $vars = [];


    /**
     * Método responsável por definir os dados iniciais da classe 
     *
     * @param array $vars
     */
    public static function init($vars=[])
    {   
        self::$vars = $vars;
        
    }
    /**
     * Metodo responsável por retornar o conteudo de uma view
     * @param string $view
     * @return string
     */

    private static function getContentView($view){

        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Metodo responsável por retornar o conteudo renderizado de uma view
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */

    public  static function render($view, $vars = []){
        //Conteudo da View
        $contentView = self::getContentView($view); 

        $vars = array_merge(self::$vars, $vars);

        //Chaves do Array de Variaveis
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);


        //Retorna o conteudo renderizado 
        return str_replace($keys, array_values($vars), $contentView);

    }
}