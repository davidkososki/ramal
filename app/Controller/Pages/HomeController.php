<?php

namespace Sed\Ramal\Controller\Pages;

use Sed\Ramal\Views\View;
use Sed\Ramal\Model\Organization;

class HomeController extends Page {

    /**
     * Método responsável por retornar o conteúdo (através do model e view) da home
     * @return string
     */
    public static function getHome() {
        //Organização
        $obOrganization = new Organization;
        //            echo '<pre>';
        //            print_r($obOrganization);
        //            echo '</pre>';
        //view da home
        $content = View::render('Pages/home', [
                    'name' => $obOrganization->name
        ]);

        //retorna a view da página
        return parent::getPage('Home', $content);
    }

}
