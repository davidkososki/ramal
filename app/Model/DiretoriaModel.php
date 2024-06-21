<?php
namespace Sed\Ramal\Model;

use WilliamCosta\DatabaseManager\Database;

class DiretoriaModel{
    

    public $id_diretoria;

    public $nome_diretoria;

    public $sigla_diretoria;


    
    /*
     * Nétodo responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar() {
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');
        
        //INSERE OS DADOS NA TABELA diretorias
        $this->id = (new Database('diretoria'))->insert([
            'nome_diretoria' => $this->nome_diretoria,
            'sigla_diretoria' => $this->sigla_diretoria
        ]);
        return true;
    }
    
    /*
     * Nétodo responsável por atualizar os dados com a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar() {
         
        //ATUALIZA OS DADOS NA TABELA diretorias
        return (new Database('diretoria'))->update('id_diretoria ='.$this->id_diretoria, [
            'nome_diretoria' => $this->nome_diretoria,
            'sigla_diretoria' => $this->sigla_diretoria
        ]);

    }
    
    /*
     * Método responsável por retornar um diretoria com bse no id
     * @param integer $id
     * @return Testimony
     */
    public static function getDiretoriaById($id){

        return self::getDiretoria('id_diretoria = '.$id)->fetchObject(self::class);
    }
    
    /*
     * Método responsável por retornar Diretorias
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function getDiretoria($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('diretoria'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Método responsável por retornar todas as diretorias
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function getAllDiretoria() {
        return (new Database('diretoria'))->select();
    }
    
    /*
     * Método responsável pesguisar diretoria
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function searchDiretoria($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('diretoria'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Nétodo responsável por excluir diretoria do banco de dados
     * @return boolean
     */
    public function excluir() {
        
        //EXCLUI O DIRETORIA DO BANCO DE DADOS
        return (new Database('diretoria'))->delete('id_diretoria ='.$this->id_diretoria);

    }
    
    
}