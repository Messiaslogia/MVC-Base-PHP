<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;

    class Page{
        
        /**
         * Método responsável  por rederizar o header da página 
         * @return string
         */
        private static function getHeader(){
            return View::render('pages/header');
        }

        /**
         * Método responsável  por rederizar o footer da página 
         * @return string
         */
        private static function getFooter(){
            return View::render('pages/footer', [
                'teste'=> 'Teste de Footer'
            ]);
        }

        /**
         * Método responsável  por retornar o conteúdo (view) da página
         * @param string $title
         * @param string $content
         * @return string
         */
        
        public static function getPage($title, $content){

            return View::render('\pages\page',[
                'title' => $title,
                'header' => self::getHeader(),
                'content' => $content,
                'footer' => self::getFooter()
            ]);
        }
    }