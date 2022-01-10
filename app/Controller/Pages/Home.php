<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;
    use \App\Model\Entity\Organization;

    class Home extends Page{

        public static function getHome(){
            //Organização
            $obOrganization = new  Organization;

            //view da Home
            $content = View::render('\pages\home',[
                'name' => $obOrganization->name,
                'description' => $obOrganization->descript,
                'site' => $obOrganization->site
            ]);
            
            //Retorna a view da Page
            return parent::getPage('MVC do Messias', $content);
        }
    }