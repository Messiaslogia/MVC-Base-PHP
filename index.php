<?php

    require __DIR__.'/vendor/autoload.php';

    use \App\Http\Router;
    use \App\Utils\View;

    define( 'URL', 'http://localhost/mvc');
    
    //Define o valor padrão das váriavies 
    View::init([
        'URL' => URL
    ]);


    

    $obRouter = new Router(URL);

    //Inclui as Pages
     require __DIR__.'/routes/pages.php';
 
    //Inclui o response da rota 
    $obRouter->run()
            ->sendResponse();   

    
?>