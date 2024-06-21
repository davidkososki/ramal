<?php

namespace Sed\Ramal\Controller\Admin;

use Sed\Ramal\Views\View;

class Page{
    /*
     * Método responsável por retornar o conteúdo (vview) da estrutura genérica de página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static $modules = [
        'ramal' => [
            'label' => 'Ramal',
            'link' => URL.'/admin/ramais'
        ],
        'gerencia' => [
            'label' => 'Gerência',
            'link' => URL.'/admin/gerencia'
        ],
        'diretoria' => [
            'label' => 'Diretoria',
            'link' => URL.'/admin/diretoria'
        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL.'/admin/users'
        ]
    ];
    
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
            $links .= View::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }
        
        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('admin/pagination/box', [
            'links' => $links
        ]);
    }
    
    /*
     * Método responsável por retornar o conteúdo (vview) da estrutura genérica de página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content) {
        return View::render('admin/page',[
            'title' => $title,
            'content'  => $content
        ]);
    }
    
    /*
     * Método responsável por retornar o conteúdo (vview) da estrutura genérica de página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getMenu($currentModule) {
        //LINKS DO MENU
        $links = '';
        
        //ITERA OS MÓDULOS
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link',[
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }

        //RETORNA A RENDERIZAÇÃO DO MENU
        return View::render('admin/menu/box',[
            'links' => $links
        ]);
    }
    
    /*
     * Método responsável por renderizar a view do painel com conteúdos dinâmicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule) {
        //RENDERIZA A VIEW DO PAINEL
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);
        //RETORNA A PÁGINA RENDERIZADA
        return self::getPage($title, $contentPanel);
    }
    
    

}

