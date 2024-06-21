<?php

namespace Sed\Ramal\Controller\Pages;

use Sed\Ramal\Views\View;

class Page {

    /**
     * Método responsável por renderizar o topo da página
     * @return string
     */
    private static function getHeader() {
        //RENDERIZA BOX DE PESQUISA
        return View::render('pages/header', [
            'SEARCH' => View::render('pages/ramal/search', [
                'search' => ''
            ])
        ]);

    }

    /**
     * Método responsável por renderizar o rodapé da página
     * @return string
     */
    private static function getFooter() {
        return View::render('pages/footer');
    }

    /**
     * Método responsável por renderizar o layout de paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination) {
        //PÁGINAS
        $pages = $obPagination->getPages();
        
        //VERIFICA A QUANTIDADES DE PÁGINAS
        if(count($pages) <= 1) return '';
        
        //RECEBE OS LINKS DA PAGINAÇÃO
        $links = '';
        
        //URL ATUAL (SEM GETS)
        $url = $request->getRouter()->getCurentUrl();
        
        //GET
        $queryParams = $request->getQueryParams();
        
        //RENDERIZA OS LINKS
        foreach ($pages as $page) {
            //ALTERA A PÁGINA
            $queryParams['page'] = $page['page'];
            
            //LINK
            $link = $url.'?'. http_build_query($queryParams);
            
            //VIEW
            $links .= View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }
        
        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('pages/pagination/box', [
            'links' => $links
        ]);
    }
    
    /**
     * Método responsável por retornar o conteúdo (através do model e view) da página genérica
     * @return string
     */
    public static function getPage($title, $content) {
        return View::render('pages/page', [
                    'title' => $title,
                    'header' => self::getHeader(),
                    'content' => $content,
                    'footer' => self::getFooter()
        ]);
    }

}
