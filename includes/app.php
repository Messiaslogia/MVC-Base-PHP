<?php

require __DIR__.'/../vendor/autoload.php';


use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

//Carrega variaveis de ambiente
Environment::load(__DIR__.'/../');

//Define as Configurações de Banco de dados
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT') 
);


//Define a constante de URL
define( 'URL', getenv(URL));


//Define o valor padrão das váriavies 
View::init([
    'URL' => URL
]);

?>