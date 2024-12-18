<?php
require __DIR__.'/includes/app.php';


use Sed\Ramal\Http\Router; 


//INICIA O ROUTER
$obRouter = new Router(URL);

//INCLUI AS ROTAS DE PÁGINAS
include __DIR__.'/routes/pages.php';

//INCLUI AS ROTAS DO PAINEL
include __DIR__.'/routes/admin.php';

//INCLUI AS ROTAS DA API
include __DIR__.'/routes/api.php';


//IMPRIME O RESPONSE DA ROTA
$obRouter->run()->sendResponse();