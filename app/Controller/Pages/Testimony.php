<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;
    use \App\Model\Entity\Testimony as EntityTestimony;
     

    class Testimony extends Page{

        private static function getTestimonyItems(){ 
            //Depoimentos
            $itens = '';

            //Resultados dá pagina 
            $results = EntityTestimony::getTestimonies(null, 'id DESC');

            //Renderiza Item
            while($objTestimony = $results->fetchObject(EntityTestimony::class)){
                $itens .= View::render('/pages/testimony/item',[
                    'nome' => $objTestimony->nome,
                    'mensagem' => $objTestimony->mensagem,
                    'data' => date('d/m/Y H:i:s', strtotime($objTestimony->data))
                    
                    ]);
            }

            //Retorna os depoimentos
            return $itens;
        }

        /**
         * Método Responsável por retornar o conteudo (view) de depoimentos
         * @return void
         */
        public static function getTestimonies(){
    
            //view da Depoimentos
            $content = View::render('\pages\testimonies',[
                'itens' => self::getTestimonyItems()
            ]);
            //Retorna a view da Page
            return parent::getPage('DEPOIMENTOS -> MESSIAS', $content);
        }

        /**
         * Método responsável por cadastrar um depoimento
         *
         * @param Request $request
         * @return string
         */
        public static function insertTestimony($request){

            //Dados do Post
            $postVars = $request->getPostVars();
           
            //Nova Instancia de Depoimentos
            $objTestimony = new EntityTestimony;
            $objTestimony->name = $postVars['nome'];
            $objTestimony->mensagem = $postVars['mensagem'];
            $objTestimony->cadastrar();
             //Novo Depoimento 
            return self::getTestimonies();

    
        }
    }