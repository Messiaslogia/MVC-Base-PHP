<?php

use \App\Http\Response;
use \App\Controller\Pages;


//Rota Home
$obRouter->get('/',[
    function(){
        return new Response(200, Pages\Home::getHome());
    } 
]);

//Rota Sobre
$obRouter->get('/sobre',[
function(){
    return new Response(200, Pages\About::getAbout());
} 
]);

//Rota Depoimentos
$obRouter->get('/depoimentos',[
    function(){
        return new Response(200, Pages\Testimony::getTestimonies());
    } 
    ]);

    //Rota Depoimentos (insert)
$obRouter->post('/depoimentos',[
    function($request){
        //Dados do Post
        $postVars =  $request->getPostVars();
        return new Response(200, Pages\Testimony::insertTestimony($request));
    } 
    ]);



