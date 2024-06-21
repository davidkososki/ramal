<?php

/* 
 * Arquivo de configurações
 */

//PSR-4 autoloading configured. Use "namespace  Sed/Ramal;" in src/

require __DIR__ . '/../vendor/autoload.php';


use Sed\Ramal\Views\View;
use WilliamCosta\DotEnv\Environment;
use WilliamCosta\DatabaseManager\Database;
use Sed\Ramal\Http\Middleware\Queue as MiddlewareQueue;


//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__.'/../');

//DEFINE AS CONFIGURAÇÕES DE BANCO DE DADOS
Database::config(getenv('DB_HOST'), getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_PORT'));


//DEFINE A CONSTANTE DA URL
define('URL', getenv('URL'));

//DEFINE O VALOR DAS VARIÁVEIS
View::init([
    'URL' => URL
]);

//DEFINE O MAPEAMENO DE MIDDLEWARES
MiddlewareQueue::setMap([
    'maintenance' =>  Sed\Ramal\Http\Middleware\Maintenance::class,
    'require-admin-logout' =>  Sed\Ramal\Http\Middleware\RequireAdminLogout::class,
    'require-admin-login' =>  Sed\Ramal\Http\Middleware\RequireAdminLogin::class,
    'api' =>  Sed\Ramal\Http\Middleware\Api::class
        
]);

//DEFINE O MAPEAMENO DE MIDDLEWARES PADRÕES
MiddlewareQueue::setDefault([
    'maintenance'
]);

