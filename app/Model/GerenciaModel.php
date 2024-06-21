<?php
namespace Sed\Ramal\Model;

use WilliamCosta\DatabaseManager\Database;

class GerenciaModel{
    

    public $id_gerencia;

    public $nome_gerencia;

    public $sigla_gerencia;

    public $id_diretoria_gerencia;


    
    /*
     * Nétodo responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar() {
        
        //INSERE OS DADOS NA TABELA depoimentos
        $this->id_gerencia = (new Database('gerencia'))->insert([
            'nome_gerencia' => $this->nome_gerencia,
            'sigla_gerencia' => $this->sigla_gerencia,
            'id_diretoria_gerencia' => $this->id_diretoria_gerencia
        ]);
        return true;
    }
    
    /*
     * Nétodo responsável por atualizar os dados com a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar() {
         
        //ATUALIZA OS DADOS NA TABELA depoimentos
        return (new Database('gerencia'))->update('id_gerencia ='.$this->id_gerencia, [
            'nome_gerencia' => $this->nome_gerencia,
            'sigla_gerencia' => $this->sigla_gerencia,
            'id_diretoria_gerencia' => $this->id_diretoria_gerencia
        ]);

    }
    
    /*
     * Método responsável por retornar um depoimento com bse no id
     * @param integer $id
     * @return Testimony
     */
    public static function getGerenciaById($id){

        return self::getGerencia('id_gerencia = '.$id)->fetchObject(self::class);
    }
    
    /*
     * Método responsável por retornar Depoimentos
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function getGerencia($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('gerencia'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Método responsável pesguisar servidores
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function searchGerencia($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('gerencia'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Nétodo responsável por excluir depoimento do banco de dados
     * @return boolean
     */
    public function excluir() {
        
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('gerencia'))->delete('id_gerencia ='.$this->id_gerencia);

    }
    
    
}