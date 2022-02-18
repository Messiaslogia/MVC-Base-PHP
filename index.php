<?php

    require __DIR__.'/includes/app.php';

    use \App\Http\Router;   

    $obRouter = new Router(URL);

    //Inclui as Pages
     require __DIR__.'/routes/pages.php';
 
    //Inclui o response da rota 
    $obRouter->run()
            ->sendResponse();   

     
?>