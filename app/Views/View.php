<?php

/*
 * Classe para gerenciar as views
 */

namespace Sed\Ramal\Views;

class View {
    
    /*
     *Variáveis padrão da view. 
     */
    private static $vars = [];
    
    /*
     * Método responsável por retornar o conteúdo de uma view
     * @param array $vars
     * @return string
     */
    public static function init($vars = []) {
        self::$vars = $vars;
    }
/*
     * Método responsável por retornar o conteúdo de renderizado de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView($view) {
        $file = __DIR__ . '/../Views/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : ""; // se o arquivo existir retorna o conteúdo
    }

    /*
     * Método responsável por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars (string/numéricos)
     * @return string
     */
    public static function render($view, $vars = []) {
        //CONTEÚDO DA VIEW
        $contentView = self::getContentView($view);
        
        //MERGE DE VARIÁVEIS
        $vars = array_merge(self::$vars, $vars);

        //chaves do array de variaveis
        $keys = array_keys($vars);
        $keysMap = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);
//            echo '<pre>';
//            print_r($keysMap);
//            echo '</pre>';exit;
        //retorna o conteúdo renderizado
        return str_replace($keysMap, array_values($vars), $contentView); //chaves da variáveis, valores, conteúdo   
    }

}
