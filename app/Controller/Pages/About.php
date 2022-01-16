<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;
    use \App\Model\Entity\Organization;

    class About extends Page{
        /**
         * Método Responsavel por retornar o conteúdo (view) da nossa Página Sobre
         *
         * @return void
         */
        public static function getAbout(){
            //Organização
            $obOrganization = new  Organization;

            //view da Home
            $content = View::render('\pages\about',[
                'name' => $obOrganization->name,
                'description' => $obOrganization->descript,
                'site' => $obOrganization->site
            ]);
            
            //Retorna a view da Page
            return parent::getPage('Sobre -> MVC do Messias', $content);
        }
    }