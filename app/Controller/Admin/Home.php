<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;


class Home extends Page{
    /*
     * Método responsável por renderizar a view de home no painel
     * @param Request $request
     * @return string
     */
    public static function getHome($request) {
        //RETORNA O CONTEUDO DA HOME
        $content = View::render('admin/modules/home/index', []);
                
        //RETORNA A PÁGINA COMPLETA
                return parent::getPanel('Home >Ramal', $content, 'home');
    }
    
}

